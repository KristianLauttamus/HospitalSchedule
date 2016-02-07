<?php

class Hospital extends BaseModel
{
    public $id, $name;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function all()
    {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM hospitals');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows      = $query->fetchAll();
        $hospitals = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $hospitals[] = new Hospital(array(
                'id'   => $row['id'],
                'name' => $row['name'],
            ));
        }

        return $hospitals;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM hospitals WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $hospital = new Hospital(array(
                'id'   => $row['id'],
                'name' => $row['name'],
            ));

            return $hospital;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO hospitals (name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }
}
