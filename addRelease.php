<?php
$artist = "";
$title ="";
$label = "";
$genre = "";
$author = "";
$date = date("m/d/y");
$desc = "";
$suggested = "";
$FCC = "";
$cover = "";
$error = false;
if (isset($_POST["submit"])) {
    if (isset($_POST["artist"])) $artist = $_POST["artist"];
    if (isset($_POST["title"])) $title = $_POST["title"];
    if (isset($_POST["label"])) $label = $_POST["label"];
    if (isset($_POST["genre"])) $genre = $_POST["genre"];
    if (isset($_POST["addedBy"])) $author = $_POST["addedBy"];
    if (isset($_POST["addDate"])) $date = $_POST["addDate"];
    if (isset($_POST["description"])) $desc = $_POST["description"];
    if (isset($_POST["suggTracks"])) $suggested = $_POST["suggTracks"];
    if (isset($_POST["FCCTracks"])) $FCC = $_POST["FCCTracks"];
    if (isset($_POST["cover"])) $cover = $_POST["cover"];
    if (empty($artist) || empty($title) || empty($label) || empty($genre) || empty($author) || empty($date) || empty($desc) || empty($suggested) || empty($FCC) || empty($cover)) {
        $error = true;
    }
    if (!$error) {
        require_once("db.php");
        $sql = "insert into bit4444group41.record(Artist, Title, Label, Genre, Author, DateAdded, Description, Suggested, FCC, AlbumCover)
        values ('$artist', '$title', '$label', '$genre', '$author', '$date', '$desc', '$suggested', '$FCC', '$cover')";
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

        <form method="POST" action="">

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

            <input type="submit" name = "submit" value="Add Record">
          </form>
    </body>
</html>