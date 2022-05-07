<?php
    include 'server.php';
    $sql = "select * from books;";

    $stm = $conn->query($sql);
    echo '<div class="books">';
    foreach ($stm->fetchAll() as $row) {
        echo '<div class="book-card">';
            echo '<div class="book-card__image"><img src="'.$row[2].'"/></div>';
            echo '<h2 class="book-card__title">'.$row[1].'</h2>';
            echo '<p class="book-card__genre">'.$row[4].'</p>';
            echo '<p class="book-card__description">'.$row[3].'</p>';
            echo '<button class="book-card__button-one">Update</button>';
            echo '<button class="book-card__button-two">Delete</button>';
        echo '</div>';
    }
    echo '</div>';