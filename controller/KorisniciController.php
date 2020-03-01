<?php

class KorisniciController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'korisnici' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Korisnici::readAll()
     ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }

    public function dodajnovog()
    {
        //trebaju kontrole
        Korisnici::create();
        $this->index();
    }

    public function obrisi()
    {
        //trebaju kontrole
        Korisnici::delete();
        //$this->index();
        header('location: /korisnici/index');
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

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Korisnici::update();
        header('location: /korisnici/index');
    }
}