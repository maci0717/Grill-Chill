<?php 
    
    class Narudzba
    {

        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
                select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
                b.stol, e.brojStola, b.cijena, d.stanje, d.sifra as sifraStatus, b.sifra as sifraKos
                from narudzba a
                left join kosara b on a.kosara=b.sifra
                left join stol e on b.stol=e.sifra
                left join korisnik c on a.korisnik=c.sifra
                left join status d on a.status=d.sifra
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        } 

        public static function readKuhar()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
            b.stol, e.brojStola, b.cijena, d.stanje, d.sifra as sifraStatus, b.sifra as sifraKos
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            left join stol e on b.stol=e.sifra
            left join korisnik c on a.korisnik=c.sifra
            left join status d on a.status=d.sifra
            where d.stanje=\'Zaprimljeno\' or d.stanje=\'Spremno\'
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        }

        public static function readKonobar()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
            b.stol, e.brojStola, b.cijena, d.stanje, d.sifra as sifraStatus, b.sifra as sifraKos
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            left join stol e on b.stol=e.sifra
            left join korisnik c on a.korisnik=c.sifra
            left join status d on a.status=d.sifra
            where d.stanje=\'Spremno\' or d.stanje=\'Posluzeno\' or d.stanje=\'Naplaceno\'
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        }

        public static function readPonuda()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.naziv, b.kolicina, b.kosara_sifra
            from ponuda a
            left join kosara_ponuda b on a.sifra=b.ponuda_sifra
            where b.ponuda_sifra=a.sifra

            ');
            $izraz->execute();
            return $izraz->fetchAll();

        }

        public static function readPonuda1($sifraKos)
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.naziv, a.cijena, b.kolicina, b.kosara_sifra, b.ponuda_sifra
            from ponuda a
            left join kosara_ponuda b on a.sifra=b.ponuda_sifra
            where b.kosara_sifra=:sifraKos

            ');
            $izraz->execute(['sifraKos'=>$sifraKos]);
            return $izraz->fetchAll();

        }

        public static function read($sifra)
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
                select a.sifra, a.korisnik as korisnikID, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
                b.stol, b.cijena, d.stanje, b.sifra as sifraKos
                from narudzba a
                left join kosara b on a.kosara=b.sifra
                left join korisnik c on a.korisnik=c.sifra
                left join status d on a.status=d.sifra
                where b.sifra=:sifra
            ');
            $izraz->execute(['sifra'=>$sifra]);
            return $izraz->fetch();
        }

        public static function jeloUKosaru()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
                insert into kosara_ponuda (kosara_sifra, ponuda_sifra, kolicina) 
                values (:kosara_sifra, :ponuda_sifra, 1)
            ');
            $izraz->execute([
                'kosara_sifra'=> $_GET['sifraKos'],
                'ponuda_sifra'=> $_GET['sifraPon']
                ]);
        }
             
        public static function deletePonuda()
        {

                $veza = DB::getInstanca();
                $veza->beginTransaction();
                //dohvacanje cijene ponude
                $izraz=$veza->prepare('
                select cijena from ponuda where sifra=:sifra
                ');
                $izraz->execute(['sifra'=>$_GET['sifra']]);
                $cijenaPonude=$izraz->fetch()->cijena;
                //dohvacanje kolicine ponude
                $izraz=$veza->prepare('
                select kolicina from kosara_ponuda where ponuda_sifra=:sifra
                ');
                $izraz->execute(['sifra'=>$_GET['sifra']]);
                $kolicina=$izraz->fetch()->kolicina;

                echo $cijenaPonude . ' ' . $kolicina;

                //dohvacanje stare cijene u kosari
                $izraz=$veza->prepare('
                select a.cijena 
                from kosara a 
                left join kosara_ponuda b on b.kosara_sifra=a.sifra
                where b.ponuda_sifra=:sifra
                ');
                $izraz->execute(['sifra'=>$_GET['sifra']]);
                $cijenaKosare=$izraz->fetch()->cijena;
                
                echo $cijenaKosare;
                $novaCijena=$cijenaKosare - ($cijenaPonude * $kolicina);

                //brisanje stavke
                $izraz=$veza->prepare('
                delete from kosara_ponuda where ponuda_sifra=:sifra;
                ');
                $izraz->execute(['sifra'=>$_GET['sifra']]);

                //update nove cijene u kosaru
                $izraz = $veza->prepare('
                    update kosara set cijena=:cijena
                    where sifra=:sifra
                ');
                $izraz->execute([
                    'cijena' => $novaCijena,
                    'sifra' => $_GET['sifraKos'],
                ]);

                $veza->commit();
        }

        public static function obrisiNarudzbu()
        {

                $veza = DB::getInstanca();
                $izraz=$veza->prepare('
                delete from narudzba where sifra=:sifra;
                ');
                $izraz->execute(['sifra'=>$_GET['sifraNar']]);
        }

        public static function obrisiSveZavrsene()
        {

                $veza = DB::getInstanca();
                $izraz=$veza->prepare('
                delete from narudzba where status=5;
                ');
                $izraz->execute();
        }

        public static function update()
        {
        
            $sifraNar=$_GET['sifra'];

            $veza = DB::getInstanca();
            $veza->beginTransaction();
            $izraz = $veza->prepare('
            update narudzba set status=:status
            where sifra=:sifra
            ');
            $izraz->execute([
                'sifra' => $sifraNar,
                'status' => $_POST['stanje'],
                ]);

                

            $izraz = $veza->prepare('
            select kosara from narudzba where sifra=:sifra;
            ');
            $izraz->execute([
                'sifra' => $_GET['sifra'],
                ]);
            $sifraKos=$izraz->fetch()->kosara;
               
            $izraz = $veza->prepare('
            update kosara set stol=:stol, cijena=:cijena where sifra=:sifraKos
            ');
            $izraz->execute([
                'sifraKos'=>$sifraKos,
                'stol'=>$_POST['stol'],
                'cijena'=>$_POST['cijena'],
            ]);   

           $veza->commit();
        }

        //MJENJANJE CIJENE U KOSARI PRI PROMJENI KOLICINE NEKE PONUDE-POMOC ....mozda join promjenit
        public static function promjeniKolicinu()
        {
            $veza = DB::getInstanca();
            $veza->beginTransaction();

            //dohvacanje cijene ponude
            $izraz=$veza->prepare('
            select cijena from ponuda where sifra=:sifra
            ');
            $izraz->execute(['sifra'=>$_GET['sifraPon']]);
            $cijenaPonude=$izraz->fetch()->cijena;

            //dohvacanje kolicine ponude
            $izraz=$veza->prepare('
            select kolicina from kosara_ponuda 
            where ponuda_sifra=:sifraPon and kosara_sifra=:sifraKos
            ');
            $izraz->execute([
                'sifraPon'=>$_GET['sifraPon'],
                'sifraKos'=>$_GET['sifraKos']
            ]);
            $staraKolicina=$izraz->fetch()->kolicina;

            

            //stavljanje u bazu novu kolicinu
            $izraz=$veza->prepare('
            update kosara_ponuda set kolicina=:kolicina
            where ponuda_sifra=:ponuda_sifra and kosara_sifra=:kosara_sifra
            ');
            $izraz->execute([
                'ponuda_sifra'=>$_GET['sifraPon'],
                'kosara_sifra'=>$_GET['sifraKos'],
                'kolicina'=>$_GET['kolicina'],
            ]);


            //dohvacanje stare cijene u kosari
            $izraz=$veza->prepare('
            select cijena from kosara where sifra=:sifraKos
            ');
            $izraz->execute(['sifraKos'=>$_GET['sifraKos']]);
            $cijenaKosare=$izraz->fetch()->cijena;

            //nova željena količina
            $novaKolicina=$_GET['kolicina'];

            //algoraitam za izračun nove cijene
            $novaCijena=$cijenaKosare - ($cijenaPonude * $staraKolicina) + ($cijenaPonude * $novaKolicina);



            //konačno postavljanje nove cijene u kosaru
            $izraz=$veza->prepare('
            update kosara set cijena=:cijena
            where sifra=:sifra
            ');
            $izraz->execute([
                'cijena'=>$novaCijena,
                'sifra'=>$_GET['sifraKos'],
            ]);

            $veza->commit();
        }

    } 