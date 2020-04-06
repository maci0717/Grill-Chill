<?php 
    
    class Kosara
    {
    
        public static function naruceno1()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, b.sifra
        
        ');
        $izraz->execute();
        return $izraz->fetch();
    }

    public static function SID()
    {
        $korisnikID=$_SESSION['korisnik']->sifra;
        
        $vrijeme=$_GET['vrijeme'];
        $cijena=$_GET['cijena'];
        $sifraKos=$_GET['sifraKos'];
           

        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        update kosara set vrijeme=:vrijeme, cijena=:cijena where sifra=:sifraKos
        ');
        $izraz->execute([
            'vrijeme'=> $vrijeme,
            'cijena'=> $cijena,
            'sifraKos' => $sifraKos
            ]);

        //$izraz->bindParam('vrijeme',$vrijeme);
        //$izraz->bindParam('cijena',$cijena);
        //$izraz->bindParam('sifraKos',$sifraKos);
       

        $izraz = $veza->prepare('
        insert into narudzba (korisnik, kosara) values (:korisnikID, :sifraKos)
        ');
        $izraz->execute([
            'korisnikID'=> $korisnikID,
            'sifraKos' => $sifraKos
            ]);

        $veza->commit();
    }

    public static function kosaraID()
    {
        $veza = DB::getInstanca();
        $sessionID= session_id();
        $izraz=$veza->prepare('
            insert into kosara (sessionID) values (:sessionID)
        ');
        $izraz->execute(['sessionID'=>$sessionID]);        
    }

        
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select c.sifra, a.naziv, b.kolicina, a.cijena, a.vrijeme, c.stol
        from ponuda a 
        left join kosara_ponuda b  on a.sifra=b.ponuda_sifra
        left join kosara c on b.kosara_sifra=c.sifra
        where b.kolicina>0
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function delete()
    {
        
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('
            delete from kosara_ponuda where kosara_sifra=:sifra;
            delete from kosara where sifra=:sifra;
            ');
            $izraz->execute($_GET);
      
    }


    } 