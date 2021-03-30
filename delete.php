<?php
    require_once('db.php');
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $cover = $_GET['cover'];
        $dir = "covers/";
        unlink($dir.$cover);
        $sql = "DELETE FROM bit4444group41.record WHERE idRecord = '$id'";
        $result = $mydb ->query($sql);
        echo "<meta http-equiv='refresh' content='0;url=Main.php'>";
    }
?>