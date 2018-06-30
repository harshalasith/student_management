<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Connection
 */
class Session
{

    /**
     * @var
     */
    private static $instance;

    /**
     * SessionHandler constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * @return Connection
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * add session data by key
     * @param $key
     * @param $value
     */
    public function setSessionData($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get session data by key
     * @param $key
     * @return null
     */
    public function getSessionData($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * clear session data by key
     */
    public function clearSessionData($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}