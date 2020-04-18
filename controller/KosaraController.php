<?php 
    
    class KosaraController extends AutorizacijaController
    {
        
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kosara' .
        DIRECTORY_SEPARATOR;
    
        public function index()
        {
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Kosara::readAll(),
         ]);
        }
        
        public function naruci()
        {
           
            Kosara::SID(); 
            $this->view->render($this->viewDir . 'index', [
                'poruka' => 'Uspjesno ste narucili! Konobar će vas uskoro posjetiti',
                'podaci'=>''
            ]);
        }

        
        
        public function unosStola()
        { 

            Kosara::stol();

            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Kosara::readAll()
         ]);

        }

        public function obrisi()
        {
            Kosara::delete();
            //$this->index();
            header('location: /kosara/index');
        }

    }



    