/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 19th Dec., 2018
 */

function getCurrencyCodeUnit(currency_code){
    var supported_currencies = {
        'EUR':{'main':'Euro', 'fraction':"Cent"},
        'GBP':{'main':'Pound', 'fraction':"Penny"},
        'GHC':{'main':"Ghana Cedi", 'fraction':'Pesewa'},
        'GHS':{'main':"Ghana Cedi", 'fraction':'Pesewa'},
        'MUR':{'main':'Rupee', 'fraction':"Cent"},
        'NGN':{'main':"Naira", 'fraction':'Kobo'},
        'USD':{'main':"US Dollar", 'fraction':"Cent"},
        'XAF':{'main':'Franc', 'fraction':"Centime"},
        'XOF':{'main':'Franc', 'fraction':"Centime"}
    };

    return supported_currencies[currency_code.toUpperCase()] || {'main':'', 'fraction':''};
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function xml(){
    return {
        'x':{
            "0":"", "00":"",
            "1":"One", "01":"One",
            "2":"Two", "02":"Two",
            "3":"Three", "03":"Three",
            "4":"Four", "04":"Four",
            "5":"Five", "05":"Five",
            "6":"Six", "06":"Six",
            "7":"Seven", "07":"Seven",
            "8":"Eight", "08":"Eight",
            "9":"Nine", "09":"Nine",
            "10":"Ten",
            "11":"Eleven",
            "12":"Twelve",
            "13":"Thirteen",
            "14":"Fourteen",
            "15":"Fifteen",
            "16":"Sixteen",
            "17":"Seventeen",
            "18":"Eighteen",
            "19":"Nineteen"
        },
        'm':{
            "2":"Twenty",
            "3":"Thirty",
            "4":"Forty",
            "5":"Fifty",
            "6":"Sixty",
            "7":"Seventy",
            "8":"Eighty",
            "9":"Ninety"
        }
    };
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function convert(fig, currency_code){
    var main_word;
    var brokenFigures = fig.toString().split('.');
    var number = brokenFigures[0];
    
    var decimal = brokenFigures[1] ? (brokenFigures[1].length > 1 ? brokenFigures[1] : brokenFigures[1]+"0") : 0;

    var sub_part = decimal > 0 ? (" "+(decimal <= 19 ? handleXDigits(decimal) : handleTwoDigits(decimal))+" "+getCurrencyCodeUnit(currency_code).fraction) : "";

    if(number == 0){
        main_word = "Zero";
    }

    else if(number <= 19 && number >= 1){//1-19
        main_word = handleXDigits(number);
    }

    else if(number.length == 2 || number < 100){//20-99
        main_word = handleTwoDigits(number);
    }

    else if(number.length == 3 || (number < 1000)){
        main_word = handleHundreds(number);
    }

    else if(number.length <= 6 || (number < 1000000)){//less than a million
        main_word = handleThousands(number);
    }

    else if(number.length <= 9 || (number < 1000000000)){//less than a billion
        main_word = handleMillions(number);
    }

    else if(number.length <= 12 || (number < 1000000000000)){//less than a trillion
        main_word = handleBillions(number);
    }

    else{
        return "Number too large";
    }


    return main_word+" "+getCurrencyCodeUnit(currency_code).main+sub_part;
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleXDigits(digits){//1-19
    return xml().x[digits];
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleTwoDigits(digits){//20-99
    if(digits <= 19){
        return handleXDigits(digits);
    }

    else{
        var first_digit = digits.substr(0, 1);
        var second_digit = digits.substr(1, 1);

        var first_digit_word = first_digit != '0' ? xml().m[first_digit] : "";
        var second_digit_word = second_digit == '0' ? "" : xml().x[second_digit];

        return first_digit_word.trim() && second_digit_word.trim() ? first_digit_word+"-"+second_digit_word : first_digit_word+" "+second_digit_word;
    }
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleHundreds(digits){
    var first_digit_word = handleXDigits(digits.substr(0, 1));
    var other_two_digits_word = handleTwoDigits(digits.substr(1));
    
    return (first_digit_word.trim() ? first_digit_word+" Hundred" : "")+(other_two_digits_word.trim() ? " and "+other_two_digits_word : "");
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleThousands(digits){
    // digits should be min 4 char and max 6 char in length
    var th = digits.substr(0, digits.length-3);//get everything excluding the last three digits.
    var dred = digits.substr(-3);//get last three digits

    var dred_word = handleHundreds(dred);
    var th_word = th.length == 3 ? handleHundreds(th) : (th.length == 2 ? handleTwoDigits(th) : handleXDigits(th));

	return (th_word.trim() && dred_word.trim() ? th_word+" Thousand, " : (th_word.trim() ? th_word+" Thousand" : ""))+(dred_word.trim() ? dred_word : "");
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleMillions(digits){
    // digits should be min 7 char and max 9 char in length
    var th_word = handleThousands(digits.substr(-6));//get the last six digits.
    var mill = digits.substr(0, digits.length-6);//get everything excluding the last six digits.

    var mill_word = mill.length == 3 ? handleHundreds(mill) : (mill.length == 2 ? handleTwoDigits(mill) : handleXDigits(mill));

	return (mill_word.trim() && th_word.trim() ? mill_word." Million, " : (mill_word.trim() ? mill_word." Million" : ""))+(th_word.trim() ? th_word : "");
}

/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/

function handleBillions(digits){
    // digits should be min 10 char and max 12 char in length
    var mill_word = handleMillions(digits.substr(-9));//get the last nine digits.
    var bill = digits.substr(0, digits.length-9);//get everything excluding the last nine digits.

    var bill_word = bill.length == 3 ? handleHundreds(bill) : (bill.length == 2 ? handleTwoDigits(bill) : handleXDigits(bill));

    return (bill_word.trim() ? bill_word+" Billion" : "")+(mill_word.trim() ? " "+ mill_word : "");
}