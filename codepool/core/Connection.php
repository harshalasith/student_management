<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Connection
 */
class Connection
{
    /**
     * config xml path
     */
    const CONFIG_FILE_PATH = APP . 'etc/config.xml';

    /**
     * @var
     */
    private static $instance;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var null
     */
    private $config = null;

    /**
     * @var ConfigReader|null
     */
    private $configReader = null;

    /**
     * Connection constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $this->configReader = new ConfigReader();
        try {
            $this->loadConfigData();

            if ($this->connection === null) {
                $options = array(
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                );
                $this->connection = new PDO($this->config->database->db_type . ':host=' . $this->config->database->db_host . ';dbname=' . $this->config->database->db_name . ';charset=' . $this->config->database->db_charset,
                    $this->config->database->db_user, $this->config->database->db_password, $options);
            }
        } catch (PDOException $e) {
            throw new Exception('Database connection could not be established.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Load config data from xml file
     */
    private function loadConfigData()
    {
        $xml = $this->configReader->readXmlFile(self::CONFIG_FILE_PATH);
        $this->config = $xml;

        if (empty($this->config->database->db_type)) {
            throw new Exception('No connection type configured to connect. eg: mysql');
        }

        if (empty($this->config->database->db_host)) {
            throw new Exception('No database host configured to connect');
        }

        if (empty($this->config->database->db_name)) {
            throw new Exception('No database name configured to connect');
        }

        if (empty($this->config->database->db_user)) {
            throw new Exception('No database user name configured to connect');
        }

        if (empty($this->config->database->db_password)) {
            throw new Exception('No database user password configured to connect');
        }
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
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}