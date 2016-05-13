/**
 * @description function to generate a variable-length random string with an optional delimiter in between
 * @param int $minLength minimum length of string to generate
 * @param int $maxLength maximum length of string to generate
 * @param string $delimiter [optional] The string to put in between the first and second strings. Default is underscore. Pass an empty str if you don't want a delimiter
 * @return string $rand_str the new randomly generated string
 */
function generateRandomCode($minLength, $maxLength, $delimiter = "_"){
  //randomly generate the final length of the string we want to generate, ensuring it's between the min and max length provided by the user
  $totLength = rand($minLength, $maxLength-1);//($maxLength - 1) is used in order to accommodate the delimiter without going beyond the maxLength
  
  //determine the number of string to generate before and after the delimiter
  $b4_ = rand(1, $totLength-1);//number of strings before the delimiter
  $afta_ = $totLength - $b4_;//number of strings after the delimiter
  
  //CI's random_string function
  $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  
  //generate the two strings
  $rand_1 = substr(str_shuffle(str_repeat($pool, ceil($totLength / strlen($pool)))), 0, $b4_);
  $rand_2 = substr(str_shuffle(str_repeat($pool, ceil($totLength / strlen($pool)))), 0, $afta_);
  
  //merge the strings separating them with the delimiter
  $rand_str = $rand_1 . $delimiter . $rand_2;
  
  return $rand_str;
}
