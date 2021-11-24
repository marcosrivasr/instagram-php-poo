<?php

namespace Marcosrivasr\Instagram\controllers;

use Marcosrivasr\Instagram\lib\Controller;
use Marcosrivasr\Instagram\models\User;
use Marcosrivasr\Instagram\models\PostImage;

class Actions extends Controller{

    function __construct(private User $user)
    {
        parent::__construct();
    }

    public function like(){
        $post_id = $this->post('post_id');

        if(!is_null($post_id)){
            error_log('like-> no es nulo');
            $post = PostImage::get($post_id);
            var_dump($post);
            $post->addLike($this->user);
        }
    }

}