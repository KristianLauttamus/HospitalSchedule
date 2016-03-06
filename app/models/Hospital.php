<?php

class Hospital extends BaseModel
{
    protected $table = 'hospitals';

    public $id, $name, $open_time, $close_time;

    public $hours = null;

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

    /**
     * Find with all relations
     */
    public static function findWithRelations($id)
    {
        return Hospital::findWithRelationsUseTimes($id, 1, 24);
    }

    public static function findOpenWithRelations($id)
    {
        $query = DB::connection()->prepare('
            SELECT ho.*, h.*, u.*, i.*, ir.* FROM hospitals ho
                LEFT OUTER JOIN hours AS h
                    ON h.hospital_id = ho.id
                        AND h.at >= h.open_time
                        AND h.at <= h.close_time
                LEFT OUTER JOIN hour_users AS hu
                    ON hu.hour_id = h.id
                LEFT OUTER JOIN users AS u
                    ON hu.user_id = u.id
                LEFT OUTER JOIN importances AS i
                    ON h.importance_id = i.id
                LEFT OUTER JOIN importance_roles AS ir
                    ON i.id = ir.importance_id
            WHERE ho.id = 1
        ');
        $query->execute(array('id' => $id));
        $results = $query->fetch();

        if ($results) {
            $hospital = new Hospital(array_splice($results[0], 4));

            $hospital->addRelations($results);

            return $hospital;
        }

        return null;
    }

    /**
     * Use given opening time and closing time to perform the query and return the model with relations
     */
    public static function findWithRelationsUseTimes($id, $opentime, $closetime)
    {
        $query = DB::connection()->prepare('
            SELECT ho.*, h.*, u.*, r.*, i.*, ir.* FROM hospitals ho
                LEFT OUTER JOIN hours AS h
                    ON h.hospital_id = ho.id
                        AND h.at >= :opentime
                        AND h.at <= :closetime
                LEFT OUTER JOIN hour_users AS hu
                    ON hu.hour_id = h.id
                LEFT OUTER JOIN users AS u
                    ON hu.user_id = u.id
                LEFT OUTER JOIN importances AS i
                    ON h.importance_id = i.id
                LEFT OUTER JOIN importance_roles AS ir
                    ON i.id = ir.importance_id
                LEFT OUTER JOIN roles AS r
                    ON r.id = u.role_id
            WHERE ho.id = 1
        ');
        $query->execute(array('id' => $id, 'opentime' => $opentime, 'closetime' => $closetime));
        $results = $query->fetch();

        if ($results) {
            $hospital = new Hospital(array_slice($results[0], 4));

            $hospital->addRelations($results);

            return $hospital;
        }

        return null;
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

    /**
     * Add relations from returned database query
     */
    public function addRelations($relations)
    {
        $importances     = array();
        $importanceRoles = array();
        $hours           = array();
        $users           = array();

        foreach ($relations as $row) {
            $hospital        = array_splice($row, 4);
            $hour            = array_splice($row, 4);
            $user            = array_splice($row, 5);
            $role            = array_splice($row, 4);
            $importance      = array_splice($row, 1);
            $importance_role = array_splice($row, 4);

            // Importance
            if (isset($importance['id']) && !isset($importances[$importance['id']])) {
                $importances[$importance['id']] = new Importance($importance);
            }

            // ImportanceRole's
            if (isset($importance_role['id']) && !isset($importanceRoles[$importance_role['id']])) {
                $importanceRoles[$importance_role['id']] = new ImportanceRole($importance_role);

                if (isset($importance_role['importance_id']) && isset($importances[$importance_role['importance_id']])) {
                    $importance[$importance_role['importance_id']]->roles[] = $importanceRoles[$importance_role['id']];
                    $importanceRoles[$importance_role['id']]->importance    = $importances[$importance_role['importance_id']];
                }
            }

            // User
            if (isset($user['id']) && !isset($users[$user['id']])) {
                $users[$user['id']] = new User($user);
            }

            // Role
            if (isset($role['id'])) {
                if (!isset($roles[$role['id']])) {
                    $roles[$role['id']] = new Role($role);
                }

                if (isset($user['id']) && isset($user['role_id']) && $role['id'] == $user['role_id']) {
                    $users[$user['id']]->role = $roles[$role['id']];
                }
            }

            if (isset($hours[$hour['id']])) {
                $hours[$hour['id']]->users = $users;
            } else {
                $hours[$hour['id']] = new Hour($hour);
                $users              = array();
            }

            $hours[count($hours) - 1]->addUsers();
            $hours[count($hours) - 1]->addUsers();
        }
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
