<?php


class NarudzbaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'narudzba' .
    DIRECTORY_SEPARATOR;
    
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Narudzba::readAll(), 
     ]);
    }
} 