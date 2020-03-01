<?php

class Ponuda
{
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