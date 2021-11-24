<?php

namespace Marcosrivasr\Instagram\controllers;

use Marcosrivasr\Instagram\lib\Controller;
use Marcosrivasr\Instagram\models\User;

class Profile extends Controller{

    public function __construct(private User $user)
    {
        parent::__construct();
    }

    public function index(){

        $this->user->fetchPosts();

        $this->render('profile/index', ['user' => $this->user]);
    }
}