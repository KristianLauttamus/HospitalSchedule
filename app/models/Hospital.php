<?php

class Hospital extends BaseModel
{
    protected $table = 'hospitals';

    public $id, $name, $open_time, $close_time;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_with_length:name,Name,2');
    }

    public function isOpen()
    {
        $open  = DateTime::createFromFormat('HH', $this->open_time);
        $close = DateTime::createFromFormat('HH', $this->close_time);
        $now   = new DateTime("now");
        return $now >= $open && $now <= $close;
    }

    // Find all
    public static function all()
    {
        // Lets use our DB connection and execute our query
        $query = DB::connection()->prepare('SELECT * FROM hospitals ORDER BY id');
        $query->execute();

        // Fetch all rows from the query
        $rows      = $query->fetchAll();
        $hospitals = array();

        // Go through rows
        foreach ($rows as $row) {
            $hospitals[] = new Hospital(array(
                'id'         => $row['id'],
                'name'       => $row['name'],
                'open_time'  => $row['open_time'],
                'close_time' => $row['close_time'],
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
                'id'         => $row['id'],
                'name'       => $row['name'],
                'open_time'  => $row['open_time'],
                'close_time' => $row['close_time'],
            ));

            return $hospital;
        }

        return null;
    }

    public static function findWithImportanceRelations($id)
    {
        $query = DB::connection()->prepare('
            SELECT hosp.*, h.*, hu.*, u.*, r.*, ir.*, i.* FROM hospitals hosp
                INNER JOIN hours AS h
                    ON h.hospital_id = hosp.id
                LEFT OUTER JOIN hour_users AS hu
                    ON h.id = hu.user_id
                INNER JOIN users AS u
                    ON hu.user_id = u.id
                INNER JOIN roles AS r
                    ON u.role_id = r.id
                INNER JOIN importances AS i
                    ON h.importance_id = i.id
                INNER JOIN importance_roles AS ir
                    ON i.id = ir.importance_id
            WHERE hosp.id = :id
        ');
        $query->execute(array('id' => $id));
        var_dump($query->fetch());
    }

    // Save
    public function save()
    {
        $query = DB::connection()->prepare('INSERT INTO hospitals (name, open_time, close_time) VALUES (:name, :openTime, :closeTime) RETURNING id');
        $query->execute(array('name' => $this->name, 'openTime' => $this->open_time, 'closeTime' => $this->close_time));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
        $this->id = $row['id'];
    }

    // Update
    public function update()
    {
        $query = DB::connection()->prepare('UPDATE hospitals SET (name, open_time, close_time) = (:name, :openTime, :closeTime) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'openTime' => $this->open_time, 'closeTime' => $this->close_time));
    }

    // TODO: Add Users to Hospital
    public static function addUsers($allocations)
    {
        $query  = DB::connection()->prepare('INSERT INTO hour_users (user_id, open_time, close_time) VALUES (:name, :openTime, :closeTime) RETURNING id');
        $values = '(';
        foreach ($allocations as $allocation) {
            if ($allocation['role_id']) {

            }
            $values += $allocation['user_id']+','+$allocation['hour_id'];

            $values += '),';
        }
    }
}
