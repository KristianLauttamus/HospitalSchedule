<?php

class User extends BaseModel
{
    public $id, $name, $email, $password, $role_id;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function all()
    {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM users');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows  = $query->fetchAll();
        $users = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $users[] = new User(array(
                'id'       => $row['id'],
                'name'     => $row['name'],
                'email'    => $row['email'],
                'password' => $row['password'],
                'role_id'  => $row['role_id'],
            ));
        }

        return $users;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id'       => $row['id'],
                'name'     => $row['name'],
                'email'    => $row['email'],
                'password' => $row['password'],
                'role_id'  => $row['role_id'],
            ));

            return $user;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id) RETURNING id');
        $query->execute(array('name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'role_id' => $this->role_id));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }
}
