<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/feedback.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$feedback = new Feedback($db);
 
// set ID property of user to be edited
$feedback->pemesan= $_POST["pemesan"];

// read the details of user to be edited
$stmtFeedback = $feedback->readOne();
$numFeedback = $stmtFeedback->rowCount();
echo $numFeedbackn;
// create array
if($numFeedback>0){
 
    // products array
    $feedback_arr=array();
    $feedback_arr["feedback"]=array();

    while ($rowFeedback = $stmtFeedback->fetch(PDO::FETCH_ASSOC)){

        extract($rowFeedback);
        $product_item=array(
            "id" => $id,
            "message" => $message,
            "pemesan" => $pemesan,
         );
         
        array_push($feedback_arr["feedback"], $product_item);
    }
}
else{
    $feedback_arr["feedback"]=null;
}

 
// make it json format
print_r(json_encode($feedback_arr));
?>