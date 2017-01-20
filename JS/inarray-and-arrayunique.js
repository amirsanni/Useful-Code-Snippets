function inArray(value, array){
    for(let i = 0; i < array.length; i++){
        if(array[i].trim() === value.trim()){
            return true;
        }
    }
    
    return false;
}

function arrayUnique(array){
    var newArray = [];
    
    for(let i = 0; i < array.length; i++){
        if(inArray(array[i].trim(), newArray)){
            continue;
        }

        newArray.push(array[i].trim());
    }
    
    return newArray;
}