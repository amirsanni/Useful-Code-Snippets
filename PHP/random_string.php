/**
 * @description function to generate a variable-length random string with an optional delimiter in between
 * @param string $codeType string to pass as 2nd param to codeIgniter's random_string() e.g. alnum, numeric etc
 * @param int $minLength minimum length of string to generate
 * @param int $maxLength maximum length of string to generate
 * @param string $delimiter [optional] The string to put in between the first and second strings. Default is underscore
 * @return string $code the new randomly generated code
 */
function generateRandomCode($codeType, $minLength, $maxLength, $delimiter = "_"){
  //randomly generate the final length of the string we want to generate, ensuring it's between the min and max length provided by the user
  $totLength = rand($minLength, $maxLength-1);//($maxLength - 1) is used in order to accommodate the delimiter without going beyond the maxLength
  
  //determine the number of string to generate before and after the delimiter
  $b4_ = rand(1, $totLength-1);//number of strings before the delimiter
  $afta_ = $totLength - $b4_;//number of strings after the delimiter
  
  $rand_str = random_string($codeType, $b4_) . $delimiter . random_string($codeType, $afta_);
  
  return $rand_str;
}
