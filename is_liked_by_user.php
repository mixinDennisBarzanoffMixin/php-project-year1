<?php
    require 'server.php';
    if (isset($_POST['userId']))
        $userId = $_POST['userId'];
    if (isset($_POST['bookId']))
        $bookId = $_POST['bookId'];
    if ($bookId == null || $userId == null) die('Please provide a valid bookId and userId');
    $stmt = $conn->prepare('SELECT user_id, book_id from likes where user_id = ? and book_id = ?');
    $result = $stmt->execute([$userId, $bookId]);
    if ($stmt->rowCount() == 0) {
        echo '{"contains": false}';
        return;
    }
    echo '{"contains": true}';
    return;