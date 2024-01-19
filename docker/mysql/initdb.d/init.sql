-- utf8を設定
set names utf8;
-- データベースが存在しているなら削除する
drop database if exists `aqua`;
-- データベースaquaの作成
create database if not exists `aqua` character set utf8 collate utf8_general_ci;
-- 許可を設定
grant all privileges on *.* to 'test'@'%';

-- aquaデータベースを選択
use `aqua`;

-- tableがあるなら削除
drop table if exists aqua.fish;

-- tableがあるなら削除
drop table if exists aqua.users;

-- ユーザー情報を管理するtableを作成
create table aqua.users (
    userID char(36) not null,
    userName varchar(50) not null,
    userEmail varchar(50) not null,
    password char(60) not null,
    created_at datetime not null default current_timestamp,
    update_at datetime not null default current_timestamp on update current_timestamp,
    primary key (userID),
);

-- tableがあるなら削除
drop table if exists aqua.condition;

-- ユーザー情報を管理するtableを作成
create table aqua.condition (
    conditionID char(36) not null,
    result int not null,
    value int,
    imgPath varchar(20) not null,
    userID char(36) not null,
    created_at datetime not null default current_timestamp,
    primary key (conditionID),
    foreign key(userID) references users(userID),
);