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
           
            Kosara::SID(); 
            $this->view->render($this->viewDir . 'index', [
                'poruka' => 'Uspjesno ste narucili',
                'podaci'=>''
            ]);
        }

        
 
        //radit ce vjv kad dodem do ovdje //ne treba
        public function dodajStol()
        {

            echo 'tu sam';
            //Kosara::stol();

            //$this->view->render($this->viewDir . 'index',[
            //    'podaci'=>Kosara::readAll()
         //]);

        }

        public function obrisi()
        {
            Kosara::delete();
            //$this->index();
            header('location: /kosara/index');
        }

    }



    