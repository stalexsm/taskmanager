<?php

require_once 'core/Autoload.php';
require_once 'core/Config.php';
require_once 'core/Policy.php';
require_once 'libs/phpMailer/PHPMailerAutoload.php';

// создаём загрузчик
$loader = new \c\core\Psr4AutoloaderClass;

// регистрируем загрузчик
$loader->register();

// регистрируем базовые директории для префикса пространства имён
$loader->addNamespace('c\classes', __DIR__.'/classes');
$loader->addNamespace('c\core', __DIR__.'/core');


