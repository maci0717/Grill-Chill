<?php

class Ponuda
{

    public static function trazi($uvjet)
    {
        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, a.naziv, a.slika, 
        a.opis, a.vrijeme, d.nazivKat, a.cijena, b.kolicina
        from ponuda a 
        left join kosara_ponuda b  on a.sifra=b.ponuda_sifra
        left join kosara c on b.kosara_sifra=c.sifra
        left join kategorija d on a.kategorija=d.sifra
        where d.nazivKat like :uvjet
        group by a.sifra, a.naziv, a.opis, 
        a.slika, a.vrijeme, d.nazivKat, a.cijena, b.kolicina 
        
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function napraviKos($sifraJela)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        select cijena, vrijeme from ponuda where sifra=:sifraJela
        ');
        $izraz->execute(['sifraJela'=>$sifraJela]);
        $cijVri= $izraz->fetch();
        $vrijeme =  $cijVri->vrijeme;
        $cijena = $cijVri->cijena;


        $sessionID=session_id();
        $izraz=$veza->prepare('
            update kosara set cijena=:cijena, vrijeme=:vrijeme 
            where sessionID=:sessionID
        ');
        $izraz->execute([
            'sessionID'=>$sessionID,
            'cijena'=>$cijena,
            'vrijeme'=>$vrijeme
            ]);
            
        $izraz=$veza->prepare('
        select sifra from kosara where sessionID=:sessionID
        ');
        $izraz->execute(['sessionID'=>$sessionID]);
        $sifraKosare = $izraz->fetch()->sifra;


        $veza->commit();
        return $sifraKosare; 
    }

    public static function kos($sifra_narudzbe, $sifra_ponude, $kolicina)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        insert into kosara_ponuda (kosara_sifra,ponuda_sifra, kolicina) values 
        (:sifra_narudzbe,:sifra_ponude, :kolicina)
        
        ');
        $izraz->bindParam('sifra_ponude',$sifra_ponude);
        $izraz->bindParam('sifra_narudzbe',$sifra_narudzbe);
        $izraz->bindParam('kolicina',$kolicina);
        $izraz->execute();
        
    }



    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from ponuda');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra, naziv, kategorija, cijena from ponuda where sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into ponuda (naziv, cijena, kategorija) values (:naziv, :cijena, :kategorija)');
        $izraz->execute($_POST);
        /* NAČIN 2
        $izraz->execute([
            'email' => $_POST['email'],
            'lozinka' => $_POST['lozinka'],
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'uloga' => $_POST['uloga'],
        ]);
                */
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from ponuda where sifra=:sifra');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }

    public static function update()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update ponuda set naziv=:naziv, cijena=:cijena, kategorija=:kategorija
        where sifra=:sifra');
        $izraz->execute($_POST);
    }

   

}