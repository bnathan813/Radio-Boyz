<?php
    require_once('db.php');
    if(isset($_GET['del'])) {
        $id = $_GET['del']; //gets id and cover from main page delete button
        $cover = $_GET['cover'];
        $dir = "covers/";
        unlink($dir.$cover); //removes cover from covers folder
        $sql = "DELETE FROM bit4444group41.record WHERE idRecord = '$id'";
        $result = $mydb ->query($sql);
        echo "<meta http-equiv='refresh' content='0;url=Main.php'>"; //refresh page (alternatively can use ajax for seamless experience)
    }
?>