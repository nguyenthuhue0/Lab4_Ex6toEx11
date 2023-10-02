<?php
//get tasklist array from POST
$task_list = filter_input(INPUT_POST, 'tasklist', 
        FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($task_list === NULL) {
    $task_list = array();
    
//    add some hard-coded starting values to make testing easier
   $task_list[] = 'Write chapter';
   $task_list[] = 'Edit chapter';
   $task_list[] = 'Proofread chapter';
}

//get action variable from POST
$action = filter_input(INPUT_POST, 'action');

//initialize error messages array
$errors = array();

//process
switch( $action ) {
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
           array_push($task_list, $new_task);
        }
        break;
    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
        }
        break;
    
    // chi la form dau tien khi khoi dong VA chua nhan nut Modify
    case 'Modify Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === null || $task_index=== false){
            $errors[] = 'phần tasks (task_list) chưa có dữ liệu';
        }else {
            $task_to_modify = $task_list[$task_index];
        }
        break;

    case 'Save Changes':
        $id = filter_input(INPUT_POST,'modifiedtaskid', FILTER_VALIDATE_INT);
        $modify_content = filter_input(INPUT_POST, 'modifiedtask');
        if ($modify_content === null){
            $errors[] = "chưa nhập dữ liệu co modify content";
        } else if ($id === null || $id === false){
            $errors[] = "có thể tasks đang bị trống vì không có id";
        }
        else {
            $task_list[$id] = $modify_content;
            $modify_content='';
        }
        break;
        
    
        case 'Cancel Changes':
            $modify_content='';
            break;
        
        case 'Promote Task':
            $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
            if ($task_index == 0){
                $errors[] = 'task này đã được ưu tiên nhất rồi. không thể lên được vị trí ưu tiên hơn nữa';
            }else if ($task_index === null || $task_index === false){
                $errors[] = 'có thể list này đang rỗng, nhập dữ liệu vào thử';
            }else {
                $curr = $task_list[$task_index];
                $pre = $task_list[$task_index-1];
                $task_list[$task_index] =$pre;
                $task_list[$task_index-1] = $curr;
            }
            break;

        case 'Sort Tasks':
            sort($task_list);
            break;
}

include('task_list.php');
?>

