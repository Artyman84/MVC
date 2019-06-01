<?php

namespace core;

/**
 * Class Router
 */
class Router {

    /**
     * @var array
     */
    private static $routes = [];

    /**
     * @var array
     */
    private static $route = [];

    /**
     * @param string $pattern
     * @param array $route
     */
    public static function add($pattern, $route=[]) {
        self::$routes[$pattern] = $route;
    }

    /**
     * @param string $url
     * @return bool
     */
    private static function matchRoute($url) {
        foreach( self::$routes as $pattern => $route ) {
            if( preg_match("#$pattern#i", $url, $matches) ) {

                foreach ( $matches as $k => $v ) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if( !isset($route['action']) ) {
                    $route['action'] = 'index';
                }

                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    private static function removeQueryString($url) {
        if( $url ) {
            $params = explode('&', $url, 2);
            if( false === strpos($params[0], '=') ) {
                return rtrim($params[0], '/');
            }
        }

        return '';
    }

    public static function dispatch($url) {
        $url = self::removeQueryString($url);

        if( self::matchRoute($url) ) {
            $controller = 'app\controllers\\' . ucfirst(self::$route['controller']) . 'Controller';

            if( class_exists($controller) ) {
                $objController = new $controller(self::$route);
                $action = lcfirst(self::$route['action']) . 'Action';

                if( method_exists($objController, $action) ) {
                    $objController->$action();
                } else {
                    echo "Method <b>$controller::$action</b> not found";
                }

            } else {
                echo "Controller <b>$controller</b> not found";
            }

        } else {
            http_response_code(404);
            require APP . '/views/layouts/404.html';
        }
    }
}