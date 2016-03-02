<?php

class BaseModel
{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null)
    {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function destroy()
    {
        if (isset($this->custom_pkey)) {
            $query = DB::connection()->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->custom_pkey . ' = :pkey');
            $query->execute(array('pkey' => $this->{$this->custom_pkey}));
        } else {
            $query = DB::connection()->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
            $query->execute(array('id' => $this->id));
        }
    }

    /**
     *
     * Validation
     *
     */
    public function errors()
    {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            $varray = explode(':', $validator);
            if (isset($varray[1])) {
                array_merge($errors, call_user_func_array(array($this, $varray[0]), explode(',', $varray[1])));
            } else {
                array_merge($errors, $this->{$varray[0]}());
            }
        }

        return $errors;
    }

    public function validate_min_int($param, $translation, $min = 0)
    {
        $errors = array();
        if ($this->{$param} == '' || $this->{$param} == null) {
            $errors[] = ucfirst($translation . ' is required!');
        }
        if ($this->{$param} < $min) {
            $errors[] = ucfirst($translation . ' needs to be atleast ' . $min . '!');
        }

        return $errors;
    }

    public function validate_with_length($param, $translation, $length = 0)
    {
        $errors = array();
        if ($this->{$param} == '' || $this->{$param} == null) {
            $errors[] = ucfirst($translation . ' is required!');
        }
        if (strlen($this->{$param}) < $length) {
            $errors[] = ucfirst($translation . ' needs to be atleast ' . $length . ' characters long!');
        }

        return $errors;
    }

    public function validate_relation_by_id($relation, $table, $empty = true)
    {
        $relation = $this->{$relation};
        if ($empty && $relation == '') {
            return array();
        }

        $query = DB::connection()->prepare('SELECT * FROM ' . $table . ' WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $relation));
        $row = $query->fetch();
        if ($row) {
            return array();
        } else {
            $errors[] = "That role doesn't exist";

            return $errors;
        }
    }

    public function validate_email($param, $unique = false, $table = '', $column = '')
    {
        if (filter_var($this->{$param}, FILTER_VALIDATE_EMAIL)) {
            if ($unique) {
                $query = DB::connection()->prepare('SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :param LIMIT 1');
                $query->execute(array('param' => $param));
                $row = $query->fetch();
                if ($row) {
                    $errors[] = "That email is not unique";

                    return $errors;
                }
            }

            return array();
        } else {
            $errors[] = 'Invalid email address';
            return $errors;
        }
    }
}
