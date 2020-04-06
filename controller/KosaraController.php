<?php 
    
    class KosaraController extends AutorizacijaController
    {
        
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kosara' .
        DIRECTORY_SEPARATOR;
    
        public function index()
        {
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Kosara::readAll()
         ]);
        }
        
        public function naruci()
        {
            //$vrijeme=$_GET['vrijeme'];
            //$cijena=$_GET['cijena'];
            //$sifraKos=$_GET['sifraKos'];
           
            //$vrijeme, $cijena, $sifraKos
            Kosara::SID(); 
            $this->view->render($this->viewDir . 'index', [
                'poruka' => 'Uspjesno ste narucili',
                'podaci'=>''
            ]);
        }
 

        public function obrisi()
        {
            Kosara::delete();
            //$this->index();
            header('location: /kosara/index');
        }

    }



    