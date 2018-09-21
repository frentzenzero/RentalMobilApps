<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);

 
// set ID property of product to be edited
$product->id =$_POST["id"];
 
// set product property values
 
$product->email = $_POST["email"]; 
$product->nama = $_POST["nama"]; 

$product->gender = $_POST["gender"]; 
$product->hp = $_POST["hp"]; 



    if($product->update()){
        echo '{';
            echo '"message": "Data berhasil di perbaharui."';
        echo '}';
    }
     
    // if unable to update the product, tell the user
    else{
        echo '{';
            echo '"message": "Gagal memperbaharui data. Coba lagi"';
        echo '}';
    }

// update the product

?>