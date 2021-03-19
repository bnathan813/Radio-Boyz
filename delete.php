<?php
    require_once('db.php');
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM bit4444group41.record WHERE idRecord = '$id';";
        $result = $mydb ->query($sql) or die("failed.".mysql_error());
        echo "<meta http-equiv='refresh' content='0;url=Main.php'>";
    }
?>