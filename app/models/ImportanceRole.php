<?php

class ImportanceRole extends BaseModel
{
    protected $table = 'importance_roles';

    public $id, $importance_id, $role_id, $needed;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM importance_roles');
        $query->execute();

        // Fetch all rows from the query
        $rows        = $query->fetchAll();
        $importances = array();

        // Go through rows
        foreach ($rows as $row) {
            $importances[] = new ImportanceRole(array(
                'id'            => $row['id'],
                'needed'        => $row['needed'],
                'importance_id' => $row['importance_id'],
                'role_id'       => $row['role_id'],
            ));
        }

        return $importances;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM importance_roles WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $importance = new ImportanceRole(array(
                'id'            => $row['id'],
                'needed'        => $row['needed'],
                'importance_id' => $row['importance_id'],
                'role_id'       => $row['role_id'],
            ));

            return $importance;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO importance_roles (needed, importance_id, role_id) VALUES (:needed, :importance_id, :role_id) RETURNING id');
        $query->execute(array('needed' => $this->needed, 'importance_id' => $this->importance_id, 'role_id' => $this->role_id));
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
