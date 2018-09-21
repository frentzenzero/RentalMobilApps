<?php

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/book.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Book($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
 
$product->tipeMobil = $_POST["tipeMobil"];
$product->modelMobil = $_POST["modelMobil"];
$product->transmisi = $_POST["transmisi"];
$product->bookDate = $_POST["bookDate"];
$product->returnDate = $_POST["returnDate"];
$product->harga = $_POST["harga"];
$product->pemesan = $_POST["pemesan"];

// create the product
if($product->create()){
    echo '{';
        echo '"message": "Booking Berhasil Dibuat."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Booking."';
    echo '}';
}
?>