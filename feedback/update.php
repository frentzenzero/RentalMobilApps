<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/feedback.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new feedback($db);

// set ID property of product to be edited
$product->id = $_POST["id"];

$product->message = $_POST["message"];

// update the product
if($product->update()){
    $response["value"] = 200;
    $response["pesan"] = "Feedback berhasil diubah";
    echo json_encode($response);
}
 
// if unable to update the product, tell the user
else{
    $response["value"] = o;
    $response["pesan"] = "Coba Lagi";
    echo json_encode($response);
}
?>