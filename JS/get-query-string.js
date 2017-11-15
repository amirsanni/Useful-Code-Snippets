/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 15th Nov, 2017
 */

'use strict';

export default function(url, keyToReturn=''){
    let queryStrings = decodeURIComponent(url).split('#', 2)[0].split('?', 2)[1];
    
    if(queryStrings){
        let splittedQStrings = queryStrings.split('&');
        
        if(splittedQStrings.length){
            let queryStringObj = {};
            
            splittedQStrings.forEach(function(keyValuePair){
                let keyValue = keyValuePair.split('=', 2);
                
                if(keyValue.length){
                    queryStringObj[keyValue[0]] = keyValue[1];
                }
            });            
            
            return keyToReturn ? (queryStringObj[keyToReturn] ? queryStringObj[keyToReturn] : null) : queryStringObj;
        }
        
        return null;
    }
    
    return null;
}