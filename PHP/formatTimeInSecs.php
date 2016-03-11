<?php

function formatTimeInSecs($timeInSec){
  $hour = (int)$timeInSec/3600;//get the number of hours
        
  $hourString = $hour >= 1 ? $hour."h" : "";//attach 'h' to hour if hour is not less than one.
        
  $secsLeft = $timeInSec%3600;//get the number of secs left after removing the hours which is equivalent to the modulus of $timeInSec
  
  if($secsLeft < 60){
    $minuteString = "0m";//if the number of secs is less than 60, we set minute to 0
    $secString = $secsLeft ."s";//and set secs to the number of secs
    
    $minAndSecString = $minuteString . " " . $secString;//then concatenate the two strings
  }
  
  else{
    $minAndSecString = minuteAndSec($secsLeft);//call function to calculate
    $minute = (int) ($timeInSec / 60); //get the number of minutes
    $minuteString = $minute ? $minute . "m" : "";

    $sec = $timeInSec % 60; //get the number of secs
    $secString = $sec ? $sec . "s" : "";

    $minAndSecString = $minuteString . " " . $secString;
  }
  
  //return the formatted time
  return $hourString . " " . $minAndSecString;
}
