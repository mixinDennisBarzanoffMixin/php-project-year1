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
    <?php 
        include 'client_auth.php';
    ?>
</head>
<body>
    <nav id="nav">
    </nav>
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
                                <form class="bookmark" method="post" action="/like.php" data-isbn="'.$row[0].'">
                                    <span class="material-icons icon icon--medium like-icon" data-isbn="'.$row[0].'">favorite</span>
                                </form>
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
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
  import { getAuth, GoogleAuthProvider, signInWithPopup } from 'https://www.gstatic.com/firebasejs/9.8.1/firebase-auth.js';

  const firebaseConfig = {
    apiKey: "AIzaSyBqcfmNnUg23nNXHKh43oMZrERUElS08U8",
    authDomain: "php-book-website.firebaseapp.com",
    projectId: "php-book-website",
    storageBucket: "php-book-website.appspot.com",
    messagingSenderId: "705508715221",
    appId: "1:705508715221:web:2c60642bb1db586a3a505c"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const auth = getAuth();

  function createAvatarElement() {
    const profileURL = window.localStorage.getItem('profileURL');
    const img = document.createElement('img');
    img.setAttribute('src', profileURL);
    img.setAttribute('alt', 'Avatar');
    img.classList.add('avatar');
    return img;
  }
  function createLogoutElement() {
        const logoutButton = document.createElement('a');
        logoutButton.classList.add('button');
        const text = document.createElement('span');
        text.classList.add('button__text');
        text.innerText = 'Log out';

        logoutButton.style = 'padding-right: 1rem;';
        logoutButton.appendChild(text);
        logoutButton.addEventListener('click',  () => {
            auth.signOut();
            localStorage.removeItem('profileURL');
            localStorage.removeItem('token');
            const nav = document.getElementById('nav');
            nav.innerHTML = '';
            nav.appendChild(createLoginElement()); 
        });
        return logoutButton;
  }

  function createLoginElement() {
        const signInButton = document.createElement('a');
        signInButton.classList.add('button');
        signInButton.style = 'margin-right: 1rem;'
        const text = document.createElement('span');
        text.classList.add('button__text');
        text.innerText = 'Sign in';
        signInButton.appendChild(text);
        signInButton.addEventListener('click', () => {
            var provider = new GoogleAuthProvider();
            provider.addScope('https://www.googleapis.com/auth/contacts.readonly');
            auth.languageCode = 'de';
            provider.setCustomParameters({
                'login_hint': 'user@example.com'
            });
            signInWithPopup(auth, provider)
                .then((result) => {
                    /** @type {firebase.auth.OAuthCredential} */
                    // This gives you a Google Access Token. You can use it to access the Google API.
                    console.log(result);
                    var token = result.user.accessToken;
                    window.localStorage.setItem('token', token);
                    window.localStorage.setItem('profileURL', result.user.photoURL);
                    window.localStorage.setItem('userId', result.user.uid);
                    // window.localStorage.setItem('profileURL', result.user.user);
                    document.getElementById('nav').innerHTML = '';
                    document.getElementById('nav').appendChild(createLogoutElement());
                    document.getElementById('nav').appendChild(createAvatarElement());
                }).catch((error) => {
                    // Handle Errors here.
                    var errorCode = error.code;
                    var errorMessage = error.message;
                    console.log(errorMessage);
                    // The email of the user's account used.
                    var email = error.email;
                    // The firebase.auth.AuthCredential type that was used.
                    var credential = error.credential;
                    // ...
                });
        });
        return signInButton;
  }

    const token = window.localStorage.getItem('token');
    if (token == null) {
        console.log('checking...');

        console.log(document.getElementById('nav'));
        document.getElementById('nav').appendChild(createLoginElement()); 

    } else {
        document.getElementById('nav').appendChild(createLogoutElement());
        document.getElementById('nav').appendChild(createAvatarElement());
    }

    document.querySelectorAll('.like-icon').forEach(async (e) => {
        e.addEventListener('click', async () => {
            console.log('exec');
            const formData = new FormData();
            formData.append('token', localStorage.getItem('token'));
            formData.append('userId', localStorage.getItem('userId'));
            formData.append('bookId', e.attributes['data-isbn'].value);
        
            const response = await fetch('/like.php', { method: 'POST', body: formData })
            console.log(response.text());
            location.reload();
        });
        const formData = new FormData();
        formData.append('token', localStorage.getItem('token'));
        formData.append('userId', localStorage.getItem('userId'));
        formData.append('bookId', e.attributes['data-isbn'].value);
    
        const response = await fetch('/is_liked_by_user.php', { method: 'POST', body: formData })
        // console.log(response);
        const isLiked = JSON.parse(await response.text()).contains;
        if (isLiked) {
            e.classList.add('selected');
        }
    });
    
</script>
</html>