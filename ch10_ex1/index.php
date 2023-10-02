 <?php
//set default value
$message = '';

//get value from POST array
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action =  'start_app';
}

//process
switch ($action) {
    case 'start_app':

        // set default invoice date 1 month prior to current date
        $default_date = (new DateTime())->sub(new DateInterval('P1M'));
        $invoice_date_s = $default_date->format('n/j/Y');
        

        // set default due date 2 months after current date
        $default_date = (new DateTime())->add(new DateInterval('P2M'));
        $due_date_s = $default_date->format('n/j/Y');
        

        $message = 'Enter two dates and click on the Submit button.';
        break;
    case 'process_data':
        $invoice_date_s = filter_input(INPUT_POST, 'invoice_date');
        $due_date_s = filter_input(INPUT_POST, 'due_date');


        // make sure the user enters both dates
        if (empty($invoice_date_s)){
            $message ='Invoice day is not valid. please enter again!';
            break;
        }

        if (empty($due_date_s)){
            $message ='Due day is not valid. please enter again!';
            break;
        }  

        // convert date strings to DateTime objects
         // and use a try/catch to make sure the dates are valid
        try {
            $invoice_date_o = new DateTime($invoice_date_s);
            $due_date_o = new DateTime($due_date_s);
        } catch (Exception $e){
            $message = 'Date which input in them that is not valid format. please enter again!';
            break;
        }

        // make sure the due date is after the invoice date
        if ($due_date_o < $invoice_date_o){
            $message = 'Due day must come after invoice day, please check the box and try again!';
            break;
        }

        // format both dates
        $invoice_date_f = $invoice_date_o->format('F j, Y');
        $due_date_f = $due_date_o->format('F j, Y'); 
        
        // get the current date and time and format it
        $current_date_f = (new DateTime())->format('F j, Y');
        $current_time_f = (new DateTime())->format('g:i:s a');
        
        // get the amount of time between the current date and the due date
        // and format the due date message
        $time_span = (new DateTime())->diff($due_date_o);
        if ((new DateTime() < $due_date_o)){
            $due_date_message = $time_span->format('this invoive is %y years, %m months, and %d days overdue');
        } else {
            $due_date_message = $time_span->format('this invoive is %y years, %m months, and %d days.');
        }
        break;
}
include 'date_tester.php';
?>

