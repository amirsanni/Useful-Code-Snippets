//Most of the time, we do have the need to manually change the domain name our app is running to ensure it works well across multiple domains
//(localhost, using IP, online with/without "www", http, https etc). This function will come handy to ensure our approot is accurately 
//set no matter the domain our app is running on.

//devFolderName holds the name of the folder our app is saved if not in the server root which is always not the case on localhost
//prodFolderName does the some but for when our app is in production

//to set our app root
var appRoot = setAppRoot("MY_APP_FOLDER_NAME_DEV_OR_EMPTY_STRING_IF_NOT_REQUIRED", "MY_APP_FOLDER_NAME_PROD_OR_EMPTY_STRING_IF_NOT_REQUIRED");

function setAppRoot(devFolderName, prodFolderName){
    var hostname = window.location.hostname;

    /*
     * set the appRoot
     * This will work for both http, https with or without www
     * @type String
     */
    
    //attach trailing slash to both foldernames
    var devFolder = devFolderName ? devFolderName+"/" : "";
    var prodFolder = prodFolderName ? prodFolderName+"/" : "";
    
    var appRoot = "";
    
    if(hostname.search("localhost") !== -1 || (hostname.search("192.168.") !== -1)  || (hostname.search("127.0.0.") !== -1)){
        appRoot = window.location.origin+"/"+devFolder;
    }
    
    else{
        appRoot = window.location.origin+"/"+prodFolder;
    }
    
    return appRoot;
}
