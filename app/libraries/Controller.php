<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */
/**
 * Base Controller
 * Loads the models and views
 */
 class Controller{
     //load model
     public function model($model){
         //require model file
        require_once '../app/models/' . $model . '.php';

        //Instatiate model
        return new $model();
     }

     public function view($view, $data = []){
        //check for view file

        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die('View does not exist');
        }
     }
 }

?>