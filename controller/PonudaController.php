<?php

class PonudaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'ponuda' .
    DIRECTORY_SEPARATOR;
    
  

    public function trazi()
    {
        
        $podaci = Ponuda::trazi($_GET['uvjet']);

        if(count($podaci)===0)
        {
            $podaci = Ponuda::trazi($_GET['uvjet']);
        }

        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet' => $_GET['uvjet'],
            'css' => '<link rel="stylesheet" href="' . APP::config('url') . 'public/css/cropper.css">',
            'jsLib' => '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" 
                        crossorigin="anonymous"></script>
                        <script src="' . APP::config('url') . 'public/js/cropper.js"></script>',
            'javascript' => '<script src="' . APP::config('url') . 'public/js/ponuda/index.js"></script>
                            <script src="' . APP::config('url') . 'public/js/ponuda/slika.js"></script>'
           ]);
    }



    public function index()
    {
        $uvjet='Juha'; 
        $this->renderIndex(Ponuda::trazi($uvjet), $uvjet );
     
    }

    private function renderIndex($podaci, $uvjet)
    {
       
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet'=>$uvjet,
            'css' => '<link rel="stylesheet" href="' . APP::config('url') . 'public/css/cropper.css">',
            'jsLib' => '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" 
                        crossorigin="anonymous"></script>
                        <script src="' . APP::config('url') . 'public/js/cropper.js"></script>',
            'javascript' => '<script src="' . APP::config('url') . 'public/js/ponuda/index.js"></script>
                             <script src="' . APP::config('url') . 'public/js/ponuda/slika.js"></script>'
           ]);
    }




    public function novo()
    {
        $this->view->render($this->viewDir . 'novo',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }

    public function dodajukos()
    {
        $podaci = Ponuda::trazi($_GET['uvjet']);
        $jelo = Ponuda::read($_GET['sifra']);
        $kolicina=$_GET['kolicina'];
        $sifra_ponude=$jelo->sifra;
        $sifra_narudzbe=Ponuda::napraviKos($_GET['sifra']); 
        Ponuda::kos($sifra_narudzbe, $sifra_ponude, $kolicina);
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet' => $_GET['uvjet'],
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/ponuda/index.js"></script>',
           ]);
    } 

    public function dodajnovo()
    {
        Ponuda::create();
        $this->index();
    }

    public function obrisi()
    {
        Ponuda::delete();
        //$this->index();
        header('location: /ponuda/index');
    }

    public function promjena()
    {
        $jelo = Ponuda::read($_GET['sifra']);
        if(!$jelo){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',[
            'jelo'=>$jelo,
            'poruka'=>'Promjenite željene podatke'
            ]);
     
    }

    public function promjeni()
    {
        Ponuda::update();
        header('location: /ponuda/index');
    }

    public function spremiSlikuPonude(){

        $slika = $_POST['slika'];
        $slika=str_replace('data:image/png;base64,','',$slika);
        $slika=str_replace(' ','+',$slika);
        $data=base64_decode($slika);

        file_put_contents(BP . 'public' . DIRECTORY_SEPARATOR
        . 'images' . DIRECTORY_SEPARATOR . 
        'ponuda' . DIRECTORY_SEPARATOR 
        . $_POST['id'] . '.png', $data);

        echo "OK";
    }

}