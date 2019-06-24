function ValidarIncluir() {
    var retorno = true;
    var txt_programa_governo = $('#txt_programa_governo').val();
    var cod_ativo = $('#cod_ativo').val(); 
    var txt_descricao = $('#txt_descricao').val();
    var cod_orgao = $('#cod_orgao').val();

    if(cod_orgao == null) {
        cod_orgao = '';
    }

    if(retorno && txt_programa_governo == '') {
        js_alert('', 'Campo PROGRAMA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo ÁREA RESPONSÁVEL não pode ser vazio.');
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
                txt_programa_governo: txt_programa_governo,
                txt_descricao: txt_descricao,
                cod_orgao: cod_orgao               				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_programa_governo + ' já está cadastrado.');
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
    var txt_programa_governo = $('#txt_programa_governo').val();
    var cod_ativo = $('#cod_ativo').val();
    var txt_descricao = $('#txt_descricao').val();    
    var cod_orgao = $('#cod_orgao').val();

    if(cod_orgao == null) {
        cod_orgao = '';
    }

    if(retorno && txt_programa_governo == '') {
        js_alert('', 'Campo PROGRAMA não pode ser vazio.');
        retorno = false;
    }
    if(retorno && cod_orgao == '') {
        js_alert('', 'Campo ÁREA RESPONSÁVEL não pode ser vazio.');
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
                txt_programa_governo: txt_programa_governo,
                txt_descricao: txt_descricao,
                cod_orgao: cod_orgao              				
            },
            async: false,
            success: function (data) {                              
                if (data == 'falha') {
                    js_alert('', txt_programa_governo + ' já está cadastrado.');
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
        content: 'DESEJA EXCLUIR O PROGRAMA?',
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
                            js_alert('', 'PROGRAMA NÃO PODE SER EXCLUÍDO. POIS, POSSUI VÍNCULOS.');
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