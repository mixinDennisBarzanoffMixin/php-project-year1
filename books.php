<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie-Bookie</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet" layer="icon">
    <link rel="stylesheet" href="shared.css"/>
    <link rel="stylesheet" href="books.css"/>
</head>
<body>
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
                                <form class="book-card__button-two" method="post" action="/delete.php" data-isbn="'.$row[0].'">
                                    <input name="isbn" value="'.$row[0].'" type="hidden"/>
                                    <button class="button">
                                        <span class="material-icons icon icon--small">delete</span>
                                        <span class="button__text">Delete</span>
                                    </button>
                                </form>
                        </div>';
                    }
                ?> 
            </div>
        </div>
        <div class="main__right">
            <a class="button" href="/create.php">
                <span class="material-icons icon icon--small">edit</span>
                <span class="button__text">Create</span>
            </a>
        </div>
    </div>
</body>
<script>
    const buttons = document.querySelectorAll('.main .book-card__button-two');
    for (const button of buttons) {
        button.addEventListener('click', async () => {
            // const isbn = button.getAttribute('data-isbn');
            button.submit();

            console.log(content);
        });
    }
</script>
</html>