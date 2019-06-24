$(document).ready(function() {    
    dashboard_eixo();   
});

function dashboard_eixo() {        
    $.ajax({
        type: 'POST',
        url: '../include/painel.php',
        data: {
            acao: 'tabela_eixo'                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                                            
            var div = '<div class="col-md-12" align="left">';  
           
            obj.forEach(function(i, item) {                   
                div += '<div class="col-md-12" align="left">';
                    div += ' <div class="form-check">';
                        div += '<strong><input type="radio" class="form-check-input" id="btn_eixo_'+ i.cod_eixo +'" name="cod_eixo[]" value="'+ i.cod_eixo +'" onclick="dashboard_perspectiva('+ i.cod_eixo +');" />&nbsp;'+ i.txt_eixo +'</strong>';
                    div += '</div>';
                div += '</div>';                               
            });    
            
            div += '</div>';

            $('#div_eixo').html(div);            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}

function dashboard_perspectiva(valor) {    
    $('#div_diretriz').html('');
    $('#div_objetivo').html('');

    if (valor != '') {
        $.ajax({
            type: 'POST',
            url: '../include/painel.php',
            data: {
                acao: 'tabela_perspectiva',
                cod_eixo: valor            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="col-md-12" align="left">';                         
                obj.forEach(function(i, item) {  
                    div += '<div class="col-md-12" align="left">';
                        div += ' <div class="form-check">';
                            div += '<strong><input type="radio" class="form-check-input" id="btn_perspectiva_'+ i.cod_perspectiva +'" name="cod_perspectiva[]" value="'+ i.cod_perspectiva +'" onclick="dashboard_diretriz('+ valor +', '+ i.cod_perspectiva +');" />&nbsp;'+ i.txt_perspectiva +'</strong>';
                        div += '</div>';
                    div += '</div>';                                         
                });            
                div += '</div>'; 
    
                $('#div_perspectiva').html(div);                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_diretriz(cod_eixo, cod_perspectiva) {     
    $('#div_objetivo').html('');
    
    if (cod_eixo != '' && cod_perspectiva != '') {
        $.ajax({
            type: 'POST',
            url: '../include/painel.php',
            data: {
                acao: 'tabela_diretriz',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="col-md-12" align="left">';          
                obj.forEach(function(i, item){    
                    div += '<div class="col-md-6" align="left">';
                        div += ' <div class="form-check">';
                            div += '<strong><input type="radio" class="form-check-input" id="btn_diretriz_'+ i.cod_diretriz +'" name="cod_diretriz[]" title="'+ i.txt_diretriz +'" value="'+ i.cod_diretriz +'" onclick="dashboard_objetivo('+ cod_eixo +', '+ cod_perspectiva +', '+ i.cod_diretriz +');" />'+ i.txt_titulo +'</strong>';
                        div += '</div>';
                    div += '</div>';                                        
                });            
                div += '</div>'; 
 
                $('#div_diretriz').html(div);                
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_objetivo(cod_eixo, cod_perspectiva, cod_diretriz) {
    if (cod_eixo != '' && cod_perspectiva != '' && cod_diretriz != '') {        
        $.ajax({
            type: 'POST',
            url: '../include/painel.php',
            data: {
                acao: 'tabela_objetivo',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva,
                cod_diretriz: cod_diretriz
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="col-md-12" align="left">';            
                obj.forEach(function(i, item){     
                    div += '<div class="col-md-6" align="left">';
                        div += ' <div class="form-check">';
                            div += '<strong><input type="checkbox" class="form-check-input" id="btn_objetivo_'+ i.cod_objetivo +'" name="cod_objetivo[]" title="'+ i.txt_objetivo +'" value="'+ i.cod_objetivo +'" />'+ i.codigo_objetivo +'</strong>';
                        div += '</div>';
                    div += '</div>';                                        
                });  
                div += '</div>';           
    
                $('#div_objetivo').html(div);                                               
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });         
    }
}
