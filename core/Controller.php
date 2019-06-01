<?php


namespace core;

/**
 * Class Controller
 * @package core
 */
abstract class Controller {

    /**
     * @var array
     */
    public $route = [];

    /**
     * @var string
     */
    public $layout='default';

    /**
     * @var array
     */
    public $vars=[];


    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route) {
        $this->route = $route;
    }

    /**
     * @param string $view
     */
    public function renderView($view='') {
        $view = $view ?: $this->route['action'];
        $objView = new View($this->route['controller'], $view, $this->layout);
        $objView->render($this->vars);
    }

    /**
     * @param array $vars
     */
    public function setVars($vars) {
        $this->vars = $vars;
    }

    /**
     * @param string $to
     */
    public function redirect($to='') {
        header("Location: /$to");
        exit();
    }
}