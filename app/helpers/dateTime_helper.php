<?php 
    function monthConverter(){
        $monthNum = date("m");
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        return $monthName . " " . date("d") . ' ' . date("Y"); // Output: May
    }

?>