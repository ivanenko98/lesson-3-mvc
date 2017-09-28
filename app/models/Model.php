<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 8:19 PM
 */

namespace app\models;


use app\Application;

/**
 * Class Model
 *
 * Абстрактный класс,
 * от него удем наследовать каждую модель
 *
 * Модель - экземпляр записи с БД (если в кратце)
 * Модель помогает общаться с базой данных
 *
 * @package app\models
 */
abstract class Model
{
    //массив с полями, которые используются в базе
    public static $fields;

    /**
     * Model constructor.
     *
     * передаем в модель при создании поля и их значения
     * например
     *
     * [
     *    [
     *      'id' => 1,
     *      'message' => 'Hello World',
     *      'time' => 28-09-2017 13:36:50
     *    ],
     *    [
     *      'id' => 1,
     *      'message' => 'Working on MVC!',
     *      'time' => 28-09-2017 13:37:42
     *    ],
     * ]
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $property => $value){
            if(in_array($property, static::$fields)){
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Метод для динамической выборки из БД
     *
     * @param null $condition
     * @return array
     */
    public static function find($condition = null)
    {
        //запрос
        //вместо static будет подсталено имя класса-наследника, с которого вызвана эта функция
        $sql = 'SELECT * FROM `' . static::tableName() . '`';

        //если есть условие - добавляем его к запросу
        if ($condition) {
            $sql .= "WHERE $condition";
        }

        //получаем результат с помощью ПДО
        $PDOResult = Application::$pdo->query($sql);

        //создаем экземпляры класса модели и возвращаем из как результат поиска
        return self::createModels($PDOResult->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * Метод для создания моделей на основе данных, полученых из базы данных
     *
     * @param array $queryResults
     * @return array
     */
    public static function createModels(array $queryResults){

        $models = [];
        foreach ($queryResults as $record){


            $newModel = new static($record);

            $models[] = $newModel;
        }

        return $models;
    }
}