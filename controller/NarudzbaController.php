<?php


class NarudzbaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'narudzba' .
    DIRECTORY_SEPARATOR;
    
    public function index()
    {
     
        
        $this->view->render($this->viewDir . 'index',[
            'podaciAdmin'=>Narudzba::readAll(),
            'podaciKuhar'=>Narudzba::readKuhar(),
            'podaciKonobar'=>Narudzba::readKonobar(),
            'ponuda'=>Narudzba::readPonuda(), 
     ]);
    }

    public function spremno()
    {
        Narudzba::zapUSprem();

        $this->view->render($this->viewDir . 'index',[
            'podaciAdmin'=>Narudzba::readAll(),
            'podaciKuhar'=>Narudzba::readKuhar(),
            'podaciKonobar'=>Narudzba::readKonobar(),
            'ponuda'=>Narudzba::readPonuda(), 
     ]);
        
    }

    public function promjena()
    {
        $narudzba = Narudzba::read($_GET['sifraKos']);
        $ponuda = Narudzba::readPonuda1($_GET['sifraKos']);
        if(!$narudzba){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',[
            'narudzba'=>$narudzba,
            'ponuda'=>$ponuda,
            'poruka'=>'Promjenite željene podatke'
            ]);
     
    }

    public function promjeni()
    {
        Narudzba::update();
        header('location: /narudzba/index');
    }

    public function obrisiPonudu()
    {
            Narudzba::deletePonuda();
            header('location: /narudzba/promjena?sifraKos='. $_GET['sifraKos']);
    }

    public function promjeniKolicinu()
    {
            Narudzba::promjeniKolicinu();
            header('location: /narudzba/promjena?sifraKos='.$_GET['sifraKos']);
    }

    public function promPon()
    {
        
        $narudzba = Narudzba::read($_GET['sifraKos']);
        $ponuda = Narudzba::readPonuda1($_GET['sifraKos']);
        $this->view->render($this->viewDir . 'prompon',[
            'narudzba'=>$narudzba,
            'ponuda'=>$ponuda,
            'poruka'=>'Promjenite željene podatke'
            ]);
    }

    public function obrisi()
    {
            Narudzba::obrisiNarudzbu();
            header('location: /narudzba/index');
    }

    public function obrisiZavrsene()
    {
            Narudzba::obrisiSveZavrsene();
            header('location: /index'); //ako ne radi dodati jos /index
    }


} 