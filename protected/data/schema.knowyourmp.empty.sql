create table game (
    id int auto_increment primary key,
    name varchar(100)
);

insert into game (name) values ('Познай депутата');
insert into game (name) values ('Познай кой е гласувал за Делян Пеевски');

create table prop (
    id int auto_increment primary key,
    gameid int not null,
    name varchar(500),
    vars varchar(1000) -- color, etc.
);

alter table prop add foreign key (gameid) references game (id);

insert into prop (gameid, name, vars) values (1, 'БСП', '#E30B0B');
insert into prop (gameid, name, vars) values (1, 'ДПС', '#8F0596');
insert into prop (gameid, name, vars) values (1, 'ГЕРБ', '#4759DE');
insert into prop (gameid, name, vars) values (1, 'АТАКА', '#735510');

insert into prop (gameid, name, vars) values (2, 'Гласувал е за', '#E30B0B');
insert into prop (gameid, name, vars) values (2, 'Гласувал е против', '#E30B0B');
insert into prop (gameid, name, vars) values (2, 'Гласувал е въздържал се', '#E30B0B');
insert into prop (gameid, name, vars) values (2, 'Не е участвал в заседанието', '#E30B0B');

create table item (
    id int auto_increment primary key,
    gameid int not null,
    name varchar(500),
    photo varchar(2000),
    corrprop int not null
);

alter table item add foreign key (gameid) references game (id);
alter table item add foreign key (corrprop) references prop (id);

create table gamesess (
    id varchar(100) primary key,
    gameid int,
    startdate datetime,
    lastupdate datetime,
    itemlist varchar(2000),
    listpos int
);

alter table gamesess add foreign key (gameid) references game (id);

create table result (
    id int auto_increment primary key,
    gamesessid varchar(100),
    itemid int,
    guessprop int,
    corrprop int
);

alter table result add foreign key (gamesessid) references gamesess (id);
alter table result add foreign key (itemid) references item (id);
alter table result add foreign key (guessprop) references prop (id);
alter table result add foreign key (corrprop) references prop (id);

alter table result add unique gamesessid_itemid(gamesessid, itemid);

alter table result add column tm datetime;

create table hall (
    id int auto_increment primary key,
    gameid int,
    name varchar(100),
    totalitems int,
    totalvotes int,
    correct int,
    starttime datetime,
    gamesecs int
);

alter table hall add foreign key (gameid) references game (id);
