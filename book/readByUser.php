<?php

 
// include database and object files
include_once '../config/database.php';
include_once '../objects/book.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$book = new Book($db);
 
// set ID property of user to be edited
$book->pemesan= $_POST["pemesan"];

// read the details of user to be edited
$stmtBook = $book->readOne();
$numBook = $stmtBook->rowCount();
echo $numBookn;
// create array
if($numBook>0){
 
    // products array
    $book_arr=array();
    $book_arr["result"]=array();

    while ($rowBook = $stmtBook->fetch(PDO::FETCH_ASSOC)){

        extract($rowBook);
        $product_item=array(
            "id" => $id,
            "tipeMobil" => $tipeMobil,
            "modelMobil" => $modelMobil,
            "transmisi" => $transmisi,
            "bookDate" => $bookDate,
            "returnDate" => $returnDate,
            "harga" => $harga,
            "pemesan" => $pemesan,
         );
         
        array_push($book_arr["result"], $product_item);
    }
}
else{
    $book_arr["result"]=[];
}

 
// make it json format
print_r(json_encode($book_arr));
?>