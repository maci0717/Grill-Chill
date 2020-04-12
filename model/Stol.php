<?php 
    
    class Stol
    {

        public static function readAll()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select * from stol');
            $izraz->execute();
            return $izraz->fetchAll();

        }

        public static function create()
        {
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('insert into stol (brojStola, brojStolica) values (:brojStola, :brojStolica)');
            $izraz->execute($_POST);
            
        }

            
        public static function delete()
        {
            try{
                $veza = DB::getInstanca();
                $izraz=$veza->prepare('delete from stol where sifra=:sifra');
                $izraz->execute($_GET);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
        }


        
        public static function read($sifra)
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select sifra, brojStola, brojStolica from stol where sifra=:sifra');
            $izraz->execute(['sifra'=>$sifra]);
            return $izraz->fetch();
        }

            
        public static function update()
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('update stol set brojStola=:brojStola, brojStolica=:brojStolica
            where sifra=:sifra');
            $izraz->execute([
                'sifra' => $_GET['sifra'],
                'brojStola' => $_POST['brojStola'],
                'brojStolica' => $_POST['brojStolica'],
            ]);
        }
        


    } 