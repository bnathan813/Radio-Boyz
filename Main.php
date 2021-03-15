
<?php
    require_once("db.php");
    $sql = "select * from bit4444group41.record";
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
        <button class="add">Add Release</button>

        <div class="list">
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='container'>";
                        echo "<img src=".$row['AlbumCover']." class='child'>";
                        echo "<div class='child'>
                            <ul>
                                <li>";
                                    echo "<span class='artist'>".$row['Artist']."</span> - <span class='title'>".$row['Title']."</span>";
                                echo "</li>
                                <li>";
                                    echo $row['Label'];
                                echo "</li>
                                <li>";
                                    echo $row['Genre'];
                                echo "</li>
                                <li>
                                    Added by: <span class='DJName'>";echo $row['Author']; echo "</span>
                                </li>
                                <li>";
                                    echo $row['DateAdded'];
                                echo "</li>                    
                            </ul>
                        </div>";
                        /*
                        <div class="child">
                            <p>
                                Description: <span class="desc"></span>
                            </p>
                        </div>
                        <div class="childtracks">
                            Suggested Tracks: <span class="sugg">1, 2, 3</span> </br>
                            FCC: <span class="sugg">9</span> </br> </br>
                            <div class="buttonRemove">
                                <button class="remove">Remove</button>
                            </div>
                        </div>
                    </div> */
                }
            ?>
        </div>
    </body>
</html>