<?php

namespace core;

use PDO;

/**
 * Class Db
 * @package core
 */
class Db {

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Db
     */
    private static $inst;

    /**
     * Db constructor.
     */
    private function __construct() {
        $db = require ROOT . '/config/db.php';
        $this->pdo = new PDO($db['dsn'], $db['user'], $db['password']);
    }

    /**
     * @return Db
     */
    public static function inst() {
        if( null === self::$inst ) {
            self::$inst = new self;
        }

        return self::$inst;
    }

    /**
     * @param string $sql
     * @param null|array $params
     * @return bool
     */
    public function execute($sql, $params=null) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * @param string $sql
     * @param null|array $params
     * @return array
     */
    public function query($sql, $params=null) {
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);

        if( false !== $res ) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
}