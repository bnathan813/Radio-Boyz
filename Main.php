<?php
    require_once("db.php");
    $sql = "select * from bit4444group41.record order by DateAdded DESC, idRecord DESC";
    $result = $mydb->query($sql);
    date_default_timezone_set('EST');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>WUVT New Music Rotation</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <script src="color-thief.min.js"></script>
        <script src="jquery-3.1.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
        <script>
            var colorThief = new ColorThief(); //JS library from GitHub, gets dominant colors of album cover for styling. Doesn't quite work right. Maybe try jQuery.

            function rgb(color) {
                return 'rgb(' + color.join(', ') + ')'; //converts array of nums to rbg for css
            }

            function setColors() { //for every cover in class "cover", get its palette (dominant colors) and set colors to first 3
                for (i=0; i<=document.getElementsByClassName("cover").length; i++) {
                    var img = document.getElementsByClassName('cover')[i];
                    var palette = colorThief.getPalette(img);
                    img.parentNode.parentNode.parentNode.style.backgroundColor = rgb(palette[1]); //refers to the album's container box id="release"
                    img.parentNode.parentNode.parentNode.style.color = rgb(palette[0]);
                    img.parentNode.parentNode.parentNode.style.boxShadow = "5px 5px 5px " + rgb(palette[2]);
                }
            }
            function init() {                
                setColors();
            }
            window.addEventListener("DOMContentLoaded", init, false);
        </script>
    </head>
    <body>
        <header>
            <div class='container-fluid' id="header">
                <div class='row' id="headerRow">
                    <div class='col-xs-12 col-sm-4 headerElement'>
                        <img src="WUVT.png" class="logo" alt="WUVT logo">
                    </div>
                    <div class='col-xs-12 col-sm-4 headerElement' id="pageTitle">
                        New Music Rotation
                    </div>
                    <div class='col-xs-12 col-sm-4 headerElement'>
                        <a id="add" href="addRelease.php"><button class="btn btn-success btn-lg">Add Release</button></a>
                    </div>                    
                </div>
            </div>
        </header>

        <div id="releaseList">
            <?php
                while ($rows = mysqli_fetch_array($result)) { //bracket closes line 123 (for every row in db create everything below)
                    if($rows['AutoRemoveDate'] <= date("Y-m-d") && $rows['AutoRemove'] == 1) {
                        $id = $rows['idRecord'];
                        $cover = $rows['AlbumCover'];
                        $dir = "covers/";
                        unlink($dir.$cover); //remove cover from covers folder
                        $autoDeletesql = "DELETE FROM bit4444group41.record WHERE idRecord = '$id'";
                        $autoDeleteresult = $mydb ->query($autoDeletesql);
                        echo "<meta http-equiv='refresh' content='0;url=Main.php'>";
                    }
            ?>
            <div class='container' id='release'>
                <div class='row' id='releaseInfo'>
                    <div class='col-xs-12 col-sm-8 col-md-3'>
                        <img src="covers/<?php echo $rows['AlbumCover'];?>" class='cover'>
                    </div>
                    <div class='col-xs-12 col-sm-4 col-md-2'>
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
                                Added by: <?php echo $rows['Author']; ?>
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
                                
                    <div class='col-xs-12 col-sm-9 col-md-5'>
                        <p>
                            Description: <?php echo $rows['Description']; ?>
                        </p>
                    </div>
                    <div class='col-xs-12 col-sm-3 col-md-2'>
                        Suggested Tracks: <?php echo $rows['Suggested']; ?> </br>
                        FCC: <?php echo $rows['FCC']; ?> </br> </br>
                        <?php
                            if($rows['SampleLink'] != "") {
                                echo "<a id='sampleLink' href=".$rows['SampleLink']." target='_blank'><button class='btn'>Click here to sample</button></a>";
                            }
                        ?>
                        </br></br>
                        <a id="edit" href="editRelease.php?edit=<?php echo $rows['idRecord']; ?>&cover=<?php echo $rows['AlbumCover']; ?>"><button class="btn">Edit</button></a>
                        </br></br>
                        <a id="remove" href="delete.php?del=<?php echo $rows['idRecord']; ?>&cover=<?php echo $rows['AlbumCover']; ?>"><button class="btn btn-danger">Remove</button></a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>