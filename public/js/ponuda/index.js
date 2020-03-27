$('i.fa-drumstick-bite').click(function(){

    var sifra=$(this).attr('id').split('_')[0];
    var kategorija=$(this).attr('id').split('_')[1];

    var kolicina=3; // tester
    kolicina = $('#test12').val();
   
 
    console.log(sifra);
    console.log(kolicina);


$('#pitanje').html('Sigurno želite staviti u košaru?');
$('#linkDodavanje').attr('href', '/ponuda/dodajUKos?sifra='+sifra+'&uvjet='+kategorija+'&kolicina='+kolicina);



    return false;
}); 

