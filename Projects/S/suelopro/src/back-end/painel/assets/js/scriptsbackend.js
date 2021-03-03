var _dominio = window.location.protocol+'//'+window.location.host+'/';

var function_ajax_form = function(seletor,callback){
    var form = document.querySelector(seletor);
    
    form.addEventListener("submit", function(event){
        event.preventDefault();
        
        var form = this; 
        var oData = new FormData(form);
        
        ajax_function(oData, form.action, callback);
    }); 
}

var limpar_form_class = function(){
    $('.has-success.control-label').remove(); 
    $('.has-error.control-label').remove(); 
    $('.has-warning.control-label').remove(); 
}

var ajax_function = function(oData, Action, callback){ 
    var oReq = new XMLHttpRequest();
    oReq.open("POST", Action, true);
    oReq.setRequestHeader('Accept', 'application/json');
    oReq.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    limpar_form_class(); 

    $('input').attr("disabled", true);
    $('textarea').attr("disabled", true); 
    $('select').attr("disabled", true); 
    $('button').prepend('<i class="fa fa-spin fa-refresh"></i>'); 
    $('button').attr("disabled", true); 

    oReq.onload = function(oEvent) { 
        if (oReq.status == 200) { 
            json = oReq.responseText;
            $('.fa.fa-spin.fa-refresh').remove(); 
            $('button').removeAttr("disabled");
            $('input').removeAttr("disabled"); 
            $('textarea').removeAttr("disabled"); 
            $('select').removeAttr("disabled"); 
            if (json != '') { 
                var json = JSON.parse(json);
                callback(json); 

            }
        }
    };
    
    oReq.send(oData);
} 


var form = $('form'); 

if (form.length>0) {
    function_ajax_form('form',callback); 
}

$('#owlServicos a').click(function(event){
    event.preventDefault();
    var key = $(this).data('index');

    $('#owlServicos .item').removeClass('active');
    $('#owlServicos .owl-item').removeClass('active');
    $(this).parent('.item').addClass('active');

    var owl = $('#owlServicosDetalhes');
    owl.owlCarousel(); 
    owl.trigger('to.owl.carousel', [key,300]); 
    
});

var template_fotos_g = `<div class="carousel-item {active}">
    <lazy-image src="{imagem_g}" width="1000" height="1000" alt="{legenda}"></lazy-image>
</div>`;

var template_fotos_p = `<li class="{active}" data-slide-to="0" data-target="#carousel-album">
    <lazy-image src="{imagem_p}" width="100" height="100" alt="{legenda}"></lazy-image>
</li>`;

var galeria_template = `<div class="carousel" id="carousel-album" data-interval="0">
    <div class="wrapper-carousel">
        <div class="carousel-inner">
            {fotos_g}
        </div>
        <a class="prev" href="#carousel-album" data-slide="prev">
            <span class="sr-only">Prev</span>
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="next" href="#carousel-album" data-slide="next">
            <span class="sr-only">Next</span>
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <ol class="carousel-indicators">
        {fotos_p}
    </ol>
</div>`;

var galeria = function(data){

    var fotos_g  = '';
    var fotos_p  = '';
    $('#album .body').html('');
    data.forEach(function(foto,index){
        var imagem_g = template_fotos_g.replace(/{imagem_g}/g, foto.grande);
        imagem_g = imagem_g.replace(/{legenda}/g, foto.legenda);
        if (index==0) {
            imagem_g = imagem_g.replace(/{active}/g, ' active');
        }else{
            imagem_g = imagem_g.replace(/{active}/g, '');
        }

        var imagem_p = template_fotos_p.replace(/{imagem_p}/g, foto.pequena);
        imagem_p = imagem_p.replace(/{legenda}/g, foto.legenda);
        if (index==0) {
            imagem_p = imagem_p.replace(/{active}/g, ' active');
        }else{
            imagem_p = imagem_p.replace(/{active}/g, '');
        } 


        fotos_g = fotos_g + imagem_g;
        fotos_p = fotos_p + imagem_p;
    });
    var galeria = galeria_template.replace(/{fotos_g}/g,fotos_g);
    galeria = galeria.replace(/{fotos_p}/g,fotos_p);

    $('#album .body').html(galeria); 
    Lazyimage.register('#album lazy-image');

    $('#album').toggle('slow');
}



$('a[data-toggle-ajax="album"]').click(function(event){
    event.preventDefault();
    var url = $(this).attr('href');

    var oData = new FormData();
    oData.append('url',url); 
    
    ajax_function(oData, _dominio+'painel/ajax/galeria.php' , galeria);
    
});