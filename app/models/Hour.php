<?php

class Hour extends BaseModel
{
    protected $table = 'hours';

    public $id, $at, $hospital_id, $importance_id;

    public $importance = null;
    public $hospital   = null;
    public $users      = array();

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM hours');
        $query->execute();

        // Fetch all rows from the query
        $rows  = $query->fetchAll();
        $hours = array();

        // Go through rows
        foreach ($rows as $row) {
            $hours[] = new Hour(array(
                'id'            => $row['id'],
                'at'            => $row['at'],
                'hospital_id'   => $row['hospital_id'],
                'importance_id' => $row['importance_id'],
            ));
        }

        return $hours;
    }

    // Find one with id
    public static function find($id)
    {
        $query = DB::connection()->prepare('SELECT * FROM hours WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $hour = new Hour(array(
                'id'            => $row['id'],
                'at'            => $row['at'],
                'hospital_id'   => $row['hospital_id'],
                'importance_id' => $row['importance_id'],
            ));

            return $hour;
        }

        return null;
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO hours (at, hospital_id, importance_id) VALUES (:at, :hospital_id, :importance_id) RETURNING id');
        $query->execute(array('at' => $this->at, 'hospital_id' => $this->hospital_id, 'importance_id' => $this->importance_id));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }

    // Update
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE hours (at, hospital_id, importance_id) VALUES (:at, :hospital_id, :importance_id) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'at' => $this->at, 'hospital_id' => $this->hospital_id, 'importance_id' => $this->importance_id));
    }
}
