<?php

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new User($db);
 
 
$product->email = $_POST["email"];
$product->password = $_POST["password"];


if($product->login()){
    $response["id"] = $product->id;
     $response["value"] = 200;
     $response["status"]=$product->status;
     $response["nama"]=$product->nama;
     $response["gender"]=$product->gender;
     $response["email"]=$product->email;
     $response["hp"]=$product->hp;

   $response["message"] = "Selamat Datang";
   echo json_encode($response);
}
    
// if unable to update the product, tell the user
else{ 
   $response["value"] = 0;
   $response["message"] = "Email atau Password Salah";
   echo json_encode($response);
}

?>