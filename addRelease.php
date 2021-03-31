<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Release</title>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
    </head>
    <body>
        <header>
            <h1>Add Release</h1>
        </header>

        <form method="POST" action="" enctype="multipart/form-data">

            <label for="artist">Artist:</label>
            <input type="text" id="artist" name="artist"><br><br>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title"><br><br>
            
            <label for="label">Label:</label>
            <input type="text" id="label" name="label"><br><br>

            <label for="genre">Genre(s):</label>
            <input type="text" id="genre" name="genre"><br><br>

            <label for="addedBy">Added By:</label>
            <input type="text" id="addedBy" name="addedBy"><br><br>

            <label for="addDate">Date Added (today):</label>
            <input type="date" id="addDate" name="addDate"><br><br>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="8" cols="50"></textarea><br><br>

            <label for="suggTracks">Suggested Tracks:</label>
            <input type="text" id="suggTracks" name="suggTracks" placeholder="1, 2!, 8"><br><br>

            <label for="FCCTracks">FCC Tracks:</label>
            <input type="text" id="FCCTracks" name="FCCTracks" placeholder="1, 3, 6, none"><br><br>

            <label for="cover">Cover:</label>
            <input type="file" id="cover" name="cover" accept=".jpg" accept=".png"><br><br>

            <label for="autoRemove">Auto-Remove after 90 days?</label>
            <input type="checkbox" id="autoRemove" name="autoRemove"><br><br>

            <input type="submit" name = "submit" value="Add Record">
        </form>
    </body>
</html>

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
$autoRemove = 0;
$error = false;
if (isset($_POST["submit"])) {
    if (isset($_POST["artist"])) $artist = htmlspecialchars($_POST["artist"], ENT_QUOTES);
    if (isset($_POST["title"])) $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
    if (isset($_POST["label"])) $label = htmlspecialchars($_POST["label"], ENT_QUOTES);
    if (isset($_POST["genre"])) $genre = htmlspecialchars($_POST["genre"], ENT_QUOTES);
    if (isset($_POST["addedBy"])) $author = htmlspecialchars($_POST["addedBy"], ENT_QUOTES);
    if (isset($_POST["addDate"])) {
        $date = date_create($_POST["addDate"]);
        $addDate = date_format($date, "Y/m/d");
        $autoRemoveDate = date_format(date_add($date, date_interval_create_from_date_string('90 days')), "Y/m/d");
    }
    if (isset($_POST["description"])) $desc = htmlspecialchars($_POST["description"], ENT_QUOTES);
    if (isset($_POST["suggTracks"])) $suggested = htmlspecialchars($_POST["suggTracks"], ENT_QUOTES);
    if (isset($_POST["FCCTracks"])) $FCC = htmlspecialchars($_POST["FCCTracks"], ENT_QUOTES);
    if($_POST["autoRemove"] == "on") $autoRemove = 1;
    $dir="covers/";
    $albumCover=htmlspecialchars($_FILES['cover']['name'], ENT_QUOTES);
    $temp_name=$_FILES['cover']['tmp_name'];
 
    if($albumCover!="")
    {
        if(file_exists($dir.$albumCover))
        {
            $albumCover= time().'_'.$albumCover;
        }
 
        $fdir= $dir.$albumCover;
        move_uploaded_file($temp_name, $fdir);
    }

    if (empty($artist) || empty($title) || empty($label) || empty($genre) || empty($author) || empty($date) || empty($desc) || empty($suggested) || empty($FCC) || empty($albumCover)) {
        $error = true;
    }
    if (!$error) {
        require_once("db.php");
        $sql = "insert into bit4444group41.record(Artist, Title, Label, Genre, Author, DateAdded, Description, Suggested, FCC, AlbumCover, AutoRemove, AutoRemoveDate)
        values ('$artist', '$title', '$label', '$genre', '$author', '$addDate', '$desc', '$suggested', '$FCC', '$albumCover', '$autoRemove', '$autoRemoveDate')";
        $result = $mydb ->query($sql);
        if ($result == 1) {
            echo "<script>alert('Record has been successfully added... Redirecting to home page.')
            window.location.href = 'Main.php'
            </script>";
        }
    }
    else {
        echo "<script>alert('Please enter valid inputs.')</script>";
    }
}

?>