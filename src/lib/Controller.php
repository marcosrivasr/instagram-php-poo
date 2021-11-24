<?php

namespace Marcosrivasr\Instagram\lib;
use Marcosrivasr\Instagram\lib\View;

class Controller{

    private string $name;
    private View $view;

    function __construct(){
        $className = get_class($this);
        $parts = explode("\\", $className);
        $this->name = $parts[count($parts) - 1];
        
        $this->view = new View();
    }

    function loadModel($model){
        $url = 'models/'.$model.'.php';

        if(file_exists($url)){
            require_once $url;

            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }

    public function render($view, $data = []){
        $this->view->render($view, $data);
    }

    function post($param){
        if(!isset($_POST[$param])){
            error_log("ExistPOST: No existe el parametro $param" );
            return NULL;
        }
        return $_POST[$param];
    }

    function file($param){
        if(!isset($_FILES[$param])){
            error_log("ExistPOST: No existe el parametro $param" );
            return NULL;
        }
        return $_FILES[$param];
    }

    /* function post($params){
        foreach ($params as $param) {
            if(!isset($_POST[$param])){
                error_log("ExistPOST: No existe el parametro $param" );
                return false;
            }
        }
        error_log( "ExistPOST: Existen parámetros" );
        return true;
    }

    function get($params){
        foreach ($params as $param) {
            if(!isset($_GET[$param])){
                return false;
            }
        }
        return true;
    } */

    /* function getGet($name){
        return $_GET[$name];
    }

    function getPost($name){
        return $_POST[$name];
    } */

    function redirect($url, $mensajes = []){
        $data = [];
        $params = '';
        
        foreach ($mensajes as $key => $value) {
            array_push($data, $key . '=' . $value);
        }
        $params = join('&', $data);
        
        if($params != ''){
            $params = '?' . $params;
        }
        header('location: ' . constant('URL') . $url . $params);
    }
}

?>