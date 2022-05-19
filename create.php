<?php
    require 'server.php';
    $name = '';
    $description = '';
    $url = '';
    $genre = '';
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['title']))
            $name = $_POST['title'];
        if (isset( $_POST['url']))
            $url = $_POST['url'];
        if (isset($_POST['description'])) 
            $description = $_POST['description'];
        if (isset($_POST['genre'])) 
            $genre = $_POST['genre'];
        
        if (isValidName($name) && isValidUrl($url) && isValidDescription($description) && isValidGenre($genre)){
            $stmt = $conn->prepare('insert into books (isbn_id, title, link, summary, genre) values (null, ?, ?, ?, ?)');
            $result = $stmt->execute(array($name, $url, $description, $genre));


            if ($result === TRUE) {
                header("Location: books.php");
                die();
            } else {
                $error = 'Something was not right';
            }
        } else {
            $error = 'Please set all parameters';
        } 
    }
   function isValidName($name) {
        return $name != '';
   } 
   function isValidGenre($genre) {
        return $genre != '';
   } 
   function isValidUrl($url) {
       return $url != '';
   }
   function isValidDescription($description) {
       return $description != '';
   }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie-Bookie</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" layer="icon">
    <link rel="stylesheet" href="shared.css" />
    <link rel="stylesheet" href="create.css" />
</head>

<body>
    <form id="create-form" action="/create.php" method="post">
        <h2>Create a new book</h2>
        <label>
            Name: <br>
            <?php
                echo '<input type="text" placeholder="Tweety" name="title" value="'.$name.'" />';
            ?>
        </label>

        <label>
            Description: <br>
            <?php
                echo '<textarea type="text" placeholder="Once upon a time.." name="description" value="'.$description.'"></textarea>';
            ?>
        </label>
        <label>
            Image URL: <br>
            <?php
                echo '<input type="text" placeholder="https://www.google.com/image.jpg" name="url" value="'.$url.'" />';
            ?>
        </label>
        <label>
            Genre: <br>
            <?php
                echo '<input type="text" placeholder="fantasy" name="genre" value="'.$genre.'" />';
            ?>
        </label>
        <button class="button" id="submit">
            <span class="button__text">Create</span>
        </button>
        <?php
            echo '<span class="error">'.$error.'</span>';
        ?>
    </form>
</body>
<script>
    document.getElementById('submit').addEventListener('click', () => {
        document.getElementById('create-form').submit();
    });
</script>

</html>