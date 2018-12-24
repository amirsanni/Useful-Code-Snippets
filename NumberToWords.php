<?php
/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 19th Dec., 2018
 */

$obj = new NumberToWords();

echo $obj->convert(3490948028.56, "NGN");

class NumberToWords{
    protected function getCurrencyCodeUnit($currency_code=''):array{
        $supported_currencies = [
			'EUR'=>['main'=>'Euro', 'fraction'=>"Cent"],
            'GBP'=>['main'=>'Pound', 'fraction'=>"Penny"],
            'GHC'=>['main'=>"Ghana Cedi", 'fraction'=>'Pesewa'],
            'GHS'=>['main'=>"Ghana Cedi", 'fraction'=>'Pesewa'],
            'MUR'=>['main'=>'Rupee', 'fraction'=>"Cent"],
            'NGN'=>['main'=>"Naira", 'fraction'=>'Kobo'],
            'USD'=>['main'=>"US Dollar", 'fraction'=>"Cent"],
            'XAF'=>['main'=>'Franc', 'fraction'=>"Centime"],
            'XOF'=>['main'=>'Franc', 'fraction'=>"Centime"]
        ];


        return $supported_currencies[strtoupper($currency_code)] ?? ['main'=>'', 'fraction'=>''];
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    protected function xml(){
        return [
            'x'=>[
                "0"=>"", "00"=>"",
                "1"=>"One", "01"=>"One",
                "2"=>"Two", "02"=>"Two",
                "3"=>"Three", "03"=>"Three",
                "4"=>"Four", "04"=>"Four",
                "5"=>"Five", "05"=>"Five",
                "6"=>"Six", "06"=>"Six",
                "7"=>"Seven", "07"=>"Seven",
                "8"=>"Eight", "08"=>"Eight",
                "9"=>"Nine", "09"=>"Nine",
                "10"=>"Ten",
                "11"=>"Eleven",
                "12"=>"Twelve",
                "13"=>"Thirteen",
                "14"=>"Fourteen",
                "15"=>"Fifteen",
                "16"=>"Sixteen",
                "17"=>"Seventeen",
                "18"=>"Eighteen",
                "19"=>"Nineteen"
            ],
            'm'=>[
                "2"=>"Twenty",
                "3"=>"Thirty",
                "4"=>"Forty",
                "5"=>"Fifty",
                "6"=>"Sixty",
                "7"=>"Seventy",
                "8"=>"Eighty",
                "9"=>"Ninety"
            ]
        ];
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function convert($fig, $currency_code){
        $figure = number_format($fig, 2, '.', '');

        $number = explode('.', $figure)[0];
        
        $decimal = (int)explode('.', $figure)[1];

        $sub_part = $decimal > 0 ? (", ".($decimal <= 19 ? $this->handleXDigits($decimal) : $this->handleTwoDigits($decimal))." ".$this->getCurrencyCodeUnit($currency_code)['fraction']) : "";

        if($number == 0){
            $main_word = "Zero";
        }

        else if($number <= 19 && $number >= 1){//1-19
            $main_word = $this->handleXDigits($number);
        }

        else if(strlen($number) == 2 || ($number < 100)){//20-99
            $main_word = $this->handleTwoDigits($number);
        }

        else if(strlen($number) == 3 || ($number < 1000)){
            $main_word = $this->handleHundreds($number);
        }

        else if(strlen($number) <= 6 || ($number < 1000000)){//less than a million
            $main_word = $this->handleThousands($number);
        }

        else if(strlen($number) <= 9 || ($number < 1000000000)){//less than a billion
            $main_word = $this->handleMillions($number);
        }

        else if(strlen($number) <= 12 || ($number < 1000000000000)){//less than a trillion
            $main_word = $this->handleBillions($number);
        }

        else{
            return "Number too large";
        }


        return $main_word." ".$this->getCurrencyCodeUnit($currency_code)['main'].$sub_part;
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    private function handleXDigits($digits){//1-19
        return $this->xml()['x'][$digits];
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    private function handleTwoDigits($digits){//20-99
        if($digits <= 19){
            return $this->handleXDigits($digits);
        }

        else{
            $first_digit = substr($digits, 0, 1);
            $second_digit = substr($digits, 1, 1);

            $first_digit_word = $first_digit != '0' ? $this->xml()['m'][$first_digit] : "";
            $second_digit_word = $second_digit == '0' ? "" : $this->xml()['x'][$second_digit];

            return trim($first_digit_word) && trim($second_digit_word) ? $first_digit_word."-".$second_digit_word : $first_digit_word." ".$second_digit_word;
        }
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    private function handleHundreds($digits){
        $first_digit_word = $this->handleXDigits(substr($digits, 0, 1));
        $other_two_digits_word = $this->handleTwoDigits(substr($digits, 1));
        
        return (trim($first_digit_word) ? $first_digit_word. " Hundred" : "").(trim($other_two_digits_word) ? " and {$other_two_digits_word}" : "");
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    private function handleThousands($digits){
        // $digits should be min 4 char and max 6 char in length
        $th = substr($digits, 0, -3);//get everything excluding the last three digits.
        $dred = substr($digits, -3);//get last three digits

        $dred_word = $this->handleHundreds($dred);
        $th_word = strlen($th) == 3 ? $this->handleHundreds($th) : (strlen($th) == 2 ? $this->handleTwoDigits($th) : $this->handleXDigits($th));

        return (trim($th_word) && trim($dred_word) ? $th_word." Thousand, " : (trim($th_word) ? $th_word." Thousand" : "")).(trim($dred_word) ? "{$dred_word}" : "");
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    private function handleMillions($digits){
        // $digits should be min 7 char and max 9 char in length
        $th_word = $this->handleThousands(substr($digits, -6));//get the last six digits.
        $mill = substr($digits, 0, -6);//get everything excluding the last six digits.

        $mill_word = strlen($mill) == 3 ? $this->handleHundreds($mill) : (strlen($mill) == 2 ? $this->handleTwoDigits($mill) : $this->handleXDigits($mill));

        return (trim($mill_word) && trim($th_word) ? $mill_word." Million, " : (trim($mill_word) ? $mill_word." Million" : "")).(trim($th_word) ? "{$th_word}" : "");
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    private function handleBillions($digits){
        // $digits should be min 10 char and max 12 char in length
        $mill_word = $this->handleMillions(substr($digits, -9));//get the last nine digits.
        $bill = substr($digits, 0, -9);//get everything excluding the last nine digits.

        $bill_word = strlen($bill) == 3 ? $this->handleHundreds($bill) : (strlen($bill) == 2 ? $this->handleTwoDigits($bill) : $this->handleXDigits($bill));

        return (trim($bill_word) ? $bill_word." Billion" : "").(trim($mill_word) ? ", {$mill_word}" : "");
    }
}