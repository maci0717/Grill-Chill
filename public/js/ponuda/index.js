
$('i.fa-drumstick-bite').click(function(){

    var sifra=$(this).attr('id').split('_')[0];
    var kategorija=$(this).attr('id').split('_')[1];


$('#pitanje').html('Sigurno želite staviti u košaru?');
$('#linkDodavanje').attr('href', '/ponuda/dodajUKos?sifra='+sifra+'&uvjet='+kategorija);
$('#modalDodaj').foundation('open');


    return false;
}); 

$('#linkDodavanje').click(function(){
    
    var kolicina=$( "#kolicina" ).val();
    var link=$(this).attr('href')+'&kolicina='+kolicina;

    $('#linkDodavanje').attr('href', link);


});

