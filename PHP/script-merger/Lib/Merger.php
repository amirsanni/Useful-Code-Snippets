<?php

#A simple script to merge multiple files together.
#Basically created for designers and web developers for merging javaScript and CSS files.
#Not meant for merging pdfs as it may produce unexpected results
#Check **insert link here** for the one I wrote specifically for merging pdf files
#thanks

/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 17th May, 2016
 *
 */
 
$obj = new Merger();

if(isset($_FILES['all_files'])){
	$obj->mergeFiles($_FILES['all_files']);
}

else{
	echo "No file found";
}


class Merger{
	#users will select files, display selected files on the browser (just an icon + the file name), add a button for removing files 
	#from the selection, add an optional for users to type in their preferred name (including ext) to save the file to be created with,
	#use current timestamp if no name is provided, send files to server, merger and name file, upload to server for download,
	#force download of file and also display link to download the file, informtion user how long it'll remain before being deleted:)
	
	public function mergeFiles($files_to_merge){
		$preferred_file_name = isset($_POST['pref_name']) ? filter_var(INPUT_POST, 'pref_name') : $this->guessName($files_to_merge);//set default name
		
		$new_content = "";//holds the content of the file to be created
		
		//loop through each file, validate them and append them to $new_content if they pass validation
		//else, break and inform user the merge cannot be done as a file failed validation
		foreach($files_to_merge['tmp_name'] as $f){			
			$new_content .= file_get_contents($f);
		}
		
		if($new_content){
			//put the file in a containing folder to prevent file name conflict. The folder name has to be unique
			
			#Keep trying to create dir if it exists
			while(TRUE){
				$rand_dir_name = $this->generateRandomCode(4, 10, "");
				
				if(!file_exists('../merged_files/'.$rand_dir_name)){
					mkdir('../merged_files/'.$rand_dir_name);
				
					file_put_contents('../merged_files/'.$rand_dir_name.'/'.$preferred_file_name, $new_content);
					
					break;
				}
			}
			
			echo "<a href='".$this->baseUrl().'merged_files/'.$rand_dir_name.'/'.$preferred_file_name."' download='".$preferred_file_name."'>
				Download Merged File</a>";
		}
	}
	
	
	
	
	private function guessName($files){
		$arr_of_extensions = [];
		
		foreach($files['name'] as $f){
			
			#split the file name into an array using dot(.) as separator
			$exploded_name = explode('.', $f);
			
			//get the length of the array
			$len = count($exploded_name);
			
			//now get the last value in the array which is expected to be the file extension.
			//We need to get the last value since there coud be multiple dots(.) in the file name
			$ext = $exploded_name[$len-1];//$len-1 since array index is zero based.
						
			array_push($arr_of_extensions, $ext);
		}
		
		//Now select the extension that occur the most in the array and use it as the file extension
		$a = array_count_values($arr_of_extensions);//will make the value (in this case the ext) as key and the no. of occurrence as value
		
		$suggested_extension = array_search(max($a), $a);//will return the key (in our case the ext)
		
		$suggested_file_name = time() . "." . $suggested_extension;//concatenate the extension with a dot and current timestamp
		
		return $suggested_file_name;//return suggested name
	}
	
	
	
	/**
	 * @description function to generate a variable-length random string with an optional delimiter in between
	 * @param int $minLength minimum length of string to generate
	 * @param int $maxLength maximum length of string to generate
	 * @param string $delimiter [optional] The string to put in between the first and second strings. Default is underscore. Pass an empty 		 * str if you don't want a delimiter
	 * @return string $rand_str the new randomly generated string
	 */
	private function generateRandomCode($minLength, $maxLength, $delimiter = "_"){
    	#randomly generate the final length of the string we want to generate, 
    	#ensuring it's between the min and max length provided by the user
    	
	  	$totLength = rand($minLength, $maxLength-1);
	  
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
	
	
	private function baseUrl(){
		return "http://localhost/merger/";
	}
}
