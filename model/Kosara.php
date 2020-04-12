<?php 
    
    class Kosara
    {
    
        
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

    public static function kreirajKosaru()
    {
        $sessionID = session_id();
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        
        $izraz=$veza->prepare('
            select sifra from kosara where sessionID=:sessionID
        ');
        $izraz->execute(['sessionID'=>$sessionID]);  
       
        
        if(!$izraz->fetch()->sifra)
        {
            $izraz=$veza->prepare('
                insert into kosara (sessionID) values (:sessionID)
            ');
            $izraz->execute(['sessionID'=>$sessionID]);  
        }

        $veza->commit();      
    }

        
    public static function readAll()
    {
        $sessionID=session_id();
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select a.sifra, a.naziv, b.kolicina, a.cijena, a.vrijeme, d.brojStola, c.sifra as sifraKos
        from ponuda a 
        left join kosara_ponuda b  on a.sifra=b.ponuda_sifra
        left join kosara c on b.kosara_sifra=c.sifra
        left join stol d on c.stol=d.sifra
        where sessionID=:sessionID
        ');
        $izraz->execute(['sessionID'=>$sessionID]);
        return $izraz->fetchAll();
    }

    public static function delete()
    {

            $veza = DB::getInstanca();
            $izraz=$veza->prepare('
            delete from kosara_ponuda where ponuda_sifra=:sifra;
            ');
            $izraz->execute($_GET);
      
    }

    public static function stol()
    {
        
        $veza = DB::getInstanca();
        $sessionID=session_id();
        $izraz=$veza->prepare('
        update kosara set stol=:stol where sessonID=:sessionID
        
        ');
        $izraz->execute([
            'stol'=>$_GET['stol'],
            'sessionID'=>$sessionID
            ]);

    }

    

    


    } 