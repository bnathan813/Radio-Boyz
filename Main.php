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
                while ($rows = mysqli_fetch_array($result)) {
            ?>
            <div class='container'>
                <img src=<?php echo $rows['AlbumCover']; ?> class='child'>
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
                        <button class="remove">Remove</button>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>