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
drop table if exists aqua.aquariumStandards;

-- テーブルaquariumの作成
create table aqua.aquariumStandards (
    standardId tinyint not null auto_increment,
    standardName varchar(30) not null,
    width int not null,
    height int not null,
    depth int not null,
    amountWater int not null,
    primary key(standardId)
);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(1,'30cm規格水槽',30,18,24,12);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(2,'30cmキューブ水槽',30,30,30,32);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(3,'30cmワイド水槽',30,24,24,17);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(4,'45cm規格水槽',45,24,30,32);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(5,'45cmキューブ水槽',45,45,45,91);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(6,'45cmワイド水槽',45,30,30,40);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(7,'60cm規格水槽',60,30,36,64);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(8,'60cmキューブ水槽',60,60,60,216);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(9,'60cmワイド水槽',60,45,45,121);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(10,'90cm規格水槽',90,45,45,182);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(11,'120cm規格水槽',120,45,45,243);
insert into aqua.aquariumStandards(standardId,standardName,width,height,depth,amountWater) values(12,'180cm規格水槽',180,60,60,648);


-- tableがあるなら削除
drop table if exists aqua.aquariumEnv;

-- テーブルaquariumの作成
create table aqua.aquariumEnv (
    aquariumEnvId char(36) not null,
    standardId tinyint not null,
    configTemp tinyint not null,
    airCompressor varchar(50),
    waterPlant varchar(50),
    flooring  varchar(50),
    primary key(aquariumEnvId),
    foreign key(standardId) references aquariumStandards(standardId)
);

-- tableがあるなら削除
drop table if exists aqua.fish;

-- テーブルfishの作成
create table aqua.fish (
    fishId tinyint auto_increment not null,
    fishName varchar(50) not null,
    area varchar(20) not null,
    ImagePath varchar(50) not null,
    primary key(fishId)
);

insert into aqua.fish(fishName,area,ImagePath) values('kingyo','ocean','../image/kingyo.png');
insert into aqua.fish(fishName,area,ImagePath) values('guppy','fresh','../image/image01.jpg');

-- tableがあるなら削除
drop table if exists aqua.users;

-- ユーザー情報を管理するtableを作成
create table aqua.users (
    userId char(36) not null,
    userName varchar(50) not null,
    userEmail varchar(50) not null,
    password char(60) not null,
    aquariumEnvId char(36),
    created_at datetime not null default current_timestamp,
    update_at datetime not null default current_timestamp on update current_timestamp,
    primary key (userId),
    foreign key(aquariumEnvId) references aquariumEnv(aquariumEnvId)
);

-- tableがあるなら削除
drop table if exists aqua.fish_user;

-- fishテーブルとユーザーテーブルの中間テーブル
create table aqua.fish_user (
    fish_userId char(36) not null,
    userId char(36) not null,
    fishId tinyint not null,
    fishNumber int not null,
    primary key(fish_userId),
    foreign key(userId) references users(userId),
    foreign key(fishId) references fish(fishId)
);

-- tableがあるなら削除
drop table if exists aqua.water;

-- テーブルwaterの作成
create table aqua.water (
    waterId char(36) not null,
    Temp float not null,
    PH float not null,
    SS float not null,
    waterJudge int not null,
    primary key(waterId)
);

-- tableがあるなら削除
drop table if exists aqua.healthStatus;

-- テーブルhealthStatusの作成
create table aqua.healthStatus (
    healthStatusId varchar(36) not null,
    fishImage varchar(50) not null,
    fishJudge int not null,
    primary key(healthStatusId)
);

-- tableがあるなら削除
drop table if exists aqua.calendar;

-- テーブルcalendarの作成
create table aqua.calendar (
    calendarId char(36) not null,
    userId char(36) not null,
    waterId char(36) not null,
    healthStatusId char(36) not null,
    created_at datetime not null default current_timestamp,
    primary key(calendarId),
    foreign key(userId) references users(userId),
    foreign key(waterId) references water(waterId),
    foreign key(healthStatusId) references healthStatus(healthStatusId)
);