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
bodovi			int not null default 0,
aktivan         boolean not null default true,
sessionsifra    varchar(100)
);


select * from korisnik;
insert into korisnik values 
(null, 'Gostoje', 'Gostojubic' ,'gost@edunova.hr', 
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','gost', 0, true, null);

insert into korisnik values 
(null, 'Adam', 'Adminovic', 'admin@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'admin', 0, true, null);

insert into korisnik values 
(null, 'Conor' , 'Konobarevic', 'konobar@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','konobar', 0, true, null);

insert into korisnik values 
(null, 'Kruno', 'Kuharevic', 'kuhar@edunova.hr',
'$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW','kuhar', 0, true, null);


insert into korisnik (ime, prezime, status, email, lozinka, aktivan) values
('Dario', 'Romic', 'konobar', 'dario.romic@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 1),
('Igor', 'Ivankov', 'konobar', 'igor.ivankov@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 1),
('Robert', 'Maric', 'gost', 'robert.maric@edunova.hr','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 1),
('David', 'Stetic', 'gost', 'david.stetic@edunova.hr', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 1);


insert into korisnik (ime, prezime, status, lozinka, email) values
('Ivano', 'Ivicic', 'gost', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'ivano.ivicic@edunova.hr'),
('Silvija', 'Mestar', 'kuhar', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'silvija.mestar@edunova.hr'),
('Kresimir', 'Bartolovic', 'kuhar','$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 'kresimir.bartolovic@edunova.hr');



create table stol(
sifra 		int not null primary key auto_increment,
brojStola	varchar(18),
brojStolica int
);


CREATE TABLE ponuda (
  sifra 		int NOT null primary key AUTO_INCREMENT,
  naziv 		varchar(255) NOT NULL,
  opis 		    text,
  vrijeme		int DEFAULT NULL,
  kategorija  	int not null,
  cijena 	    decimal(10,2) NOT NULL DEFAULT '0.00'
); 
ALTER TABLE ponuda ADD KEY naziv (naziv);

create table narudzba (
	sifra 			int NOT null primary key AUTO_INCREMENT,
	korisnik 		int not null,
	kosara			int not null,
 	status			int not null default 1,
 	vrijemeNarudzbe datetime default current_timestamp
);

create table status (
sifra	int not null primary key auto_increment,
stanje	varchar(50)
);

CREATE TABLE kosara (
	sifra 			int NOT null primary key AUTO_INCREMENT,
	sessionID		varchar(50),
	vrijeme			varchar(50),
	cijena			decimal(10,2),
	stol			int not null default 1

); 



CREATE TABLE kosara_ponuda (
  kosara_sifra        int(11) NOT null,
  ponuda_sifra        int(11) NOT null,
  kolicina  int(11) NOT null default 1
);

create table kategorija(
sifra	int not null primary key auto_increment,
nazivKat	varchar(50)
);



alter table kosara_ponuda add foreign key (kosara_sifra) references kosara(sifra);
alter table kosara_ponuda add foreign key (ponuda_sifra) references ponuda(sifra);


alter table narudzba add foreign key (korisnik) references korisnik(sifra);
alter table narudzba add foreign key (kosara) references kosara(sifra);
alter table narudzba add foreign key (status) references status(sifra);

alter table ponuda add foreign key (kategorija) references kategorija(sifra);

alter table kosara add foreign key (stol) references stol(sifra);

insert into kategorija (nazivKat) values
('Juha'),
('Glavno jelo 1'), 
('Glavno jelo 2'), 
('Glavno jelo 3'), 
('Riba'),('Prilog'), 
('Salata'),
('Desert');

insert into status (stanje) values
('Zaprimljeno'),
('Spremno'),
('Posluzeno'),
('Naplaceno'),
('Gotovo');

insert into stol (brojStola, brojStolica) values 
('Odaberi stol',0),
('A1', 6),
('A2', 6),
('A3', 6),
('B1', 4),
('B2', 4),
('C1', 8),
('D1', 2),
('D2', 2),
('D3', 2);

insert into ponuda (naziv, kategorija, vrijeme) values
('Juha od bakalara',1, 12),
('Krem juha od gljiva', 1, 12),
('Junjeca juha s rezancima', 1, 12),
('Pileci medaljoni u umaku od kikirikija', 2, 42),
('Svinjsko pecenje na slavonski', 2, 43),
('Gulas na madarski', 2, 45),
('Peka od hobotnice', 3, 32),
('Musaka od batata',  3, 53),
('Svinjsko pecenje na slavonski', 4,35),
('Marinirana svinjska rebra', 4, 63),
('Teleci rizoto s pestom od spinata', 4, 32),
('Tocada od liganja ', 5, 12),
('Morski pas na trscanski', 5,42),
('Bakalar na portugalski', 5, 23),
('Fishburger', 5, 23),
('Njoke na maslacu ', 6, 12),
('Peceni krumpir s ruzmarinom ', 6,23),
('Pirjana riza ', 6,53),
('Ricet krem riza s kukuruzom ', 6,32),
('Pire od buce', 6, 12),
('Zelena', 7, 12),
('Meksicka', 7, 14),
('Mjesana', 7, 43),
('Indijska',7, 4),
('Palacinka',8, 5),
('Kuglof',8, 2),
('Rajski kolac',8, 4);

update ponuda set opis='Mrkva, celer, krumpiri, vegeta, sol, karfiol' where kategorija=1;

update ponuda set cijena= 8+round(5*rand()) where kategorija=1;
update ponuda set cijena= 25+round(9*rand()) where kategorija=2;
update ponuda set cijena= 30+round(10*rand()) where kategorija=3;
update ponuda set cijena= 35+round(12*rand()) where kategorija=4;
update ponuda set cijena= 22+round(20*rand()) where kategorija=5;
update ponuda set cijena= 7+round(10*rand()) where kategorija=6;
update ponuda set cijena= 5+round(10*rand()) where kategorija=7;
update ponuda set cijena= 7+round(5*rand()) where kategorija=8;



#Popis popravaka
#pri odjavljivanju napraviti render na prijavu 
#provjerti jos jednom dali mi radi mjenjanje cijena
#pri ponovnom uplodanju slike treba uklonti staru i staviti novu

#Za istražiti
#pogledati favicon
#tiny mcn - za pisanje i uređivanje teska na webu
