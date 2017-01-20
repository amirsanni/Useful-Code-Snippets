function changeURL(pageTitle, uri){
    var newURL = appRoot+uri;    
    
    window.history.pushState({pageTitle:pageTitle}, "", newURL);
}