<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Validator
 */
class Validator
{
    /**
     * @var
     */
    public $message;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Validator constructor.
     */
    public function __construct()
    {
        $this->helper = new Helper();
    }

    /**
     * @param $value
     * @param null $error
     * @return bool
     */
    public function validate($value, &$error = null)
    {
        $result = $this->validateValue($value);
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $value
     */
    protected function validateValue($value)
    {
        //TO do
    }

    /**
     * @param $model
     * @param $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $method = 'get' . $this->helper->convertToCamelCase($attribute);
        $value = $model->$method();
        $result = $this->validateValue($value);
        if (!empty($result)) {
            $model->addError($attribute, $result);
        }
    }
}
