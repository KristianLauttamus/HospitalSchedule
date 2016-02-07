<?php

class Role extends BaseModel
{
    public $id, $name, $admin;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function all()
    {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM roles');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows  = $query->fetchAll();
        $roles = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $roles[] = new Role(array(
                'id'    => $row['id'],
                'name'  => $row['name'],
                'admin' => $row['admin'],
            ));
        }

        return $roles;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM roles WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $role = new User(array(
                'id'    => $row['id'],
                'name'  => $row['name'],
                'admin' => $row['admin'],
            ));

            return $role;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO roles (name, admin) VALUES (:name, :admin) RETURNING id');
        $query->execute(array('name' => $this->name, 'admin' => $this->admin));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }
}
