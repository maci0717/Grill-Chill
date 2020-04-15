<?php 
    
    class ProfilController extends AutorizacijaController 
    {
        private $viewDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'profil' .
        DIRECTORY_SEPARATOR;

       
        public function index()
        {
    
            $this->renderIndex(Korisnici::read($_SESSION['korisnik']->sifra));
         
        }

        private function renderIndex($podaci){
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>$podaci,
                'css' => '<link rel="stylesheet" href="' . APP::config('url') . 
                'public/css/cropper.css">',
                'jsLib' => '
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="' . APP::config('url') . 
                    'public/js/cropper.js"></script>',
                'javascript'=>'
                <script src="' . APP::config('url') . 
                    'public/js/profil/index.js"></script>'
               ]);
        }



        public function promjena()
        {
            $korisnik = Korisnici::read($_GET['sifra']);
            if(!$korisnik)
            {
                $this->index();
                exit;
            }

            $this->view->render($this->viewDir . 'promjena',[
                'korisnik'=>$korisnik,
                'poruka'=>'Promjenite željene podatke'
                ]);
        
        }
        
        public function promjeniProfil()
        {
            // I OVDJE DOĐU SILNE KONTROLE
            Korisnici::updateProfil();
            header('location: /profil/index');
        }

        public function spremisliku(){

            $slika = $_POST['slika'];
            $slika=str_replace('data:image/png;base64,','',$slika);
            $slika=str_replace(' ','+',$slika);
            $data=base64_decode($slika);
    
            file_put_contents(BP . 'public' . DIRECTORY_SEPARATOR
            . 'images' . DIRECTORY_SEPARATOR . 
            'korisnici' . DIRECTORY_SEPARATOR 
            . $_POST['id'] . '.png', $data);
    
            echo "OK";
        }
    }