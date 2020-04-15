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
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/ponuda/index.js"></script>'
           ]);
    }



    public function index()
    {
        $_GET['uvjet']='Juha';
        $this->renderIndex(Ponuda::trazi($_GET['uvjet']), $_GET['uvjet'] );
     echo 'TU SAM';
    }

    private function renderIndex($podaci, $uvjet)
    {
        echo 'Tu sam';
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet'=>$uvjet,
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/ponuda/index.js"></script>'
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

}