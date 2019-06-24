$( "#btn_incluir" ).click(function() {
    var erro = '';
    erro = Validar();

    if (erro == '') {                                            
        $('#frm1').submit();

    } else {
        js_alert('', erro);
    }
});

$( "#btn_salvar" ).click(function() {
    var erro = '';
    erro = Validar();

    if (erro == '') {
        $('#frm1').submit();
    } else {
        js_alert('', erro);
    }
});


function Validar() {
    var retorno  = '';
    var cod_acao = $('#cod_acao').val();
    var cod_secretaria = $('#cod_secretaria').val();
    var cod_programa_governo = $('#cod_programa_governo').val();
    var txt_projeto = $('#txt_projeto').val();  
    var cod_objetivo = $('#cod_objetivo').val();  
    var cod_estrategia = $('#cod_estrategia').val();
    
    /*if(retorno == '' && cod_objetivo == '') {        
        retorno = 'Campo OBJETIVO não pode ser vazio.';
    }*/
    if(retorno == '' && cod_acao == '') {        
        retorno = 'Campo N.º DA AÇÃO não pode ser vazio.';
    }
    if(retorno == '' && cod_secretaria == '') {        
        retorno = 'Campo SECRETARIA não pode ser vazio.';
    }
    if(retorno == '' && cod_programa_governo == '') {        
        retorno = 'Campo PROGRAMA não pode ser vazio.';
    }
    if(retorno == '' && txt_projeto == '') {        
        retorno = 'Campo PROJETO / AÇÃO não pode ser vazio.';
    }  
    /*  
    if(retorno == '' && (cod_estrategia == '' || cod_estrategia == null)) {        
        retorno = 'Campo ESTRATÉGIA VINCULADA não pode ser vazio.';
    } 
    */

    return retorno;
}



function Desabilitar(id)
{

    $.confirm({
        title: '',
        content: 'DESEJA DESABILITAR O PLANO DE AÇÃO?',
        buttons: {
            SIM: function () {
                
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'desabilitar',
                        cod_plano_acao: id              				
                    },
                    async: false,
                    success: function (data) {
            
                        if($.parseJSON(data)["status"] == 'sucesso')
                        {                                       
                            js_go('default.php');
                            return true;
                        }
                        else if($.parseJSON(data)["status"] == 'falha') {
            
                            js_alert('', $.parseJSON(data)["mensagem"]);               
                            return false;
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

function Habilitar(id)
{

    $.confirm({
        title: '',
        content: 'DESEJA HABILITAR O PLANO DE AÇÃO?',
        buttons: {
            SIM: function () {
                
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'habilitar',
                        cod_plano_acao: id              				
                    },
                    async: false,
                    success: function (data) {
            
                        if($.parseJSON(data)["status"] == 'sucesso')
                        {                                       
                            js_go('default.php');
                            return true;
                        }
                        else if($.parseJSON(data)["status"] == 'falha') {
            
                            js_alert('', $.parseJSON(data)["mensagem"]);               
                            return false;
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

