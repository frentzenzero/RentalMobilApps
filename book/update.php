<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/book.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Book($db);

// set ID property of product to be edited
$product->id = $_POST["id"];

$product->tipeMobil = $_POST["tipeMobil"];
$product->modelMobil = $_POST["modelMobil"];
$product->transmisi = $_POST["transmisi"];
$product->bookDate = $_POST["bookDate"];
$product->returnDate = $_POST["returnDate"];
$product->harga = $_POST["harga"];

// update the product
if($product->update()){
    $response["value"] = 200;
    $response["message"] = "Booking berhasil Ubah";
    echo json_encode($response);
}
 
// if unable to update the product, tell the user
else{
    $response["value"] = o;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>