<?php
    require_once('db.php');
    if(isset($_GET['edit'])) {
        $id = $_GET['edit']; //gets id and cover from main page edit button
        $origCover = $_GET['cover'];
        $dir = "covers/";
    }
    $sql = "SELECT * FROM bit4444group41.record WHERE idRecord = '$id'";
    $result = $mydb ->query($sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Release</title>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
    </head>
    <body>
        <header>
            <h1 id="addReleaseTitle">Edit Release</h1>
        </header>

        <form id="addForm" method="POST" action="" enctype="multipart/form-data">

            <?php
                while ($rows = mysqli_fetch_array($result)) { //fills in values based on the record from db
            ?>

            <label for="artist">Artist:</label>
            <input type="text" id="artist" name="artist" value="<?php echo $rows['Artist']; ?>" maxlength="100"><br><br>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $rows['Title']; ?>" maxlength="100"><br><br>
            
            <label for="label">Label:</label>
            <input type="text" id="label" name="label" value="<?php echo $rows['Label']; ?>" maxlength="45"><br><br>

            <label for="genre">Genre(s):</label>
            <input type="text" id="genre" name="genre" value="<?php echo $rows['Genre']; ?>" maxlength="45"><br><br>

            <label for="addedBy">Added By:</label>
            <input type="text" id="addedBy" name="addedBy" value="<?php echo $rows['Author']; ?>" maxlength="100"><br><br>

            <label for="addDate">Date Added (today):</label>
            <input type="date" id="addDate" name="addDate" value="<?php echo $rows['DateAdded']; ?>"><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="8" cols="50" maxlength="1000"><?php echo $rows['Description']; ?></textarea><br><br>

            <label for="suggTracks">Suggested Tracks:</label>
            <input type="text" id="suggTracks" name="suggTracks" placeholder="1, 2!, 8" value="<?php echo $rows['Suggested']; ?>" maxlength="50"><br><br>

            <label for="FCCTracks">FCC Tracks:</label>
            <input type="text" id="FCCTracks" name="FCCTracks" placeholder="1, 3, 6, none" value="<?php echo $rows['FCC']; ?>" maxlength="50"><br><br>

            <!-- cannot set the value of a file input, must re-upload with each edit -->
            <label for="cover">Cover (filename limit 100 characters, <strong>Note: Must re-upload cover for each edit):</strong></label>
            <input type="file" id="cover" name="cover" accept=".jpg" accept=".png" maxlength="100"><br><br>

            <label for="sampleLink">Insert a link to where this album can be sampled (optional):</label>
            <input type="text" id="sampleLink" name="sampleLink" placeholder="https://www.youtube.com/" value="<?php echo $rows['SampleLink']; ?>" maxlength="100"><br><br>

            <label for="autoRemove">Auto-Remove after 90 days?</label>
            <?php if($rows['AutoRemove']==1) {echo "on";} else {echo "off";} ?>
            <input type="checkbox" id="autoRemove" name="autoRemove" <?php if($rows['AutoRemove']==1) {echo "checked";} else {echo "unchecked";} ?>><br><br>

            <?php
                }
            ?>

            <input type="submit" name = "submit" value="Edit Record">
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
        $sql = $mydb->dbConn->prepare("update bit4444group41.record set Artist=?, Title=?, Label=?, Genre=?, Author=?, DateAdded=?, Description=?, Suggested=?, FCC=?, AlbumCover=?, SampleLink=?, AutoRemove=?, AutoRemoveDate=? where idRecord=$id");
        $sql->bind_param('sssssssssssis', $artist, $title, $label, $genre, $author, $dateString, $desc, $suggested, $FCC, $albumCover, $sampleLink, $autoRemove, $autoRemoveDate);
        $result = $sql->execute();
        
        if($result) {
            $dir="covers/";
            $temp_name=$_FILES['cover']['tmp_name'];
 
            if($albumCover!="") {
                if(file_exists($dir.$origCover)) {
                    unlink($dir.$origCover); //removes original cover
                }
 
                $fdir= $dir.$albumCover;
                move_uploaded_file($temp_name, $fdir); //adds new cover
            }
            echo "<script>alert('Record has been successfully edited... Redirecting to home page.')
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