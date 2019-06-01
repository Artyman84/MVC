<?php

namespace core;


/**
 * Class Request
 * @package core
 */
class Request {


    /**
     * @param string $name
     * @param string $type
     * @param null|mixed $default
     * @return mixed|null
     */
    public static function getParam($name, $type='post', $default=null) {
        switch ($type){
            case 'request':
                $params = $_REQUEST;
                break;

            case 'post':
                $params = $_POST;
                break;

            case 'get':
                $params = $_GET;
                break;

            default:
                return $default;
        }

        if( isset($params[$name]) ) {
            return $params[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param string $type
     * @return int|null
     */
    public static function getInt($name, $type='post') {
        return (int)self::getParam($name, $type, 0);
    }

}