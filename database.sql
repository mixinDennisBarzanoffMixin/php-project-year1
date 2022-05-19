drop database if exists books;
create database books;
use books;

create table books (
    isbn_id int auto_increment primary key,
    title varchar(255) not null,
    link varchar(1000) not null,
    summary varchar(255) not null,
    genre varchar(80) not null
);

create table users (
    id varchar(255) primary key
);

create table likes (
    user_id varchar(255) references users(id) on delete cascade,
    book_id varchar(255) references books(isbn_id) on delete cascade
);

insert into books values 
    (null, 'Beauty and the Beast', 'https://m.media-amazon.com/images/M/MV5BMTUwNjUxMTM4NV5BMl5BanBnXkFtZTgwODExMDQzMTI@._V1_.jpg', "An arrogant young prince (Robby Benson) and his castle's servants fall under the spell of a wicked enchantress, who turns him into the hideous Beast until he learns to love and be loved in return. ", "romance/fantasy"), 
    (null, 'The Lion King', 'https://upload.wikimedia.org/wikipedia/en/9/9d/Disney_The_Lion_King_2019.jpg', "This Disney animated feature follows the adventures of the young lion Simba (Jonathan Taylor Thomas), the heir of his father, Mufasa (James Earl Jones). ", "adventury/drama");
