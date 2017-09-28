<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 7:37 PM
 */

namespace app\http;


use app\components\View;

abstract class Controller
{
    //тут будет записано имя экшена, который мы используем
    public $action;

    //при создании класса передаем в него название экшена, который нужно запустить
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    /**
     * Запускает экшен текущего контроллера
     * (выполняет внутри класса контроллера функцию, одноименную с именем экшена)
     *
     * @return mixed
     * @throws \Exception
     */
    public function runAction(){
        //проверяем, существует метод, одноименный с именем экшена
        if(method_exists($this, $this->action)){
            /**
             * если да, то запускаем его
             *
             * по повозу синтаксиса с фигурными скобками:
             * http://php.net/manual/ru/language.variables.variable.php
             */
            return $this->{$this->action}();
        }

        //если метода не сущетвует - выводим ошибку о неправильном запрошеном УРЛ
        throw new \Exception('Requested URL was not found', 404);
    }

    /**
     * Генерирует шаблон представления
     * используя ОТНОСИТЕЛЬНЫЙ путь к нему и переменные, которые в нем используются
     *
     *
     * @param $viewID
     * @param array $variables
     * @return string
     * @throws \Exception
     */
    public function render($viewID, array $variables){
        /**
         * генерируем АБСОЛЮТНЫЙ путь к файлу
         *
         * $_SERVER['DOCUMENT_ROOT'] содержит в себе что-то вроде/var/www/mvc.loc (в зависимости откуда вы запускаете жтот скрипт)
         * тоесть корневую папку, где лежит проект
         *
         */
        $viewPath = $_SERVER['DOCUMENT_ROOT']."/resources/views/$viewID.php";


        //проверяем существует ли такой файл
        if(file_exists($viewPath)){
            //создаем новый обьект класса View и передаем ему полный путь к файлу с шаблоном представления
            $view = new View($viewPath);

            //устанавливаем переменные которые будут использоваться в файле представления
            $view->setVariables($variables);

            //выполняем файл представления и получаем готовый выполненный результат
            return $view->render();
        }

        //если файл не существует - бросаем ошибку об этом
        throw new \Exception('View was not found');
    }
}