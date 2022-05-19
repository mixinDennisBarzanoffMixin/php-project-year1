<?php
    if (isset($_POST['isbn']))
        $isbn = $_POST['isbn'];
    
    if (!isValidIsbn($isbn)) {
        echo 'invalid isbn';
        die();
    }

    require 'server.php';


    $stmt = $conn->prepare('delete from books where isbn_id = ?');
    $result = $stmt->execute([$isbn]);


    if ($result === TRUE) {
        header("Location: books.php");
    } else {
        echo 'error';
    }

    function isValidIsbn($isbn) {
        return $isbn != null;
    }
    ?>