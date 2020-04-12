<?php 
    
    class StolController extends AutorizacijaController
    {
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'stol' .
        DIRECTORY_SEPARATOR;

       
        public function index()
        {
            
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Stol::readAll(),        
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
            Stol::create();
            $this->index();
        }

            
        public function obrisi()
        {
            Stol::delete();
            //$this->index();
            header('location: /stol/index');
        }

        public function promjena()
        {
            $stol = Stol::read($_GET['sifra']);
            if(!$stol){
                $this->index();
                exit;
            }

            $this->view->render($this->viewDir . 'promjena',[
                'stol'=>$stol,
                'poruka'=>'Promjenite željene podatke'
                ]);
        
        }

        

        public function promjeni()
        {
         
            Stol::update();
            header('location: /stol/index');
        }


        
    }

    
