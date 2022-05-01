drop database if exists books;
create database books;
use books;

create table books (
    isbn_id int auto_increment primary key,
    title varchar(255) not null,
    link varchar(1000) not null
);

insert into books values (null, 'Beauty and the Beast', 'https://google.com/'), (null, 'Beauty and the Abel', 'https://facebook.com');