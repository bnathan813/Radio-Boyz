<?php
$artist = "";
$title ="";
$label = "";
$genre = "";
$author = "";
$date = date_create();
$desc = "";
$suggested = "";
$FCC = "";
$cover = "";
$sampleLink = "";
$autoRemove = 0;
$error = false;
if (isset($_POST["submit"])) {
    if (isset($_POST["artist"])) $artist = $_POST["artist"];
    if (isset($_POST["title"])) $title = $_POST["title"];
    if (isset($_POST["label"])) $label = $_POST["label"];
    if (isset($_POST["genre"])) $genre = $_POST["genre"];
    if (isset($_POST["addedBy"])) $author = $_POST["addedBy"];
    if (isset($_POST["addDate"])) {
        $date = date_create($_POST["addDate"]);
        $dateString = date_format($date, "Y/m/d"); //formats date correctly
        $autoRemoveDate = date_format(date_add($date, date_interval_create_from_date_string('90 days')), "Y/m/d"); //adds 90 days for autoRemoveDate
    }
    if (isset($_POST["description"])) $desc = $_POST["description"];
    if (isset($_POST["suggTracks"])) $suggested = $_POST["suggTracks"];
    if (isset($_POST["FCCTracks"])) $FCC = $_POST["FCCTracks"];
    $sampleLink = $_POST["sampleLink"]; //optional
    if(isset($_POST["autoRemove"]) && $_POST["autoRemove"] == "on") $autoRemove = 1;    
    $albumCover=$_FILES['cover']['name'];
    
    if (empty($artist) || empty($title) || empty($label) || empty($genre) || empty($author) || empty($date) || empty($desc) || empty($suggested) || empty($FCC) || empty($albumCover)) {
        $error = true;
    }
    if (!$error) {
        require_once("db.php");
        /* alternate query, causes problems with special chars
        $sql = "insert into bit4444group41.record(Artist, Title, Label, Genre, Author, DateAdded, Description, Suggested, FCC, AlbumCover, AutoRemove, AutoRemoveDate)
        values ('$artist', '$title', '$label', '$genre', '$author', '$dateString', '$desc', '$suggested', '$FCC', '$albumCover', '$autoRemove', '$autoRemoveDate')";
        $result = $mydb ->query($sql);*/
        $sql = $mydb->dbConn->prepare("insert into bit4444group41.record(Artist, Title, Label, Genre, Author, DateAdded, Description, Suggested, FCC, AlbumCover, SampleLink, AutoRemove, AutoRemoveDate)
        values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param('sssssssssssis', $artist, $title, $label, $genre, $author, $dateString, $desc, $suggested, $FCC, $albumCover, $sampleLink, $autoRemove, $autoRemoveDate);
        $result = $sql->execute();
        
        if($result) {
            $dir="covers/";
            $temp_name=$_FILES['cover']['tmp_name'];
 
            if($albumCover!="") {
                if(file_exists($dir.$albumCover)) {
                    $albumCover= time().'_'.$albumCover; //if duplicate album cover, adds digits to filename
                }
 
                $fdir= $dir.$albumCover;
                move_uploaded_file($temp_name, $fdir);
            }
            echo "<script>alert('Record has been successfully added... Redirecting to home page.')
            window.location.href = 'Main.php'
            </script>";
        }
        else {
            echo "<script>alert('Please enter valid inputs.')</script>";
        }
    }
    else {
        echo "<script>alert('Please enter valid inputs.')</script>";
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Release</title>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
    </head>
    <body>
        <header>
            <h1 id="addReleaseTitle">Add Release</h1>
        </header>

        <form id="addForm" method="POST" action="" enctype="multipart/form-data">

            <label for="artist">Artist:</label>
            <input type="text" id="artist" name="artist" value="<?php echo $artist; ?>" maxlength="100"><br><br>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>" maxlength="100"><br><br>
            
            <label for="label">Label:</label>
            <input type="text" id="label" name="label" value="<?php echo $label; ?>" maxlength="45"><br><br>

            <label for="genre">Genre(s):</label>
            <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>" maxlength="45"><br><br>

            <label for="addedBy">Added By:</label>
            <input type="text" id="addedBy" name="addedBy" value="<?php echo $author; ?>" maxlength="100"><br><br>

            <label for="addDate">Date Added (today):</label>
            <input type="date" id="addDate" value="<?php if(isset($_POST["addDate"])) echo $_POST["addDate"]; ?>" name="addDate"><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="8" cols="50" value="<?php echo $desc; ?>" maxlength="1000"></textarea><br><br>

            <label for="suggTracks">Suggested Tracks:</label>
            <input type="text" id="suggTracks" name="suggTracks" placeholder="1, 2!, 8" value="<?php echo $suggested; ?>" maxlength="50"><br><br>

            <label for="FCCTracks">FCC Tracks:</label>
            <input type="text" id="FCCTracks" name="FCCTracks" placeholder="1, 3, 6, none" value="<?php echo $FCC; ?>" maxlength="50"><br><br>

            <label for="cover">Cover (filename length limit 100 characters):</label>
            <input type="file" id="cover" name="cover" accept=".jpg" accept=".png" maxlength="100"><br><br>

            <label for="sampleLink">Insert a link to where this album can be sampled (optional):</label>
            <input type="text" id="sampleLink" name="sampleLink" placeholder="https://www.youtube.com/" value="<?php echo $sampleLink; ?>" maxlength="100"><br><br>

            <label for="autoRemove">Auto-Remove after 90 days?</label>
            <input type="checkbox" id="autoRemove" <?php if($autoRemove==1) {echo "checked";} else {echo "unchecked";} ?> name="autoRemove"><br><br>

            <input type="submit" name = "submit" value="Add Record">
        </form>
    </body>
</html>