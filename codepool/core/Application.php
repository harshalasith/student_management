<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

class Application
{
    /**
     * @var null
     */
    private $controller = null;

    /**
     * @var null
     */
    private $action = null;

    /**
     * @var array
     */
    private $params = array();


    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->resolveRequestUri();
        if (!$this->controller) {

            require APP . 'controller/Student.php';
            $page = new Student();
            $page->index();

        } elseif (file_exists(APP . 'controller/' . $this->controller . '.php')) {
            require APP . 'controller/' . $this->controller . '.php';
            $this->controller = new $this->controller();

            // Check given controller action exists
            if (method_exists($this->controller, $this->action)) {
                $this->controller->{$this->action}();
            } else {
                if (empty($this->action)) {
                    $this->controller->index();
                } else {
                    $this->pageNotFound();
                }
            }
        } else {
            $this->pageNotFound();
        }
    }

    /**
     * 404 page
     */
    public function pageNotFound()
    {
        header('location: ' . URL . '404.html');
    }

    /**
     * @throws Exception
     */
    private function resolveRequestUri()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri[0] !== '/') {
                $requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $requestUri);
            }
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            throw new Exception('Unable to determine the request URI.');
        }
        $requestUri = trim($requestUri, '/');
        $requestUri = filter_var($requestUri, FILTER_SANITIZE_URL);
        $requestUri = explode('/', $requestUri);
        $this->controller = ucfirst(isset($requestUri[0]) ? $requestUri[0] : null);
        $this->action = ucfirst(isset($requestUri[1]) ? $requestUri[1] : null);
        unset($requestUri[0], $requestUri[1]);
        $this->params = array_values($requestUri);
    }
}
