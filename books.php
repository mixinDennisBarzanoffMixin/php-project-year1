<?php
    include 'server.php';
    $sql = "select * from books;";

    $stm = $conn->query($sql);
    foreach ($stm->fetchAll() as $row) {
        echo '<div class="lol">'.$row[1].'</div>';
    }
