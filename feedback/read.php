<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/feedback.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Feedback($db);
 
// query products
$stmt = $product->read();
$num = $stmt->rowCount();
 


// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $product_item=array(
            "id" => $id,
            "message" => $message,
            "pemesan" => $pemesan,
         );
         
         // "description" => html_entity_decode($description),
   

        array_push($products_arr["records"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Feedback found.")
    );
}
?>