<?php
  require_once("config.php");

  class MySQLDB {
    private $dbConn;

    public function openConnection() {
      $this->dbConn = mysqli_init();
      mysqli_ssl_set($this->dbConn,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);

      mysqli_real_connect($this->dbConn, DB_HOST, DB_USER, DB_PASS,  DB_NAME, DB_PORT, MYSQLI_CLIENT_SSL);

      if(mysqli_connect_errno()) {
        die( "Database connection error: ".mysqli_connect_error()."(".mysqli_connect_errno().")" );
      }
    }

    public function close_connection() {
      if(isset($this->dbConn)) {
        mysqli_close($this->dbConn);
        unset($this->dbConn);
      }
    }

    public function query($sql) {
      $result = mysqli_query($this->dbConn, $sql);
      if(!$result) {
        die("Database query error: ".mysqli_error($this->dbConn)." (".mysqli_errno($this->dbConn).")");
      }
      return $result;
    }

    public function jsonQuery($sql) {
      $result = mysqli_query($this->dbConn, $sql);
      if(!$result) {
        die("Database query error: ".mysqli_error($this->dbConn)." (".mysqli_errno($this->dbConn).")");
      }

      $data = array();
      for($x=0; $x<mysql_num_rows($result);$x++){
        $data[] = mysqli_fetch_assoc($result);
      }
      
      return json_encode($data);
    }

    function __construct(){
      $this->openConnection();
    }
  }

  $mydb = new MySQLDB();
  //$result=$mydb->query("select * from customer");
  //var_dump($result);
?>
