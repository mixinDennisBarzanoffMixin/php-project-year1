<?php
    if (isset($_POST['userId']))
        $userId = $_POST['userId'];
    if (isset($_POST['bookId']))
        $bookId = $_POST['bookId'];

    if ($bookId == null || $userId == null) die('Please provide a valid bookId and userId');
    
    // TODO:
    // validate user id and token

    require 'server.php';

    $stmt = $conn->prepare('SELECT 1 from users where id = ?');
    $result = $stmt->execute([$userId]);
    if ($stmt->rowCount() == 0) {
        $stmt = $conn->prepare('INSERT INTO users VALUES (?)');
        $result = $stmt->execute([$userId]);
    }


    // like or dislike
    $stmt = $conn->prepare('SELECT user_id, book_id from likes where user_id = ? and book_id = ?');
    $result = $stmt->execute([$userId, $bookId]);

    if ($stmt->rowCount() == 0) {
        $stmt = $conn->prepare('INSERT INTO likes VALUES (?, ?)');
        $result = $stmt->execute([$userId, $bookId]);
    }
    else {
        $stmt = $conn->prepare('DELETE FROM likes WHERE user_id = ? AND book_id = ?');
        $result = $stmt->execute([$userId, $bookId]);
    }
    header("Location: books.php");

    function isValidUserId($userId) {
        return $userId != null;
    }
    ?>