<?php
/** @var array $posts */

/**
 * файл представления
 */

/** @var \app\models\Post $post */
foreach ($posts as $post){
    echo "$post->id | $post->message :: $post->time";
    echo "<hr>" ;
}


