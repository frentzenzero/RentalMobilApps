<?php
class Book{
 
    // database connection and table name
    private $conn;
    private $table_name = "book";
 
    // object properties
    public $id;
    public $tipeMobil;
    public $modelMobil;
    public $transmisi;
    public $bookDate;
    public $returnDate;
    public $harga;
    public $pemesan;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){

        // select all query
        $query = "SELECT
                        *
                FROM
                    " . $this->table_name . " 
                ORDER BY
                id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                 tipeMobil=:tipeMobil, 
                 modelMobil=:modelMobil, 
                 transmisi=:transmisi, 
                 bookDate=:bookDate,
                 returnDate=:returnDate,
                 harga=:harga, 
                 pemesan=:pemesan";
  
        // prepare query
        $stmt = $this->conn->prepare($query);


    
        // sanitize
        
        $this->tipeMobil=htmlspecialchars(strip_tags($this->tipeMobil));
        $this->modelMobil=htmlspecialchars(strip_tags($this->modelMobil));
        $this->transmisi=htmlspecialchars(strip_tags($this->transmisi));
        $this->bookDate=htmlspecialchars(strip_tags($this->bookDate));
        $this->returnDate=htmlspecialchars(strip_tags($this->returnDate));
        $this->harga=htmlspecialchars(strip_tags($this->harga));
        $this->pemesan=htmlspecialchars(strip_tags($this->pemesan));

        // bind values
        $stmt->bindParam(":tipeMobil", $this->tipeMobil);
        $stmt->bindParam(":modelMobil", $this->modelMobil);
        $stmt->bindParam(":transmisi", $this->transmisi);
        $stmt->bindParam(":bookDate", $this->bookDate);
        $stmt->bindParam(":returnDate", $this->returnDate);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":pemesan", $this->pemesan);
      
    
        // execute query
        if($stmt->execute()){
            $stmt = null;
            return true;
        }
    
        return false;
        
    }

    function readOne(){
        // query to read single record
      $query = "SELECT
                  *
              FROM
                  " . $this->table_name . "
              WHERE
                  pemesan = ?";

          // prepare query statement
          $stmt = $this->conn->prepare( $query );

          // bind id of product to be updated
          $stmt->bindParam(1, $this->pemesan);

          // execute query
          $stmt->execute();

      return $stmt;
     
  }
}

