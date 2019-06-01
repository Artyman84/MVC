<?php


namespace core;

/**
 * Class View
 * @package core
 */
class View {

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $view;

    /**
     * @var string
     */
    public $layout;

    /**
     * View constructor.
     * @param string $path
     * @param string $view
     * @param string $layout
     */
    public function __construct($path, $view, $layout) {
        $this->path = $path;
        $this->view = $view;
        $this->layout = $layout;
    }

    /**
     * @param array $vars
     */
    public function render($vars=[]) {
        extract($vars);
        $file_view = APP . "/views/{$this->path}/{$this->view}.php";

        ob_start();
        if( is_file($file_view) ) {
            require $file_view;
        } else {
            echo "<p>Вид <b>$file_view</b> не найден</p>";
        }
        $content = ob_get_clean();

        $file_layout = APP . "/views/layouts/{$this->layout}.php";

        if (is_file($file_layout)) {
            require $file_layout;
        } else {
            echo "<p>Шаблон <b>$file_layout</b> не найден</p>";
        }
    }
}