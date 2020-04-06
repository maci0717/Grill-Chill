<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('prijava',[
            'poruka'=>'Unesite pristupne podatke',
            'email'=>''
        ]);
    }

    public function autorizacija()
    {
        if(!isset($_POST['email']) || !isset($_POST['lozinka']))
        {
            $this->view->render('prijava',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        if(trim($_POST['email'])==='' || trim($_POST['lozinka'])==='')
        {
            $this->view->render('prijava',[
                'poruka'=>'Pristupni podaci obavezno',
                'email'=>$_POST['email']
            ]);
            return;
        }
 
        //$veza = new PDO('mysql:host=localhost;dbname=edunovapp20;charset=utf8',
        //'edunova','edunova');

        $veza = DB::getInstanca();

        	    //sql INJECTION PROBLEM 
        //$veza->query('select lozinka from operater 
        //              where email=\'' . $_POST['email'] . '\';');
        $izraz = $veza->prepare('select * from korisnik where email=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
        if($rezultat==null)
        {
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka))
        {
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }
        unset($rezultat->lozinka);
        $_SESSION['korisnik']=$rezultat;
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
        Kosara::kosaraID();
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['korisnik']);
        session_destroy();
        $this->index();
    }

    public function index()
    {
        

        $this->view->render('pocetna',[
            'popis'=>[],
            ]
        );


    }
    public function onama()
    {
        $this->view->render('onama');
    }

    public function profil()
    {
        $this->view->render('profil');
    }

    public function kosara()
    {
        $this->view->render('kosara');
    }


    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='PHP programiranje';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }

    public function gostoje()
    {
        $gost=Korisnici::gostojubic(); 
        Kosara::kosaraID();
        $_SESSION['korisnik']=$gost;
        $npc = new PonudaController();
        $npc->index();
    } 

    public function registracija()
    {
        $this->view->render('registracija');
    }

    public function registrirajnovi()
    {
        //prvo dođu sve silne kontrole
        Korisnici::registrirajnovi();
        $this->view->render('registracijagotova');
    }

    //nije osnovno - Anita ovo ne trebaš u prvom laufu učiti
    public function zavrsiregistraciju()
    {
        Korisnici::zavrsiregistraciju($_GET['id']);
        $this->view->render('prijava');
    }

    public function email()
    {
        $headers = "From: Matej Malčić <ereb@polaznik34.edunova.hr>\r\n";
        $headers .= "Reply-To: Matej Malčić <ereb@polaznik34.edunova.hr>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail('ereb@polaznik34.edunova.hr','Test','Test poruka <a href="http://maciserver01.hr/">Edunova APP</a>', $headers);
        echo 'GOTOV';
    } 


    public function test()
    {
     echo password_hash('e',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    } 
}