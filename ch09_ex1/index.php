<?php
//set default values
$name = '';
$email = '';
$phone = '';
$message = 'Enter some data and click on the Submit button.';

//process
$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'process_data':
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone');

        $name = trim($name); $name = strtolower($name);
        $email = trim($email);
        $phone = trim($phone);

        /*************************************************
         * validate and process the name
         ************************************************/
        // 1. make sure the user enters a name
        // 2. display the name with only the first letter capitalized
        if(is_string($name) || empty($name) !== false){
            $first_name = explode(" ", $name);
            $first_name = ucwords($first_name[0]);
        } else {
            $message = 'You must enter the name';
            break;
        }

        /*************************************************
         * validate and process the email address
         ************************************************/
        // 1. make sure the user enters an email
        // 2. make sure the email address has at least one @ sign and one dot character
        if (strpos($email, '@') === false || strpos($email, '.') === false || empty($email) === true){
           $message ='the email is illegal. Please enter again!';
           break;
        }

        /*************************************************
         * validate and process the phone number
         ************************************************/
        // 1. make sure the user enters at least seven digits, not including formatting characters
        // 2. format the phone number like this 123-4567 or this 123-456-7890
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        
        if (strlen($phone) < 7){
            $message = 'the phone number must contain 7 numbers. please input again!';
            break; 
        }
        else if (strlen($phone) === 7){
            $p1 = substr($phone, 0, 3);
            $p2 = substr($phone, 3);
            $phone = $p1. '-'. $p2;
        }else{
            $p1 = substr($phone, 0, 3);
            $p2 =substr($phone, 3, 3);
            $p3 = substr($phone, 6);
            $phone = $p1 . '-' .$p2. '-' . $p3;
        }

        /*************************************************
         * Display the validation message
         ************************************************/

       
         
         $message = "Hello $first_name, \n\n" .
                    "Thank you for entering this data: \n\n".
                    "Name: $name \n" .
                    "Email: $email \n" .
                    "Phone: $phone\n";

         
    break;
}
include 'string_tester.php';
?>