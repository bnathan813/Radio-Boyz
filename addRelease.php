
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Release</title>
        <link rel="stylesheet" type="text/css" href="MainStyles.css"/>
    </head>
    <body>
        <header>
            <img src="WUVT.png" class="logo" alt="WUVT logo">
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

            <input type="submit" value="Submit">
          </form>
    </body>
</html>