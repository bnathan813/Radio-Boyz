
<?php
    require_once("db.php");
    $sql = "select * from bit4444group41.record";
    $result = $mydb->query($sql);
    while ($row = mysqli_fetch_array($result)) {
        echo $row["Artist"];
    }
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
            <div class="container">
                <img src="DaftPunk.png" class="child">
                <div class="child">
                    <ul>
                        <li>
                            <span class="artist">Daft Punk</span> - <span class="title">Random Access Memories</span>
                        </li>
                        <li>
                            Columbia
                        </li>
                        <li>
                            Electronic
                        </li>
                        <li>
                            Added by: <span class="DJName">Alec</span>
                        </li>
                        <li>
                            3/1/2021
                        </li>                    
                    </ul>
                </div>
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
            </div>
            <div class="container">
                <img src="FlyLo.jfif" class="child">
                <div class="child">
                    <ul>
                        <li>
                            <span class="artist">Flying Lotus</span> - <span class="title">Cosmogramma</span>
                        </li>
                        <li>
                            Warp
                        </li>
                        <li>
                            Electronic
                        </li>
                        <li>
                            Added by: <span class="DJName">Alec</span>
                        </li>
                        <li>
                            3/3/2021
                        </li>                    
                    </ul>
                </div>
                <div class="child">
                    <p>
                        Description: <span class="desc">dank</span>
                    </p>
                </div>
                <div class="childtracks">
                    Suggested Tracks: <span class="sugg">1, 2, 3</span> </br>
                    FCC: <span class="sugg">7</span> </br> </br>
                    <div class="buttonRemove">
                        <button class="remove">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>