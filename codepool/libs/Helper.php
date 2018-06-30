<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Helper
 */
class Helper
{
    /**
     * @param $name
     * @param string $replace
     * @param string $separator
     * @return mixed
     */
    public function convertToCamelCase($name, $replace = '', $separator = '_')
    {
        $camelName = str_replace($separator, $replace, ucwords($name, $separator));
        return $camelName;
    }
}