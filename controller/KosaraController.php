<?php 
    
    class KosaraController extends AutorizacijaController
    {
        /*
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kosara' .
        DIRECTORY_SEPARATOR;
    
        public function index()
        {
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Kosara::readAll()
         ]);
        }
        */
 
        public function index()
        {

            $veza = DB::getInstanca();
            $izraz = $veza->prepare('
            select c.sifra, a.naziv, b.kolicina, a.cijena, a.vrijeme, c.stol
            from ponuda a left join narudzba_ponuda b  on a.sifra=b.ponuda_sifra
            left join narudzba c on b.narudzba_sifra=c.sifra
            where b.kolicina>0
            ');
            $izraz->execute();
            $rezultati = $izraz->fetchAll();

            $this->view->render('privatno' . 
            DIRECTORY_SEPARATOR . 'kosara' .
            DIRECTORY_SEPARATOR . 'index', [
            'podaci'=>$rezultati
            ]);
        }

        public function obrisi()
        {
            Kosara::delete();
            //$this->index();
            header('location: /kosara/index');
        }

    }