$('a.otvoriModalUbaci').click(function(){

    var sifraKos=$(this).attr('id').split('_')[1];
    console.log(sifraKos);
  
    $('#linkPotvrdi').attr('href', '/narudzba/ubaciJeloUNarudzbu?sifraKos='+sifraKos); 
    $('#modalUbaci').foundation('open');
    
    
        return false;
    }); 
    
    $('#linkPotvrdi').click(function(){
        
        var sifraPon=$( "#popisPonude" ).val();
        var link=$(this).attr('href') + '&sifraPon='+sifraPon;
    
        $('#linkPotvrdi').attr('href', link);
    
    
    }); 
    
    