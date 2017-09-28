<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 8:24 PM
 */

namespace app\models;

/**
 * Конкретная модель для таблицы 'post' в БД
 *
 * Class Post
 * @package app\models
 */
class Post extends Model
{
    public $id;
    public $message;
    public $time;

    public static $fields = [
        'id',
        'message',
        'time',
    ];

    //возвращает имя таблицы
    public static function tableName()
    {
        return 'post';
    }
}