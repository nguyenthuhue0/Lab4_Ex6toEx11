<?php
//set default values
$number1 = 78;
$number2 = -105.33;
$number3 = 0.0049;
$message = 'Enter some numbers and click on the Submit button.';

//process
$action = filter_input(INPUT_POST, 'action');
switch ($action) {
    case 'process_data':
        $number1 = filter_input(INPUT_POST, 'number1');
        $number2 = filter_input(INPUT_POST, 'number2');
        $number3 = filter_input(INPUT_POST, 'number3');

        // make sure the user enters three numbers
        if (empty($number1)){
            $message = 'the number 1 is empty';
            break;
        }
        else if (empty($number2)){
            $message = 'the number 2 is empty';
            break;
        }
        else if (empty($number3)){
            $message = 'the number 3 is empty';
            break;
        }
       

        // make sure the numbers are valid
        if (is_numeric($number1) === false){
            $message ='The number 1 is not valid. Please enter again!';
            break;
        }
        else if (is_numeric($number2) === false){
            $message ='The number 2 is not valid. Please enter again!';
            break;
        }
        else if (is_numeric($number3) === false){
            $message ='The number 3 is not valid. Please enter again!';
            break;
        }

        // get the ceiling and floor for $number2
        $number2_ceil = ceil($number2);
        $number2_floor = floor($number2);
       

        // round $number3 to 3 decimal places
        $number3_rounded = round($number3, 3);

        // get the max and min values of all three numbers
        $min = min($number1, $number2, $number3);
        $max = max($number1, $number2, $number3);

        // generate a random integer between 1 and 100
        $random = random_int(1, 100);

        // format the message
        $message =
           "Number 1: $number1\n" .
           "Number 2: $number2\n" .
           "Number 3: $number3\n" .
           "\n" .
           "Number 2 ceiling: $number2_ceil\n" .
           "Number 2 floor: $number2_floor\n" .
           "Number 3 rounded: $number3_rounded\n" .
           "\n" .
           "Min: $min\n" .
           "Max: $max\n" .
           "\n" .
           "Random: $random\n";

        break;
}
include 'number_tester.php';
?>