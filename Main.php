<?php
    require_once("db.php");
    $sql = "select * from bit4444group41.record order by DateAdded DESC";
    $result = $mydb->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>WUVT New Music Rotation</title>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
    </head>
    <body>
        <img src="WUVT.png" class="logo" alt="WUVT logo">
        <h1>New Music Rotation</h1>
        <a class="add" href="addRelease.php">Add Release</a>

        <div class="list">
            <?php
                while ($rows = mysqli_fetch_array($result)) {
                    if($rows['AutoRemoveDate'] <= date("Y-m-d") && $rows['AutoRemove'] == 1) {
                        $id = $rows['idRecord'];
                        $cover = $rows['AlbumCover'];
                        $dir = "covers/";
                        unlink($dir.$cover);
                        $autoDeletesql = "DELETE FROM bit4444group41.record WHERE idRecord = '$id'";
                        $autoDeleteresult = $mydb ->query($autoDeletesql);
                        echo "<meta http-equiv='refresh' content='0;url=Main.php'>";
                    }
            ?>
            <div class='container'>
                <img src="covers/<?php echo $rows['AlbumCover'];?>" class='child'>
                <div class='child'>
                    <ul>
                        <li>
                            <span class='artist'><?php echo $rows['Artist']; ?></span> - <span class='title'><?php echo $rows['Title']; ?></span>
                        </li>
                        <li>
                            <?php echo $rows['Label']; ?>
                        </li>
                        <li>
                            <?php echo $rows['Genre']; ?>
                        </li>
                        <li>
                            Added by: <span class='DJName'><?php echo $rows['Author']; ?></span>
                        </li>
                        <li>
                            <?php echo $rows['DateAdded']; ?>
                        </li>
                        <li>
                            <?php
                                if($rows['AutoRemove'] == 1) {
                                    echo "<strong>Auto-Remove on: ".$rows['AutoRemoveDate']."</strong>";
                                }
                            ?>
                        </li>
                    </ul>
                </div>
                            
                <div class="child">
                    <p>
                        Description: <span class="desc"><?php echo $rows['Description']; ?></span>
                    </p>
                </div>
                <div class="childtracks">
                    Suggested Tracks: <span class="sugg"><?php echo $rows['Suggested']; ?></span> </br>
                    FCC: <span class="sugg"><?php echo $rows['FCC']; ?></span> </br> </br>
                    <div class="buttonRemove">
                        <a class="remove" href="delete.php?del=<?php echo $rows['idRecord']; ?>&cover=<?php echo $rows['AlbumCover']; ?>">Remove</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>