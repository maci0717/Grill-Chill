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
sessionsifra       varchar(100)
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
('David', 'stetic', 'gost', 'davsifra.stetic@edunova.hr', '$2y$10$U5ykDrG02jI187wbGXuIGucm8ta1kPWVhCgMdLqSzI7y54eaL/kCW', 1);


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
  slika 		text DEFAULT NULL,
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


update ponuda set slika='data:image/jpeg;base64,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' where kategorija=1;

update ponuda set opis='Mrkva, celer, krumpiri, vegeta, sol, karfiol' where kategorija=1;

update ponuda set cijena= 8+round(5*rand()) where kategorija=1;
update ponuda set cijena= 25+round(9*rand()) where kategorija=2;
update ponuda set cijena= 30+round(10*rand()) where kategorija=3;
update ponuda set cijena= 35+round(12*rand()) where kategorija=4;
update ponuda set cijena= 22+round(20*rand()) where kategorija=5;
update ponuda set cijena= 7+round(10*rand()) where kategorija=6;
update ponuda set cijena= 5+round(10*rand()) where kategorija=7;
update ponuda set cijena= 7+round(5*rand()) where kategorija=8;



select * from narudzba;
select * from stol;
select * from kosara;
select * from korisnik;
select * from kosara_ponuda;
select cijena from ponuda;

delete from narudzba where sifra=1;
#Zadataci
#1
#NAPRAVITI AJAX za pretragu korisnika
#staviti na web


#2 
#mogucnost dodavanje pondue u kosaru iz narudzbe

#3
#Urediti profil
#napraviti sistem za GRILL bodove
#u ponuda->promjena.phtml za sliku treba promjeniti type i u novo.phtml takodjer

#4
#pri prijavi popraviti kosaru da stol bude default prikazan
################################################################
#OVO NE RADI UOPCE VISE
# u ponudi promjeniti listanje stranica, neka uvjet dolazi iz baze 
################################################################
#Ako se u praznoj kosari stisne naruci, napravi se prazna narudba  
#pregledati cijeli kod i obrisati nepotrebne komentare
#POGLEDATI OD PERIŠINA OGLAS ZA INCHOO

#Pitanja za prof
#UTF-8 napravti
#Ideju za sta da napravim da kuhari vide svoje, konobari svoje a admin sve
#kad napunim kosaru sa vise ponuda, kako produžiti grid
#kako napraviti da pri mjenjanju statusa narudzbe ostane na istoj poziciji, da se ne scrolla na pocetak stranice gore



#DOKUMENTACIJA
#pripazio bi na nazivanje varijabli da se drugi lakse snalaze
#nebi imao puno slicnih funckija kao sto sada imam, vec bi napravio manje alternativnih fja
#bolji nacin za izracunavanje cijene kosare
#za css nebi svuda stavljao style background color orange