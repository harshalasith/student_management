<?php
define('DOC_ROOT', 'web');
define('APP', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'codepool' . DIRECTORY_SEPARATOR);
define('URL', '//'. $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR);

require APP . 'libs/Helper.php';
require APP . 'core/Application.php';
require APP . 'core/Controller.php';
require APP . 'core/Connection.php';
require APP . 'core/Session.php';
require APP . 'model/AbstractModel.php';
require APP . 'libs/ConfigReader.php';
require APP . 'libs/validator/Validator.php';
require APP . 'libs/validator/RequiredValidator.php';

/**
 * application
 */
$app = new Application();
