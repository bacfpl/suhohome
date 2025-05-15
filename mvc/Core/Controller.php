<?php 
    class Controller{
        public static function model($model) {
            require_once("./mvc/Models/".$model.".php");
            return new $model;
        }

        public static function view($view, $data = []) {
            require_once ("./mvc/Views/".$view.".php");
        }
    } 
?>