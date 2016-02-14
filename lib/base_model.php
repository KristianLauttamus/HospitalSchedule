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

    public function errors()
    {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        }

        return $errors;
    }

    public function validate_name()
    {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Name is required!';
        }
        if (strlen($this->name) < 2) {
            $errors[] = 'Name needs to be atleast 2 characters long!';
        }

        return $errors;
    }

    public function validate_relation_by_id($relation, $table, $empty = true)
    {
        $relation = $this->$relation;
        if ($empty && $relation == '') {
            return [];
        }

        $query = DB::connection()->prepare('SELECT * FROM ' . $table . ' WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $relation));
        $row = $query->fetch();
        if ($row) {
            return [];
        } else {
            $errors[] = "That role doesn't exist";

            return $errors;
        }
    }
}
