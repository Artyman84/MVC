<?php


namespace core;

/**
 * Class Model
 * @package core
 */
abstract class Model {

    /**
     * @var Db
     */
    private $pdo;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $pk;

    /**
     * @var array
     */
    protected $errors = [];


    /**
     * @param array $data
     * @return bool
     */
    abstract protected function validate($data);


    /**
     * Model constructor.
     */
    protected function __construct() {
        $this->pdo = Db::inst();
    }

    /**
     * @return Model
     */
    public static function model(){
        $modelName = get_called_class();
        return new $modelName();
    }

    /**
     * @param int$id
     * @return array|null
     */
    public function findOne($id) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->pk}` = ?";
        $rows = $this->pdo->query($sql, [$id]);

        return isset($rows[0]) ? $rows[0] : null;
    }

    /**
     * @param null|array $orderBy
     * @param null|int $limit
     * @param null|int $offset
     * @return array
     */
    public function findAll($orderBy=null, $limit=null, $offset=null) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `{$this->table}`";

        if( !empty( $orderBy ) && is_array($orderBy) ) {
            $orderByPieces = [];
            foreach ( $orderBy as $field => $direction ) {
                $orderByPieces[] = "`$field` $direction";
            }

            $sql .= " ORDER BY " . implode(",", $orderByPieces);
        }

        $limit = (int)$limit;
        $offset = (int)$offset;

        if( $limit ) {
            $sql .= " LIMIT $offset, $limit";
        }

        $rows = $this->pdo->query($sql);
        $found_rows = $this->pdo->query('SELECT FOUND_ROWS() AS found_rows');


        return [$rows, $found_rows[0]['found_rows']];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create($data) {
        if( $this->validate($data) ) {
            $fields = implode('`, `', array_keys($data));
            $params = implode(',', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO `{$this->table}` (`$fields`) VALUES ($params)";
            $this->pdo->execute($sql, array_values($data));

            return true;
        }

        return false;
    }


    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update($data, $id) {
        if( $this->validate($data) ) {
            $fields = [];
            foreach ($data as $field => $value) {
                $fields[] = "`$field` = :$field";
            }

            $fields = implode(",", $fields);
            $data['id'] = $id;

            $sql = "UPDATE `{$this->table}` SET $fields WHERE `id` = :id";
            $this->pdo->execute($sql, $data);

            return true;
        }

        return false;
    }


    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}