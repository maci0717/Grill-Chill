<?php 
    
    class Narudzba
    {

        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
            b.stol, b.cijena, a.status, b.sifra as sifraKos
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            left join korisnik c on a.korisnik=c.sifra
           
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        }

        public static function readKuhar()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
            b.stol, b.cijena, a.status, b.sifra as sifraKos
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            left join korisnik c on a.korisnik=c.sifra
            where a.status=\'Zaprimljeno\' or a.status=\'Spremno\'
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        }

        public static function readKonobar()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, concat(c.ime, \' \' ,c.prezime) as korisnik, 
            b.stol, b.cijena, a.status, b.sifra as sifraKos
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            left join korisnik c on a.korisnik=c.sifra
            where a.status=\'Spremno\' or a.status=\'Posluzeno\'
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

        public static function zapUSprem()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            update narudzba set status=\'Spremno\'
            where sifra=:sifra

            ');
            $izraz->execute(['sifra' => $_GET['sifra']]);
        }
  


    } 