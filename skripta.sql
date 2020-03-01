drop database if exists restoran;
create database restoran default character set utf8;
# c:\xampp\mysql\bin\mysql.exe -uedunova -pedunova --default_character_set=utf8 < D:\PP20\maciserver01.hr\skripta.sql


use restoran;
create table korisnik(
sifra			int not null primary key auto_increment,
ime    			varchar(50),
prezime			varchar(50),
email           varchar(50) not null,
lozinka         char(60) not null,
status		    varchar(20) not null,
aktivan         boolean not null default false,
sessionid       varchar(100)
);

#SELECT * FROM osoblje;

insert into korisnik values 
(null, 'Gostoje', 'Gostojubic' ,'gost@edunova.hr', 
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','gost', true, null);

insert into korisnik values 
(null, 'Adam', 'Adminovic', 'admin@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'admin', true, null);

insert into korisnik values 
(null, 'Conor' , 'Konobarevic', 'konobar@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','konobar', true, null);

insert into korisnik values 
(null, 'Kruno', 'Kuharevic', 'kuhar@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','kuhar', true, null);


insert into korisnik (ime, prezime, status, email, lozinka) values
('Dario', 'Romić', 'konobar', 'dario.romic@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW'),
('Igor', 'Ivankov', 'konobar', 'igor.ivankov@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW'),
('Robert', 'Marić', 'konobar', 'robert.maric@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW'),
('David', 'štetić', 'konobar', 'david.stetic@edunova.hr', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW');


insert into korisnik (ime, prezime, status, lozinka, email) values
('Ivano', 'Ivicić', 'kuhar', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'ivano.ivicic@edunova.hr'),
('Silvija', 'Meštar', 'kuhar', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'silvija.mestar@edunova.hr'),
('Krešimir', 'Bartolović', 'kuhar','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'kresimir.bartolovic@edunova.hr');


create table narudzba(
sifra 	int not null primary key auto_increment,
stol 	varchar(5),
cijena	decimal(18,2),
konobar int not null,
ponuda 	int not null,
status	varchar(50)
);


create table stol(
sifra 		int not null primary key auto_increment,
konobar 	int not null,
brojStola	varchar(5),
brojStolica int
);

create table gostNarudzba(
sifraGosta 		int not null,
sifraNarudzbe	int not null
);

create table ponuda(
sifra 		int not null primary key auto_increment,
naziv 		varchar(50) not null,
cijena		decimal(18,2),
kategorija 	varchar(30)
);
select * from ponuda;

#ALTER TABLE stol MODIFY brojStola varchar(5); #mjenjanje tipa podatka u tablici - promjenjeno u varchar(5)
#ALTER TABLE narudzba MODIFY ponuda varchar(50);

#ALTER TABLE narudzba ADD status varchar(50);

#drop table stol;
#select * from osoblje;
#select * from stol;


#alter table stol add foreign key (konobar) references osoblje(sifra);


#alter table narudzba add foreign key (konobar) references osoblje(sifra);
#alter table narudzba add foreign key (stol) references stol(sifra);
#alter table narudzba add foreign key (ponuda) references ponuda(sifra);


#alter table gostNarudzba add foreign key (sifraGosta) references korisnik(sifra);
#alter table gostNarudzba add foreign key (sifraNarudzbe) references narudzba(sifra);




insert into stol (konobar, brojStola, brojStolica) values
(1,'A', 8),
(1,'B', 8),
(1,'C', 8),
(3,'D', 4),
(3,'E', 4),
(3,'F', 4),
(3,'G', 2),
(3,'H', 2),
(4,'P1', 4),
(4,'P2', 4),
(2,'p3', 4),
(2,'P4', 3),
(2,'P5', 3);


insert into ponuda (naziv, kategorija) values
('Juha od bakalara','Juha'),
('Krem juha od gljiva', 'Juha'),
('Junjeca juha s rezancima', 'Juha'),
('Pileći medaljoni u umaku od kikirikija', 'Glavno jelo 1'),
('Svinjsko pecenje na slavonski', 'Glavno jelo 1'),
('Gulaš na maÄ‘arski', 'Glavno jelo 1'),
('Peka od hobotnice', 'Glavno jelo 2'),
('Musaka od batata',  'Glavno jelo 2'),
('Svinjsko pecenje na slavonski', 'Glavno jelo 3'),
('Marinirana svinjska rebra', 'Glavno jelo 3'),
('Teleći rižoto s pestom od špinata', 'Glavno jelo 3'),
('Toćada od liganja ', 'Riba'),
('Morski pas na tršćanski', 'Riba'),
('Bakalar na portugalski', 'Riba'),
('Fishburger', 'Riba'),
('Njoke na maslacu ', 'Prilog'),
('Peceni krumpir s ružmarinom ', 'Prilog'),
('Pirjana riža ', 'Prilog'),
('Ricet krem riža s kukuruzom ', 'Prilog'),
('Pire od buće', 'Prilog'),
('Zelena', 'Salata'),
('Meksicka', 'Salata'),
('Mješana', 'Salata'),
('Indijska','Salata'),
('Palacinka','Desert'),
('Kuglof','Desert'),
('Rajski kolac','Desert');


#select * from ponuda where kategorija='Desert';
update ponuda set cijena= 7+round(5*rand()) where kategorija='Desert';
update ponuda set cijena= 8+round(5*rand()) where kategorija='Juha';
update ponuda set cijena= 25+round(9*rand()) where kategorija='Glavno jelo 1';
update ponuda set cijena= 30+round(10*rand()) where kategorija='Glavno jelo 2';
update ponuda set cijena= 35+round(12*rand()) where kategorija='Glavno jelo 3';
update ponuda set cijena= 22+round(20*rand()) where kategorija='Riba';
update ponuda set cijena= 7+round(10*rand()) where kategorija='Prilog';
update ponuda set cijena= 5+round(10*rand()) where kategorija='Salata';


#select * from narudzba;
