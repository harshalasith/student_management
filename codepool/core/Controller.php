<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Controller
 */
class Controller
{
    /**
     * @var SessionHandler
     */
    protected $sessionHandler;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->sessionHandler = Session::getInstance();
    }

    /**
     * @param $modelName
     * @return mixed
     */
    public function loadModel($modelName)
    {
        require_once APP . 'model/' . $modelName . '.php';
        return new $modelName();
    }

    /**
     * @param $viewPath
     */
    public function renderPage($viewPath, $data = [])
    {
        require APP . 'view/base/header.php';
        require APP . 'view/' . $viewPath . '.php';
        require APP . 'view/base/footer.php';
    }

    /**
     * @return SessionHandler
     */
    public function getSessionHandler()
    {
        return $this->sessionHandler;
    }
}
