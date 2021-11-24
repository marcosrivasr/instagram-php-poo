<?php

use Marcosrivasr\Instagram\controllers\Login;
use Marcosrivasr\Instagram\controllers\Signup;
use Marcosrivasr\Instagram\controllers\Home;
use Marcosrivasr\Instagram\controllers\Profile;
use Marcosrivasr\Instagram\controllers\Actions;

$router = new \Bramus\Router\Router();
session_start();

$user = unserialize($_SESSION['user']);

$router->before('GET', '/', function() { 

    if(isset($_SESSION['user'])){
        //$user = unserialize($_SESSION['user']);
        header('location: home');
    }else{
        header('location: login');
        //exit();
    }
});

$router->get('/', function() { 
    echo "home";
});

$router->get('/login', function() {
    $controller = new Login;
    $controller->render('login/index');
});

$router->post('/auth', function() {
    $controller = new Login;
    $controller->auth($_POST);
});

$router->get('/signup', function() { 
    $controller = new Signup;
    $controller->render('signup/index');
});

$router->post('/register', function() { 
    $controller = new Signup;
    $controller->register($_POST);
});

$router->get('/home', function() { 
    global $user;
    $controller = new Home($user);
    $controller->index();
});

$router->post('/publish', function() { 
    global $user;
    $controller = new Home($user);
    $controller->store();
    header('location: home');
});

$router->get('/profile', function() { 
    global $user;
    $controller = new Profile($user);
    $controller->index();
    
});

$router->post('/addLike', function() { 
    global $user;
    $controller = new Actions($user);
    $controller->like();
    header('location: ' . $_POST['origin']);
});


$router->run();