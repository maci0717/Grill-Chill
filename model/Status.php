<?php 
    
    class Status
    {

        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select * from status');
            $izraz->execute();
            return $izraz->fetchAll();

        }

        public static function create()
        {
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('insert into status (stanje) values (:stanje)');
            $izraz->execute($_POST);
            
        }

            
        public static function delete()
        {
            try{
                $veza = DB::getInstanca();
                $izraz=$veza->prepare('delete from status where sifra=:sifra');
                $izraz->execute($_GET);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
        }


        
        public static function read($sifra)
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select sifra, stanje from status where sifra=:sifra');
            $izraz->execute(['sifra'=>$sifra]);
            return $izraz->fetch();
        }

            
        public static function update()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('update status set stanje=:stanje
            where sifra=:sifra');
            $izraz->execute([ //tu treba popraviti
                'sifra' => $_GET['sifra'],
                'stanje' => $_POST['stanje'],
            ]);
        }
        

        public static function test()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('update narudzba set status=:status
            where sifra=:sifra');
            $izraz->execute([ 
                'sifra' => $_GET['sifraNar'],
                'status' => $_GET['status'],
            ]);
        }


    } 