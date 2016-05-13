/**
* Create a new file by merging multiple files together
* @param string $src_dir directory to scan for files to merge (must end with a trailing slash)
* @param string $dest_dir directory to save the merged files (must end with a trailing slash)
* @param string $file_name the name to save the newly created file with (including the file extension)
* @param array $exceptions array of file names to ignore. Inner directories will be ignored by default
* @return boolean
*/
public function combine_files($src_dir, $dest_dir, $file_name, $exceptions=[]){
	$content = "";//to hold the contents of all the files
  $files_to_exempt = ['', '.', '..'];//will be removed by default
  $filtered_array = [];//to hold the names of files to be merged after removing the exceptions
  
  //add values in the $exceptions to $files_to_exempt if $exceptions has a value
  if($exceptions){
      foreach($exceptions as $e){
        array_push($files_to_exempt, $e);
      }
  }
  
  //get the files and dir in $src_dir
  $files_and_dir = scandir($src_dir);
    
  //remove the files and dir to be exempted
  foreach($files_and_dir as $f){
    if(!in_array($f, $files_to_exempt) && !is_dir($src_dir.$f)){
      array_push($filtered_array, $f);
    }
  }

	//get the content of each file and add to $content
	foreach($filtered_array as $fn){
    $content .= file_get_contents($src_dir.$fn);
	}
	
	//write content to new file
	$done = file_put_contents($dest_dir.$file_name, $content);
  
  return $done ? TRUE : FALSE;
}
