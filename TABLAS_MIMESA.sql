CREATE DATABASE MIMESA character set 'utf8' collate 'utf8_spanish_ci';
use MIMESA;

drop table if exists mesa;
create table mesa(
numMesa int(2) not null,
restaurante varchar(50) not null,
capacidad int(2) not null,
nfila int(1) not null,
ncolumna int(1) not null,
ubicacion varchar(40) not null,
primary key (numMesa,restaurante)
)engine innodb;

insert into mesa values (01,'El Bodegón',2,1,1,'Pasillo Principal');
insert into mesa values (02,'El Bodegón',4,1,2,'Pasillo central');
insert into mesa values (03,'El Bodegón',4,1,3,'Ventana');
insert into mesa values (04,'El Bodegón',2,2,1,'Pasillo Principal');
insert into mesa values (05,'El Bodegón',4,2,2,'Pasillo central');
insert into mesa values (06,'El Bodegón',4,2,3,'Ventana');
insert into mesa values (07,'El Bodegón',8,3,1,'Pasillo Principal');
insert into mesa values (08,'El Bodegón',8,3,2,'Pasillo central');
insert into mesa values (09,'El Bodegón',8,3,3,'Ventana');

insert into mesa values (01,'Las Tres Torres',2,1,1,'Pasillo Principal');
insert into mesa values (02,'Las Tres Torres',4,1,2,'Pasillo central');
insert into mesa values (03,'Las Tres Torres',4,1,3,'Ventana');
insert into mesa values (04,'Las Tres Torres',2,2,1,'Pasillo Principal');
insert into mesa values (05,'Las Tres Torres',4,2,2,'Pasillo central');
insert into mesa values (06,'Las Tres Torres',4,2,3,'Ventana');
insert into mesa values (07,'Las Tres Torres',4,3,1,'Pasillo Principal');
insert into mesa values (08,'Las Tres Torres',8,3,2,'Pasillo central');
insert into mesa values (09,'Las Tres Torres',8,3,3,'Ventana');

drop table if exists reservas;
create table reservas(
numMesa int(2) not null,
restaurante varchar(50) not null,
email varchar(50) not null,
fecha date not null,
hora time not null,
estado enum('L','R','O','PI','EC','S','C','PA'),
numPersonas int(2),
primary key (numMesa,restaurante,email,fecha,hora)
)engine innodb;


insert into reservas values (02,'El Bodegón','maria@gmail.com','2024/05/31','14:00','R',4);
insert into reservas values (03,'El Bodegón','manuel@gmail.com','2024/05/31','14:00','R',2);
insert into reservas values (06,'El Bodegón','juanjo@gmail.com','2024/05/31','14:00','R',3);
insert into reservas values (09,'El Bodegón','adriana@gmail.com','2024/05/31','14:00','PI',4);