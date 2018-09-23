<?php
class Feedback{
 
    // database connection and table name
    private $conn;
    private $table_name = "feedback";
 
    // object properties
    public $id;
    public $pesan;
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
                 pesan=:pesan,
                 pemesan=:pemesan";
  
        // prepare query
        $stmt = $this->conn->prepare($query);


    
        // sanitize
        
        $this->pesan=htmlspecialchars(strip_tags($this->pesan));
        $this->pemesan=htmlspecialchars(strip_tags($this->pemesan));

        // bind values
        $stmt->bindParam(":pesan", $this->pesan);
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


  function update(){
        
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            pesan=:pesan
           
            WHERE
                id=:id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    

    $this->pesan=htmlspecialchars(strip_tags($this->pesan));
    
    
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind values
    $stmt->bindParam(":pesan", $this->pesan);
    
   
    $stmt->bindParam(":id", $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;
    }

    function delete(){
        
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}

