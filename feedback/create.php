<?php

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/feedback.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Feedback($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

 
$product->pesan = $_POST["pesan"];
$product->pemesan = $_POST["pemesan"];

if($product->create()){
    echo '{';
        echo '"message": "Feedback Berhasil Dikirim."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Feedback."';
    echo '}';
}
?>