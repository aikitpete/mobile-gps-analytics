drop table if exists users;
drop table if exists usagedata;

create table users (
	uid INT NOT NULL auto_increment,
	name varchar(20) NOT NULL,
	surname varchar(20) NOT NULL,
	email varchar(40) NOT NULL,
	password char(40) NOT NULL,
	feedback char(160) NOT NULL,
	category char(20) NOT NULL,
	primary key(uid),
	unique(email)
) CHARACTER SET = utf8;

insert into users (name,surname,email,password,feedback,category) values
("Peter","Gerhat","peto.gerhat@gmail.com","piglin","default","user_admin"),
("Jack","Smith","shijunpeng66@gmail.com","123456","default","data_admin"),
("Emelie","Torstensson","emelie@emelietorstensson.se","123456","default","data_admin"),
("John","Doe","john.doe@mail.com","password","default","data_analyst");


create table usagedata (
	id INT NOT NULL auto_increment,
	uid INT NOT NULL,
	latitude DOUBLE NOT NULL,
	longitude DOUBLE NOT NULL,
	altitude DOUBLE NOT NULL,
	accuracy INT NOT NULL,
    batterycharging boolean NOT NULL,
    batterystatus DOUBLE NOT NULL,
    batterysupported boolean NOT NULL,
    chippresent boolean NOT NULL,
    timedatestamp timestamp NOT NULL,
	notes varchar(160) NULL,
    geolocation0 varchar(40) NULL,
    geolocation1 varchar(40) NULL,
    geolocation2 varchar(40) NULL,
    geolocation3 varchar(20) NULL,
    geolocation4 varchar(20) NULL,
    geolocation5 varchar(20) NULL,
    geolocation6 varchar(20) NULL,
    geolocation7 varchar(20) NULL,
	primary key(id)
) CHARACTER SET = utf8;

set names utf8;
insert into usagedata (uid,latitude,longitude,altitude,accuracy,batterycharging,batterystatus,
                       batterysupported,chippresent,timedatestamp) values
('2','55.7','13.1','10','20','false','0.5','false','false','2014-01-01 00:00:01');

