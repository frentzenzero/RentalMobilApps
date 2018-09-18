<?php
class User{
    //RIO
    //Cek jadi
    //ini Buar raya
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $id;
    public $nama;
    public $hp;
    public $gender;
    public $email;
    public $password;
    public $passwordL;
    public $status;
    public $token;
   
 
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
                id DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                 email=:email, nama=:nama, hp=:hp, gender=:gender, password=:password, status=:status, token=:token";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->hp=htmlspecialchars(strip_tags($this->hp));
        $this->token=htmlspecialchars(strip_tags($this->token));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam(":token", $this->token);
      

        
    
        // execute query EMAL
        if($stmt->execute()){
            
            if($this->mail()){
                return true;
            }else{
                return false;
            }
        }
    
        return false;
        
    }

    function mail(){
        $email_subject = "Website Contact From:  RentalMobilApps";
            $headers = "From: rentalmobilapps@rentalmobilapps.thekingcorp.org"."\r\n";
            $headers .= "Reply-To:noreply@rentalmobilapps.thekingcorp.org" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            $message ='<html>';
            $message .='<body>';
                        $message .='<strong>VERIFIKASI EMAIL DARI <br/>Rental Mobil</strong>';
                    $message .='</div>';
                    $message .='<div class="mail-body" style="color: black; background-color:  #CFE7EA; width: 100%; padding: 20px;">';
                        $message .='<h1>Hai '.$this->nama.', Silahkan lakukan verifikasi email klik tombol ini </h1>';
                        $message .='<a href="https://rentalmobilapps.thekingcorp.org//mail/verifikasiEmail.php?token='.$this->token.'"><button style="background-image: linear-gradient(to left, #0025BC , #0071BC); width: 100%; text-align: center; margin: auto; min-height: 40px; color: white; font-size: 30px; cursor: pointer;">Klik disini</button></a>';
                    $message .='</div>';
                $message .='</div>';
            $message .='</body>';
            $message .='</html>';
            
            if(mail($this->email,$email_subject,$message,$headers)){
                return true; 
            }else{
                return false;
            }
    }

    function updateByToken(){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status=1
                WHERE
                    token=:token";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->token=htmlspecialchars(strip_tags($this->token));

        // bind values
        $stmt->bindParam(":token", $this->token);
    
        // execute the query
        if($stmt->execute()){
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
                    id = ?
                LIMIT
                    0,1
                    ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // set values to object properties
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->nama = $row['nama'];
        $this->gender = $row['hp'];
        $this->hp = $row['hp'];
        
    }

    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    email=:email, nama=:nama, gender=:gender, hp=:hp
                WHERE
                    id=:id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->hp=htmlspecialchars(strip_tags($this->hp));
        
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":hp", $this->hp);
        
        $stmt->bindParam(":id", $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function search($keywords){
        
        // select all query
        $query = "SELECT
                    email
                FROM
                    " . $this->table_name . " 
                WHERE
                    email LIKE ? ";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(1, $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // delete the product
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

    function login(){
        $sql = "SELECT password FROM " . $this->table_name . " WHERE email = ?";

        $stmtP = $this->conn->prepare($sql);

        $stmtP->bindParam(1, $this->email);

        $stmtP->execute();

        $row = $stmtP->fetch(PDO::FETCH_ASSOC);
        $this->password=htmlspecialchars(strip_tags($this->password));
      if(password_verify( $this->password,$row['password'] )){
        $sql2 = "SELECT id, status FROM " . $this->table_name . " WHERE email = ?";

        $stmt = $this->conn->prepare( $sql2 );

        $stmt->bindParam(1, $this->email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        session_start();
        $this->id = $row['id'];
        $this->status = $row['status'];
        $this->nama = $row['nama'];
        
        return true;
      }else{
        return false;
        
      }
    }

    





}