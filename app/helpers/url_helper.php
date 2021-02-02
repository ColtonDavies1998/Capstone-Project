<?php 
      /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */
  
    //simple page redirect
    function redirect($page){
        header('location: '. URLROOT . '/'. $page);
    }
?>