<?php 
    
    class Kosara
    {

        
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select c.sifra, a.naziv, b.kolicina, a.cijena, a.vrijeme, c.stol
        from ponuda a left join narudzba_ponuda b  on a.sifra=b.ponuda_sifra
        left join narudzba c on b.narudzba_sifra=c.sifra
        where b.kolicina>0
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function delete()
    {
        
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('
            delete from narudzba_ponuda where narudzba_sifra=:sifra;
            delete from narudzba where sifra=:sifra;
            ');
            $izraz->execute($_GET);
      
    }


    } 