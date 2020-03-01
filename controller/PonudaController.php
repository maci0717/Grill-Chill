<?php

class PonudaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'ponuda' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Ponuda::readAll()
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
        //prvo dođu sve silne kontrole
        Ponuda::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
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
        // I OVDJE DOĐU SILNE KONTROLE
        Ponuda::update();
        header('location: /ponuda/index');
    }

}