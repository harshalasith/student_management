<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

class ConfigReader
{
    /**
     * @param $xmlFilePath
     * @return SimpleXMLElement
     */
    public function readXmlFile($xmlFilePath)
    {
        $xml = simplexml_load_file($xmlFilePath);
        return $xml;
    }
}