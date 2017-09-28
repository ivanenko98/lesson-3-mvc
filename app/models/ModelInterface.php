<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 8:22 PM
 */

namespace app\models;

/**
 * Интерфейс с обязательными полями для модели,
 * чтобы было проще управлять обьектами и знать какие данные они возвращают
 *
 * Interface ModelInterface
 * @package app\models
 */
interface ModelInterface
{
    //каждая модель может назодить записи из своей таблицы
    public static function find($condition);

    //у кадой модели есть своя таблица в БД
    public static function tableName();
}