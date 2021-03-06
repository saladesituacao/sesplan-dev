function ValidarIncluir() {
    var retorno = true;
    var txt_perfil = $('#txt_perfil').val();
    var cod_ativo = $('#cod_ativo').val(); 
    var txt_descricao = $('#txt_descricao').val();

    if(retorno && txt_perfil == '') {
        js_alert('', 'Campo PERFIL não pode ser vazio.');
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
                txt_perfil: txt_perfil,
                txt_descricao: txt_descricao               				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_perfil + ' já está cadastrado.');
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
    var txt_perfil = $('#txt_perfil').val();
    var cod_ativo = $('#cod_ativo').val();
    var txt_descricao = $('#txt_descricao').val();    

    if(retorno && txt_perfil == '') {
        js_alert('', 'Campo PERFIL não pode ser vazio.');
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
                txt_perfil: txt_perfil,
                txt_descricao: txt_descricao              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_perfil + ' já está cadastrado.');
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
        content: 'DESEJA EXCLUIR O PERFIL?',
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
                            js_alert('', 'PERFIL NÃO PODE SER EXCLUÍDO. POIS, POSSUI VÍNCULOS.');
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

function Permissao() {
    $('#frm1').attr('action', 'manter.php');  
    $('#acao').val('permissao');      
    return true;        
}

$( document ).ready(function() {
    if($('#status').val() == 'sucesso') {
        js_alert('', 'DADOS ALTERADOS.');
        $('#status').val('');
    }
});