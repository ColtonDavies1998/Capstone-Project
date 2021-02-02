<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

  /**
   * These functions help convert the different times used throughout the program. The database and the 
   * program front end display the time differently so these functions help covert them throughout controllers
   */

    /**
     * This converts the month from number to its name
     */
    function monthConverter(){
        $monthNum = date("m");
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        return $monthName . " " . date("d") . ' ' . date("Y"); // Output: May
    }
    /**
     * Converts from military to civilian time 
     */
    function militaryToCivilianTime($time){
        return date("g:i a", strtotime($time));
    }

    /**
     * Converts from civilian time
     */
    function civilianToMilitaryTime ($time){
        return date("H:i", strtotime($time));
    }

    

?>