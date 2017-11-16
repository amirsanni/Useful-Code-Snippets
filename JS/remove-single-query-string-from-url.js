/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 16th Nov, 2017
 */

'use strict';

export default function(uri, keyToRemove){
    if(uri){
        let qStringArr = uri.indexOf('?') > -1 ? (uri.split('?').length > 1 ? (uri.split('?')[1].split('&')) : null) : null;
        
        if(qStringArr){
            for(let i = 0; i < qStringArr.length; i++){
                if(qStringArr[i].split('=')[0] === keyToRemove){
                    qStringArr.splice(i, 1);

                    return uri.split('?')[0] + (qStringArr.join('&').length ? '?': '') + qStringArr.join('&');
                }
            }
            
            return null;
        }
        
        return null;
    }
    
    return null;
}