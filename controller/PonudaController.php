<?php

class PonudaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'ponuda' .
    DIRECTORY_SEPARATOR;
    
    //Ovo vjv ne treba...
    public function kategorije()
    {
       
      
        $this->view->render($this->viewDir . 'index',[
            'popis'=>[],
           ]);
    }


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
           ]);
    }

    
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Ponuda::readAll(),
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
        $sifra_narudzbe=Ponuda::createNar();
        Ponuda::kos($sifra_narudzbe, $sifra_ponude, $kolicina);
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet' => $_GET['uvjet'],
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