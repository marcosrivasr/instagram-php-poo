<?php

namespace Marcosrivasr\Instagram\controllers;

use Marcosrivasr\Instagram\lib\Controller;
use Marcosrivasr\Instagram\lib\UtilImages;
use Marcosrivasr\Instagram\models\User;
use Marcosrivasr\Instagram\models\PostImage;

class Home extends Controller{

    function __construct(private User $user)
    {
        parent::__construct();
    }

    public function index(){
        $posts = PostImage::getFeed();
        $this->render('home/index', ['user' => $this->user, 'posts' => $posts]);
    }

    public function store(){

        $title = $this->post('title');
        $image = $this->file('image');

        if(!is_null($title) && !is_null($image)){
            $url = UtilImages::storeImage($image);
            if(!is_null($url)){
                error_log($title);
                error_log($url);
                $post = new PostImage($title, $url);
                $this->user->publish($post);
            }
        }
    }

    

}