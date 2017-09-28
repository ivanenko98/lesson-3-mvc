<?php

//подключаем автозагрузку классов, чтобы не приходилось их подключать постоянно через require_once
require_once '../vendor/autoload.php';

//получаем массив с конфигурациями БД
$config = require('../config/database.php');

/**
 * Создаем экземпляр класса приложения
 *
 * DEPENDENCY INJECTION PATTERN
 * http://designpatternsphp.readthedocs.io/ru/latest/Structural/DependencyInjection/README.html
 */
$application = new \app\Application($config);
//don't do it here!!! - $application->config = $config; ==> USE DEPENDENCY INJECTION PATTERN

//запускаем приложение
$application->run();