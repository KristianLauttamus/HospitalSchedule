<?php

class Importance extends BaseModel
{
    protected $table = 'importances';

    public $id, $importance_roles;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function allWithRoles()
    {
        // Importances
        $query = DB::connection()->prepare('SELECT * FROM importances');
        $query->execute();
        $rows        = $query->fetchAll();
        $importances = array();

        foreach ($rows as $row) {
            $importances[$row['id']] = new Importance(array(
                'id' => $row['id'],
            ));
        }

        // Roles
        $query = DB::connection()->prepare('SELECT * FROM roles');
        $query->execute();
        $rows  = $query->fetchAll();
        $roles = array();

        foreach ($rows as $row) {
            $roles[$row['id']] = new Role(array(
                'id'    => $row['id'],
                'name'  => $row['name'],
                'admin' => $row['admin'],
            ));
        }

        // Importance_Role
        $query = DB::connection()->prepare('SELECT * FROM importance_roles');
        $query->execute();
        $rows            = $query->fetchAll();
        $importanceRoles = array();

        foreach ($rows as $row) {
            $importances[$row['importance_id']]->importance_roles[] = array(
                'needed' => $row['needed'],
                'role'   => $roles[$row['role_id']],
            );
        }

        return $importances;
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM importances');
        $query->execute();

        // Fetch all rows from the query
        $rows        = $query->fetchAll();
        $importances = array();

        // Go through rows
        foreach ($rows as $row) {
            $importances[] = new Importance(array(
                'id' => $row['id'],
            ));
        }

        return $importances;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM importances WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $importance = new Importance(array(
                'id' => $row['id'],
            ));

            return $importance;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO importances DEFAULT VALUES RETURNING id');
        $query->execute();
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }

    // Update
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE hospitals WHERE id = :id');
        $query->execute(array('id' => $id));
    }
}
