create table users(
    id int auto_increment primary key,
    email varchar(60) unique not null,
    password varchar(250) not null,
    foto varchar(100) not null, 
    isAdmin boolean default 0
);
create table posts(
    id int auto_increment primary key,
    titulo varchar(60) not null,
    descripcion varchar(250) not null,
    imagen varchar(100) not null, 
    user int not null,
    constraint fk_posts_users foreign key(user) references users(id) on delete cascade on update cascade
);
