<?php

class Korisnici
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra, 
        ime, prezime, status, email, aktivan, bodovi from korisnik where sifra>1');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra, 
        ime, prezime, status, email, bodovi from korisnik
        where sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function gostojubic()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra, ime, prezime,  email, status, aktivan from korisnik where ime="gostoje"');
        $izraz->execute(['ime'=> 'gostoje']);
        return $izraz->fetch();
    }

    

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into korisnik (ime, prezime, email, lozinka, status) values 
        (:ime, :prezime, :email, :lozinka, :status)');
        unset($_POST['lozinkaponovo']);
        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
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

    public static function registrirajnovi()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into korisnik 
        (email,lozinka,ime,prezime,status,aktivan,sessionid) values 
        (:email,:lozinka,:ime,:prezime,:status,false,:sessionid)');
        unset($_POST['lozinkaponovo']);

        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $_POST['sessionid'] = session_id();
        $_POST['status'] = 'gost';
        //print_r($_POST);

        $izraz->execute($_POST);
        $headers = "From: Edunova APP <ereb@polaznik34.edunova.hr>\r\n";
        $headers .= "Reply-To: Edunova APP <ereb@polaznik34.edunova.hr>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($_POST['email'],'Završi registraciju za Grill & Chill','<a href="' . App::config('url') . 
                'index/zavrsiregistraciju?id=' . $_POST['sessionid'] . '">Završi</a>', $headers);
               
    }

    public static function zavrsiregistraciju($id){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update korisnik 
        set aktivan=true where sessionid=:sessionid');
        $izraz->execute(['sessionid'=>$id]);
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from korisnik where sifra=:sifra');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }
    public static function update()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update korisnik set email=:email,ime=:ime,
        prezime=:prezime,status=:status, aktivan=:aktivan where sifra=:sifra');
        $izraz->execute($_POST);
    }

    public static function updateProfil()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update korisnik set email=:email,ime=:ime,
        prezime=:prezime where sifra=:sifra');
        $izraz->execute($_POST);
    }


    


}