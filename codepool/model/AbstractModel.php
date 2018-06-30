<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class AbstractModel
 */
abstract class AbstractModel
{
    /**
     * @var
     */
    protected $tableName;

    /**
     * @var
     */
    protected $errors;

    /**
     * @var PDO
     */
    public $connection = null;

    /**
     * @var null
     */
    protected $attributes = null;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var RequiredValidator
     */
    protected $validator;

    /**
     * Model constructor.
     * @param $db
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->helper = new Helper();
            $this->validator = new RequiredValidator();
            $this->connection = Connection::getInstance()->getConnection();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Initialize attributes
     */
    public function initAttributes()
    {
        $this->attributes = [];
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        foreach ($this->attributes as $key => $attribute) {
            $value = (isset($data[$key]) ? $data[$key] : '');
            $method = 'set'.$this->helper->convertToCamelCase($key);
            if(is_string($value)) {
                $value = trim($value);
            }
            $this->$method($value);
        }
    }

    /**
     * @return array
     */
    public function load() {
        $sql = "SELECT ".implode(',', array_keys($this->attributes))." FROM ".$this->tableName;
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Validate form data
     * @return bool
     */
    public function validate()
    {
        foreach ($this->attributes as $key => $attribute) {
            $this->validator->validateAttribute($this, $key);
        }
        if (!empty($this->getErrors())) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $attribute
     * @param string $error
     */
    public function addError($attribute, $error = '')
    {
        $errors = $this->getErrors();
        $errors[] = $this->attributes[$attribute]['label'].$error;
        $this->setErrors($errors);
    }

    /**
     * clear data
     */
    public function clear() {
        foreach ($this->attributes as $key => $attribute) {
            $method = 'set'.$this->helper->convertToCamelCase($key);
            $this->$method("");
        }
    }

    /**
     * @return string
     */
    public function save() {
        $cols = [];
        foreach ($this->attributes as $key => $attribute) {
            if($attribute['required']) {
                $method = 'get'.$this->helper->convertToCamelCase($key);
                $parameters[':'.$key] = $this->$method();
                $cols[] = $key;
            }
        }
        $sql = "INSERT INTO ".$this->tableName." (".implode(',', $cols).") VALUES (".implode(',', array_keys($parameters)).")";
        $query = $this->connection->prepare($sql);
        $query->execute($parameters);
        $lastInsertId = $this->connection->lastInsertId();
        return $lastInsertId;
    }
}
