<?php

class Hospital extends BaseModel
{
    protected $table = 'hospitals';

    public $id, $name;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_with_length:name,Name,2');
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM hospitals');
        $query->execute();

        // Fetch all rows from the query
        $rows      = $query->fetchAll();
        $hospitals = array();

        // Go through rows
        foreach ($rows as $row) {
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

    // Update
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE hospitals SET (name) = (:name) WHERE id = :id');
        $query->execute(array('id' => $id, 'name' => $this->name));
    }
}
