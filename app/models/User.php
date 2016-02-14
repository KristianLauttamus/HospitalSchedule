<?php

class User extends BaseModel
{
    public $id, $name, $email, $password, $role_id;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_with_length:name,Name,4', 'validate_relation_by_id:role_id,' . $attributes['role_id'], 'validate_email:email,true,users,email');
    }

    // Authenticate
    public static function authenticate($email, $username)
    {
        $query = DB::connection()->prepare('SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            return new User($row[0]);
        } else {
            return null;
        }
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM users');
        $query->execute();

        // Fetch all rows from the query
        $rows  = $query->fetchAll();
        $users = array();

        // Go through rows
        foreach ($rows as $row) {
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
