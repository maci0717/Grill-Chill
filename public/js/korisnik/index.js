$('#uvjet').autocomplete({
    source: function(request, response){
        $.ajax({
            url: '/korisnici/trazikorisnik',
            data:{
                uvjet: request.term,
            },
            success: function(odgovor){
                response(odgovor);
            }
        }); 

    },
    minLength: 2,
    select: function(event, ui){
        prikazi(ui.item);
    }
}).autocomplete('instance')._renderItem=function(ul, item){
    return $('<li>').append(
        '<div>' + 
        item.ime + ' ' + item.prezime + 
        ' ' + item.email + '</div>').appendTo(ul);
};
 
function prikazi(korisnik){
    $.ajax({
        type: 'POST',
        url:'/korisnici/dodajkorisnik',
        data:{korisnikSifra: korisnik.sifra},
        success: function(data){
           if(data==='OK'){
            $('#AjaxTest').append(


               '<?php if(file_exists(BP' + 'public' + 'DIRECTORY_SEPARATOR'+
                'images' + 'DIRECTORY_SEPARATOR'+ 
                'korisnici' + 'DIRECTORY_SEPARATOR'+
                 korisnik.sifra + '.png)): ?>'+

        '<img class="slika"  id="p_' + korisnik.sifra + '" style="max-width: 200px"' + 
        'src="http://maciserver01.hr/public/images/korisnici/' + korisnik.sifra + '.png" ' +
        'alt="' + korisnik.ime + ' ' + korisnik.prezime +'" /> <?php else:?>' + 

        '<img class="slika"  id="p_' + korisnik.sifra + '" style="max-width: 200px"' + 
        'src="http://maciserver01.hr/public/images/nepoznato.jpg"' +
        'alt="Za polaznika nije postavljena slika" /> <?php endif;?> ' +
          

        '<h2>' + korisnik.ime +
        '<br /> ' + korisnik.prezime + '</h2>' +
       'Grill bodovi: 0<br />' +
        korisnik.email +'<br />'+
        '<a href="/profil/promjena?sifra='+ korisnik.sifra + '">'+
       ' <i title="Promjeni" class="fas fa-edit fa-2x"></i></a><br />' 

            );
           }else{
               alert(data);
           }
        }
    });
}

