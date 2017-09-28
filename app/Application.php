<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 7:18 PM
 */

namespace app;


use app\http\Controller;

/**
 *
 * Класс, который представляет собой приложение, которое мы вообще щапускаем
 * (по-хорогему надо было еще замутить Шаблон Синглтон и на этот класс)
 * http://designpatternsphp.readthedocs.io/ru/latest/Creational/Singleton/README.html
 *
 * Class Application
 * @package app
 */
class Application
{

    /** в жтом свойстве будет храниться экземпляр соединения с базой данных */
    /** @var  \PDO $pdo */
    public static $pdo;

    //массив с конфигурацией для БД
    public $config;

    //экземпляр класса Controller  в зависимости от URL который мы запустили
    /** @var  Controller $controller */
    public $controller;

    //обработчик запроса, который определит какой контроллер нужно запустить и какой экшен в нем вызвать, чтобы обработать запрос.
    /** @var QueryHandler $queryHandler */
    private $queryHandler;

    //при создании приложение будет получать конфиг в виде массива
    public function __construct(array $config)
    {
        //сохраняем конфиг
        $this->config = $config;

        //соединяемся с БД исользуя полученый конфиг
        $this->connectDatabase($this->config['host'],$this->config['username'],$this->config['password'],$this->config['database']);

        //создаем экземпляр обработчика запросов И ПОМЕЩАЕМ ЕГО В ТЕКУЩИЙ КЛАСС (!!!!) ;)
        $this->queryHandler = QueryHandler::getInstance();
    }

    /**
     * Функция запуска приложения
     *
     * В ней запускается вызванный контроллер после того как
     * обработчик запроса редит какой контроллер нужно вызвать
     *
     */
    public function run(){
        //определяем контроллер и сохраняем его в текущй класс
        $this->controller = $this->handle($_SERVER['REQUEST_URI']);

        //после того как контроллер определен запускаем экшен в нем, получаем его значение и выводим, используя echo
        echo $this->controller->runAction();
    }

    /**
     * Функция для подключения к БД, используя PDO
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @param null $options
     */
    public function connectDatabase(string $host, string $user, string $password, string $database, $options = null){
        try{
            //пытаемся подклчиться
            self::$pdo = new \PDO("mysql:host=$host;dbname=$database", $user, $password, $options);
        }catch (\PDOException $exception){
            //если подключение невозможно - выводим ошибку и останавливаем скрипт
            echo "Connection issue: ".$exception->getMessage();
            exit();
//            die(); //тоже самое, что и exit()
        }
    }
}