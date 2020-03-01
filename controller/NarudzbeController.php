<?php


class NarudzbeController extends AutorizacijaController
{
    public function index()
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from narudzba');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
        DIRECTORY_SEPARATOR . 'narudzbe' .
        DIRECTORY_SEPARATOR . 'index', [
            'podaci'=>$rezultati
            ]);
    }
}