<?php


namespace core;

/**
 * Class Session
 * @package core
 */
class Session {

    /**
     * @var string
     */
    private static $key = 'mvc';

    /**
     * @var Session|null
     */
    private static $inst;


    /**
     * Session constructor.
     */
    private function __construct() {
        if( !isset($_SESSION[self::$key]) ){
            $_SESSION[self::$key] = [];
        }
    }

    /**
     * @return Session
     */
    public static function inst(){
        if( null === self::$inst ) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * @param mixed $name
     * @param mixed $val
     */
    public function setVar($name, $val) {
        $_SESSION[self::$key][$name] = $val;
    }


    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getVar($name, $default=null) {
        if( isset($_SESSION[self::$key][$name]) ) {
            return $_SESSION[self::$key][$name];
        }

        return $default;
    }

    /**
     * @param string $name
     */
    public function unsetVar($name){
        if( isset($_SESSION[self::$key][$name]) ) {
            unset($_SESSION[self::$key][$name]);
        }
    }

}