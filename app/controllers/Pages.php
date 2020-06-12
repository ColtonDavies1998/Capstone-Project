<?php
  class Pages extends Controller {
    public function __construct(){
    
    }

    public function dashboard(){
      $data = [
        'title' => 'welcome'
       ];

      
      $this->view('pages/Dashboard', $data);
    }


  }