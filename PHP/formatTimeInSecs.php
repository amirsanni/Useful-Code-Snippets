<?php
/*
 * @author Amir Sanni <amirsanni@gmail.com>
 * @description Function takes a time in sec and return it in a more human friendly format (e.g. 10hrs, 20mins)
 * @date 11th March, 2016
 * @param $timeInSec the time to format (in secs)
 */
function formatTimeInSecs($timeInSec){
  $hour = (int)($timeInSec/3600);//get the number of hours
        
  $hourString = $hour >= 1 ? $hour."h" : "";//attach 'h' to hour if hour is not less than one, else set string as empty.
        
  $secsLeft = $timeInSec%3600;//get the number of secs left after removing the hours which is equivalent to the modulus of $timeInSec
  
  if($secsLeft < 60){
    $minuteString = "0m";//if the number of secs is less than 60, we set minute to 0 meaning the number of secs left is not up to a min
    $secString = $secsLeft ."s";//and set secs to the number of secs
    
    $minAndSecString = $minuteString . " " . $secString;//then concatenate the two strings
  }
  
  else{//else, we get the number of minutes left and the number of seconds left
    $minute = (int) ($secsLeft / 60); //get the number of minutes left
    $minuteString = $minute >= 1 ? $minute . "m" : "";

    $sec = $secsLeft % 60; //get the number of secs left
    $secString = $sec ? $sec . "s" : "";

    $minAndSecString = $minuteString . " " . $secString;
  }
  
  //return the formatted time
  return $hourString . " " . $minAndSecString;
}
