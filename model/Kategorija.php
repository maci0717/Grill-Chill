<?php 
    
    class Kategorija
    {

    

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from kategorija');
        $izraz->execute();
        return $izraz->fetchAll();

    }

    } 