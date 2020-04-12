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

        public static function create()
        {
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('insert into kategorija (nazivKat) values (:nazivKat)');
            $izraz->execute($_POST);
            
        }

            
        public static function delete()
        {
            try{
                $veza = DB::getInstanca();
                $izraz=$veza->prepare('delete from kategorija where sifra=:sifra');
                $izraz->execute($_GET);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
        }



    } 