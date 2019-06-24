function ValidarIncluir() {
    var retorno = true;
    var txt_titulo = $('#txt_titulo').val();
    var cod_ativo = $('#cod_ativo').val(); 
    var txt_mensagem = $('#txt_mensagem').val();
    var cod_tipo_mensagem = $('#cod_tipo_mensagem').val();
    var cod_dia = $('#cod_dia').val();

    if(retorno && txt_titulo == '') {
        js_alert('', 'Campo TÍTULO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_mensagem == '') {
        js_alert('', 'Campo MENSAGEM não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }    

    if(retorno) 
    {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_incluir',
                txt_titulo: txt_titulo,
                txt_mensagem: txt_mensagem,
                cod_tipo_mensagem: cod_tipo_mensagem,
                cod_dia: cod_dia               				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_titulo + ' já está cadastrado.');
                    retorno = false;                    
                }                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }

    if(!retorno) {
        return retorno;
    }    
    else {        
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('incluir');      
        return retorno;   
    }    
}

function ValidarAlterar() {
    var retorno = true;
    var id = $('#id').val();
    var txt_titulo = $('#txt_titulo').val();
    var cod_ativo = $('#cod_ativo').val();
    var txt_mensagem = $('#txt_mensagem').val(); 
    var cod_tipo_mensagem = $('#cod_tipo_mensagem').val();     
    var cod_dia = $('#cod_dia').val();

    if(retorno && txt_titulo == '') {
        js_alert('', 'Campo TÍTULO não pode ser vazio.');
        retorno = false;
    }
    if(retorno && txt_mensagem == '') {
        js_alert('', 'Campo MENSAGEM não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_ativo == '') {
        js_alert('', 'Campo ATIVO não pode ser vazio.');
        retorno = false;
    }
    
    if(retorno) 
    {
        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'validacao_alterar',
                id: id,
                txt_titulo: txt_titulo,
                txt_mensagem: txt_mensagem,
                cod_tipo_mensagem: cod_tipo_mensagem,
                cod_dia: cod_dia              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_titulo + ' já está cadastrado.');
                    retorno = false;                    
                }                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }
    if(!retorno) {
        return retorno;
    }    
    else {     
        $('#frm1').attr('action', 'manter.php');  
        $('#acao').val('alterar');      
        return retorno;        
    }    
}

function Excluir(id) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR A MENSAGEM?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir',
                        id: id              				
                    },
                    async: false,
                    success: function (data) {
                        if(data == '') {
                            js_go('default.php');
                        }                        
                        else {
                            js_alert('', 'MENSAGEM NÃO PODE SER EXCLUÍDA. POIS, POSSUI VÍNCULOS.');
                        }                                                             
                    },				
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);    				
                    }
                });
            },
            NÃO: function () {
                
            }
        }
    });
}

$( document ).ready(function() {
    if($('#status').val() == 'sucesso') {
        js_alert('', 'DADOS ALTERADOS.');
        $('#status').val('');
    }
});