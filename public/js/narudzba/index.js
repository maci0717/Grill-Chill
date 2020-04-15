$('a.otvoriModalKolicina').click(function(){

    var sifraKos=$(this).attr('id').split('_')[0];
    var sifraPon=$(this).attr('id').split('_')[1];
    
    console.log(sifraKos);
    console.log(sifraPon);

    $('#linkKolicina').attr('href', '/narudzba/promjeniKolicinu?sifraKos='+sifraKos+'&sifraPon='+sifraPon);
    $('#modalKolicina').foundation('open');
    
    
        return false;
    }); 
    
    $('#linkKolicina').click(function(){
        
        var brojKolicina=$( "#kol" ).val();
        var link=$(this).attr('href')+'&kolicina='+brojKolicina;
    
        $('#linkKolicina').attr('href', link);
    
    
    });
    
    