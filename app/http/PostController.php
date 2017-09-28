<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 9/27/17
 * Time: 7:38 PM
 */

namespace app\http;


use app\Application;
use app\models\Post;

class PostController extends Controller
{

    // экшен, который будем запускать
    public function all(){
        //выстаскиваем данным с талицы
        $posts = Post::find();

        /**
         * запускаем генерацию файла представления, передаем туда АБСОЛБТНЫЙ путь к файлу представления и переменные, которым в нем используются
         *
         * http://php.net/manual/ru/function.compact.php
         */
//        return $this->render('post/all', ['posts' => $posts]);
        return $this->render('post/all', compact('posts'));
    }
}