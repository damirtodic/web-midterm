<?php

class MidtermDao {

    private $conn;
    private $host = 'db-mysql-nyc1-51552-do-user-3246313-0.b.db.ondigitalocean.com';
    private $database = 'midterm-2023';
    private $username = 'doadmin';
    private $password = '';
    private $port="25060";


    /**
    * constructor of dao class
    */
    public function __construct(){
        
         
        /** TODO
        * List parameters such as servername, username, password, schema. Make sure to use appropriate port
        */
      
        /*options array neccessary to enable ssl mode - do not change*/
        $options = array(
        	PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1g3sZDXiWK8HcPuRhS0nNeoUlOVSWdMAg/view?usp=share_link',
        	PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

        );

        try {
          $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database, port= $this->port",$this->username, $this->password,$options);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
          echo "error:" . $e->getMessage();
      }
        /** TODO
        * Create new connection
        * Use $options array as last parameter to new PDO call after the password
        */

        // set the PDO error mode to exception
    
    }
    function query($query, $params = []) {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);
      return $stmt;
  }

    /** TODO
    * Implement DAO method used to get cap table
    */
    public function cap_table(){
      $stmt = $this->query("SELECT * FROM cap_table");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method used to get summary
    */
    public function summary(){
      $stmt = $this->query("SELECT COUNT(investors.id AS total_investors, COUNT(cap_table.share_class_id) AS total_shares FROM cap_table 
                          JOIN investors on investors.id=cap_table.investor_id");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method to return list of investors with their total shares amount
    */
    public function investors(){
      $stmt = $this->query("SELECT investors.first_name, investors.last_name, investors.company, SUM(cap_table.diluted_shares) FROM investors 
      JOIN cap_table ON cap_table.investor_id=investors.id GROUP BY investors.id");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
