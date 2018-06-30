<?php

/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */
class RequiredValidator extends Validator
{
    /**
     * RequiredValidator constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->message = " is required.";
    }

    /**
     * @param $value
     * @return null|string|void
     */
    protected function validateValue($value)
    {
        if (!empty(is_string($value) ? trim($value) : $value)) {
            return null;
        } else {
            return $this->message;
        }
    }
}
