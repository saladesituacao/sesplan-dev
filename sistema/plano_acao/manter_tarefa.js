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
    
    var nr_tarefa = $('#nr_tarefa').val();
    var txt_tarefa = $('#txt_tarefa').val();
    
    
    var nr_valor = $('#nr_valor').val();
    var cod_fonte_recurso = $('#cod_fonte_recurso').val();
    var cod_fonte_recurso_orcamento = $('#cod_fonte_recurso_orcamento').val();
    var dt_inicial = $('#dt_inicial').val();
    var dt_final = $('#dt_final').val();
    var dt_inauguracao_lancamento = $('#dt_inauguracao_lancamento').val(); 
    var cod_orgao = $('#cod_orgao').val();
    var cod_usuario_responsavel = $('#cod_usuario_responsavel').val();

    if(retorno == '' && nr_tarefa == '') {        
        retorno = 'Campo NOME/NUMERO TAREFA não pode ser vazio.';
    }
    if(retorno == '' && txt_tarefa == '') {        
        retorno = 'Campo ESCOPO não pode ser vazio.';
    }    
    
    if(retorno == '' && dt_inicial == '') {        
        retorno = 'Campo DATA INICIAL não pode ser vazio.';
    }
    if(retorno == '' && dt_final == '') {        
        retorno = 'Campo DATA FINAL não pode ser vazio.';
    }    
    if(retorno == '' && cod_orgao == '') {        
        retorno = 'Campo LOTAÇÃO não pode ser vazio.';
    }
    if(retorno == '' && cod_usuario_responsavel == '') {        
        retorno = 'Campo USUÁRIO RESPONSÁVEL não pode ser vazio.';
    }

    return retorno;
}



function Desabilitar(id, idAtividadePlano,idPlano )
{

    $.confirm({
        title: '',
        content: 'DESEJA DESABILITAR A TAREFA?',
        buttons: {
            SIM: function () {
                
                $.ajax({
                    type: 'POST',
                    url: 'manter_tarefa.php',
                    data: {
                        acao: 'desabilitar',
                        cod_tarefa_atividade: id              				
                    },
                    async: false,
                    success: function (data) {
            
                        if($.parseJSON(data)["status"] == 'sucesso')
                        {                                       
                            js_go('listar_tarefa.php?id=' + idAtividadePlano + '&idPlanoAcao=' + idPlano);
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

function Habilitar(id, idAtividadePlano, idPlano )
{

    $.confirm({
        title: '',
        content: 'DESEJA HABILITAR A TAREFA?',
        buttons: {
            SIM: function () {
                
                $.ajax({
                    type: 'POST',
                    url: 'manter_tarefa.php',
                    data: {
                        acao: 'habilitar',
                        cod_tarefa_atividade: id              				
                    },
                    async: false,
                    success: function (data) {
            
                        if($.parseJSON(data)["status"] == 'sucesso')
                        {                                       
                            js_go('listar_tarefa.php?id=' + idAtividadePlano + '&idPlanoAcao=' + idPlano);
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