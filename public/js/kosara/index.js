
$('#modalNaruci').click(function(){


$('#linkStol').attr('href', '/kosara/unosStola');
$('#modalStol').foundation('open');

 
    return false;
}); 

$('#linkStol').click(function(){
    
    var sifraStola=$( "#stol" ).val();
    var link=$(this).attr('href')+'?stol='+sifraStola;

    $('#linkStol').attr('href', link);


});

