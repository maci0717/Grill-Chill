<?php

class AutorizacijaController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['korisnik']))
        {
            $this->view->render('prijava',[
                'poruka'=>'Morate se prijaviti',
                'email'=>''
            ]);
            exit;
        } elseif ($_SESSION['korisnik']->aktivan==='0')
        {
            $this->view->render('prijava',[
                'poruka'=>'Morate verificirati račun!',
                'email'=>''
            ]);
            exit;
        }
      
    }
 
}