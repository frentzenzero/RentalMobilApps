<?php
class User{
 
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
      

        if($stmt->execute()){
            return true;
        }
    
        return false;
    
        // execute query EMAL
        // if($stmt->execute()){
            
        //     if($this->mail()){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }
    
        // return false;
        
    }

    // function mail(){
    //     $email_subject = "Website Contact From:  RentalMobilApps";
    //         $headers = "From: rentalmobilapps@rentalmbilapps.thekingcorp.org"."\r\n";
    //         $headers .= "Reply-To:noreply@rentalmbilapps.thekingcorp.org" . "\r\n";
    //         $headers .= "MIME-Version: 1.0\r\n";
    //         $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
    //         $message ='<html>';
    //         $message .='<body>';
    //             $message .='<div class="mail" style="margin: auto; width: 100%; max-width: 350px; text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 30px;">';
    //                 $message .='<div class="mail-header" style="color: white; background-color: #003365; width: 100%; font-size: 20px; padding: 20px; border-top-left-radius: 25px; border-top-right-radius: 25px;">';
    //                     $message .='<strong>VERIFIKASI EMAIL DARI <br/>Rental Mobil</strong>';
    //                 $message .='</div>';
    //                 $message .='<div class="mail-body" style="color: black; background-color:  #CFE7EA; width: 100%; padding: 20px;">';
    //                     $message .='<h1>Hai '.$this->nama.', Silahkan lakukan verifikasi email klik tombol ini </h1>';
    //                     $message .='<a href="https:/tiematweb18.000webhostapp.com/mail/verifikasiEmail.php?token='.$this->token.'"><button style="background-image: linear-gradient(to left, #0025BC , #0071BC); width: 100%; text-align: center; margin: auto; min-height: 40px; color: white; font-size: 30px; cursor: pointer;">Klik disini</button></a>';
    //                 $message .='</div>';
    //                 $message .='<div class="mail-footer" style="color: black; background-color: #adadad; width: 100%; font-size: 20px;padding: 20px; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;">';
    //                 $message .='</div>';
    //             $message .='</div>';
    //         $message .='</body>';
    //         $message .='</html>';
            
    //         if(mail($this->email,$email_subject,$message,$headers)){
    //             return true; 
    //         }else{
    //             return false;
    //         }
    // }

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

    





}