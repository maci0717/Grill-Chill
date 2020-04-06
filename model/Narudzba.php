<?php 
    
    class Narudzba
    {

        
        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select a.sifra, a.vrijemeNarudzbe, a.korisnik, b.stol, b.cijena, a.status
            from narudzba a
            left join kosara b on a.kosara=b.sifra
            ');
            $izraz->execute();
            return $izraz->fetchAll();
        }
  


    } 