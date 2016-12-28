function startCounter(){
    var sec = "00";
    var min = "00";
    var hr = "00";
    
    var hrElem = document.querySelector("#countHr");
    var minElem = document.querySelector("#countMin");
    var secElem = document.querySelector("#countSec");
    
    hrElem.innerHTML = hr;
    minElem.innerHTML = min;
    secElem.innerHTML = sec;
        
    setInterval(function(){
        //display seconds and increment it by a sec
        ++sec;
        
        secElem.innerHTML = sec >= 60 ? "00" : (sec < 10 ? "0"+sec : sec);
        
        if(sec >= 60){
            //increase minute and reset secs to 00
            ++min;
            minElem.innerHTML = min < 10 ? "0"+min : min;
            
            sec = 0;
            
            if(min >= 60){
                //increase hr by one and reset min to 00
                ++hr;
                hrElem.innerHTML = hr < 10 ? "0"+hr : hr;
                
                min = 0;
            }
        }
        
    }, 1000);
}



startCounter();
