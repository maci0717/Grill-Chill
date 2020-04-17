<?php

class KorisniciController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'korisnici' .
    DIRECTORY_SEPARATOR;


    public function trazikorisnik(){
        header('Content-Type: application/json');
        echo json_encode(Korisnici::traziKorisnike());
    }

 
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Korisnici::readAll(),
            'css' => '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">',
            'jsLib' => '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>',
            'javascript'=>'<script src="' . APP::config('url') .'public/js/korisnik/index.js"></script>'
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

    public function dodajkorisnik(){

        //Korisnici::dodajkorisnik();
        echo 'OK';
    }

    public function popis(){

        $this->view->render($this->viewDir . 'popisKorisnika',[
            'podaci'=>Korisnici::readAll(),
            'css' => '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">',
            'jsLib' => '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>',
            'javascript'=>'<script src="' . APP::config('url') .'public/js/korisnik/index.js"></script>'
     ]);
        
       
    }
    
}