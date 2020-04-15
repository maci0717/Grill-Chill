<?php 
    
    class StatusController extends AutorizacijaController
    {
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'status' .
        DIRECTORY_SEPARATOR;

       
        public function index()
        {
            
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Status::readAll(),        
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
            Status::create();
            $this->index();
        }

            
        public function obrisi()
        {
            Status::delete();
            //$this->index();
            header('location: /status/index');
        }

        public function promjena()
        {
            $status = Status::read($_GET['sifra']);
            if(!$status){
                $this->index();
                exit;
            }

            $this->view->render($this->viewDir . 'promjena',[
                'status'=>$status,
                'poruka'=>'Promjenite željene podatke'
                ]);
        
        }

        

        public function promjeni()
        {
            
            Status::update();
            header('location: /status/index');
        }

        public function sljedeceStanje()
        {
            Status::test();
            header('location: /narudzba/index');
        }


        
    }

    
