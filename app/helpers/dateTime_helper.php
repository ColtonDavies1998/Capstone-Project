<?php 
    function monthConverter(){
        $monthNum = date("m");
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        return $monthName . " " . date("d") . ' ' . date("Y"); // Output: May
    }

    function militaryToCivilianTime($time){
        return date("g:i a", strtotime($time));
    }

    function civilianToMilitaryTime ($time){
        return date("H:i", strtotime($time));
    }

    

?>