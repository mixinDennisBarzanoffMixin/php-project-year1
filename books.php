<div class="main">
    <div class="main__left">
        <div class="books">
        <?php
            include 'server.php';
            $sql = "select * from books;";

            $stm = $conn->query($sql);
                foreach ($stm->fetchAll() as $row) {
                    echo '<div class="book-card">
                            <div class="book-card__image"><img src="'.$row[2].'"/></div>
                            <h2 class="book-card__title">'.$row[1].'</h2>
                            <p class="book-card__genre">'.$row[4].'</p>
                            <p class="book-card__description">'.$row[3].'</p>
                            <button class="button book-card__button-one">
                                <span class="button__text">Update</span>
                            </button>
                            <button class="button book-card__button-two">
                                <span class="material-icons icon icon--small">delete</span>
                                <span class="button__text">Delete</span>
                            </button>
                    </div>';
                }
            ?> 
        </div>
    </div>
    <div class="main__right">
        <a class="button">
            <span class="material-icons icon icon--small">edit</span>
            <span class="button__text">Create</span>
        </a>
    </div>
</div>