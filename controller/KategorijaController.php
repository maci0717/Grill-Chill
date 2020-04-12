<?php 
    
    class KategorijaController extends AutorizacijaController 
    {
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kategorija' .
        DIRECTORY_SEPARATOR;

       
        public function index()
        {
            
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Kategorija::readAll(),        
            ]);
        }

        public function novo()
        {
            $this->view->render($this->viewDir . 'novo',
                ['poruka'=>'Popunite sve tražene podatke']
            );
        }
        
        public function dodajnovo()
        {
            Kategorija::create();
            $this->index();
        }

            
        public function obrisi()
        {
            Kategorija::delete();
            //$this->index();
            header('location: /kategorija/index');
        }
        
    }

    
