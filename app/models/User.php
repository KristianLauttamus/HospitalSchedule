<?php

class User extends BaseModel
{
    protected $table = 'users';

    public $id, $name, $email, $password, $role_id;

    public $role;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_with_length:name,Name,4', 'validate_relation_by_id:role_id,roles,' . $attributes['role_id'], 'validate_email:email,true,users,email');
    }

    // Authenticate
    public static function authenticate($email, $password)
    {
        $query = DB::connection()->prepare('SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();

        if ($row) {
            return new User(array(
                'id'      => $row['id'],
                'name'    => $row['name'],
                'email'   => $row['email'],
                'role_id' => $row['role_id'],
            ));
        } else {
            return null;
        }
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM users ORDER BY id');
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

    // Find all
    public static function allWithRoles()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM users ORDER BY id');
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
                'role'     => null,
            ));

            return $user;
        }

        return null;
    }

    // Find one with id and include role -relation
    public static function findWithRole($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row     = $query->fetch();
        $roleRow = null;

        if (isset($row['role_id']) && $row['role_id'] != null) {
            $query = DB::connection()->prepare('SELECT * FROM roles WHERE id = :id LIMIT 1');
            $query->execute(array('id' => $row['role_id']));
            $roleRow = $query->fetch();
        }

        if ($row) {
            if ($roleRow) {
                $user = new User(array(
                    'id'      => $row['id'],
                    'name'    => $row['name'],
                    'email'   => $row['email'],
                    'role_id' => $row['role_id'],
                    'role'    => new Role(array(
                        'id'    => $roleRow['id'],
                        'name'  => $roleRow['name'],
                        'admin' => $roleRow['admin'],
                    )),
                ));
            } else {
                $user = new User(array(
                    'id'      => $row['id'],
                    'name'    => $row['name'],
                    'email'   => $row['email'],
                    'role_id' => $row['role_id'],
                    'role'    => null,
                ));
            }

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

    // Update
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE users SET (name, email, password, role_id) = (:name, :email, :password, :role_id) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'role_id' => $this->role_id));
    }
}
