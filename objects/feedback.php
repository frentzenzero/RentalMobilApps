<?php
class Book{
 
    // database connection and table name
    private $conn;
    private $table_name = "feedback";
 
    // object properties
    public $id;
    public $feedback;
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
                 message=:message";
  
        // prepare query
        $stmt = $this->conn->prepare($query);


    
        // sanitize
        
        $this->message=htmlspecialchars(strip_tags($this->message));
        $this->pemesan=htmlspecialchars(strip_tags($this->pemesan));

        // bind values
        $stmt->bindParam(":message", $this->message);
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

