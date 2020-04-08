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
} 