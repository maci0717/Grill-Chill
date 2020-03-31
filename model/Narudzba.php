<?php 
    
    class Narudzba
    {

        
        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select * from kuhinja2');
            $izraz->execute();
            return $izraz->fetchAll();
        }
  


    } 