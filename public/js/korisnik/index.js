$('#uvjet').autocomplete({
    source: function(request, response){
        $.ajax({
            url: '/polaznik/trazipolaznik',
            data:{
                uvjet: request.term,
                grupa: grupa
            },
            success: function(odgovor){
                response(odgovor);
            }
        });

    },
    minLength: 2,
    select: function(event, ui){
        spremi(ui.item);
    }
}).autocomplete('instance')._renderItem=function(ul, item){
    return $('<li>').append(
        '<div><img src="https://picsum.photos/20/20" /> ' + 
        item.ime + ' ' + item.prezime + 
        ' ' + item.email + '</div>').appendTo(ul);
};

function spremi(polaznik){
    $.ajax({
        type: 'POST',
        url:'/grupa/dodajpolaznik',
        data:{grupa: grupa, polaznik: polaznik.sifra},
        success: function(data){
           if(data==='OK'){
            $('#polaznici').append(
                '<tr>' + 
                '<td>' + polaznik.ime + ' ' + polaznik.prezime + '</td>' + 
                '<td>' + polaznik.oib + '</td>' + 
                '<td><i id="p_' + polaznik.sifra + '"' + 
                'title="Obriši" class="fas fa-trash fa-2x" ' + 
                'style="color: red; cursor: pointer;"></i>' + 
                '</td>' + 
                '</tr>' 
            );
            definirajBrisanje();
           }else{
               alert(data);
           }
        }
    });
}

function definirajBrisanje(){
    $('.fas.fa-trash.fa-2x').click(function(){
        var element=$(this);
        var id=element.attr('id').split('_')[1];
        
        $.ajax({
            type: 'POST',
            url:'/grupa/obrisipolaznik',
            data:{grupa: grupa, polaznik: id},
            success: function(data){
               if(data==='OK'){
                   element.parent().parent().remove();
               }else{
                   alert(data);
               }
            }
        });
    });
}

definirajBrisanje();
