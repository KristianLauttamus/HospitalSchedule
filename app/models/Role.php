<?php

class Role extends BaseModel
{
    public $id, $name, $admin;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_with_length:name,Name,5');
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM roles');
        $query->execute();

        // Fetch all rows from the query
        $rows  = $query->fetchAll();
        $roles = array();

        // Go through rows
        foreach ($rows as $row) {
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

        $this->id = $row['id'];
    }
}
