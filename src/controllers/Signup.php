<?php

namespace Marcosrivasr\Instagram\controllers;

use Marcosrivasr\Instagram\lib\Controller;
use Marcosrivasr\Instagram\lib\UtilImages;
use Marcosrivasr\Instagram\models\User;

class Signup extends Controller{

    function __construct()
    {
        parent::__construct();
    }

    
    public function register(){
        $username = $this->post('username');
        $password = $this->post('password');
        $profile = $this->file('profile');

        if(!is_null($username) && !is_null($password) && !is_null($profile)){
            $url = UtilImages::storeImage($profile);
            $user = new User($username, $password);
            $user->setProfile($url);
            $user->save();
            header('location: login');
        }else{
            $this->render('errors/index');
        }
    }
}