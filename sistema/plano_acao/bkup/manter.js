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

$( "#btn_complementar" ).click(function() {
    var erro = '';
    erro = ValidarComplementar();

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
    var txt_escopo = $('#txt_escopo').val();   
    var cod_usuario_responsavel = $('#cod_usuario_responsavel').val(); 
    var cod_orgao = $('#cod_orgao').val();

    if(retorno == '' && cod_acao == '') {        
        retorno = 'Campo AÇÃO não pode ser vazio.';
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

    if(retorno == '' && txt_escopo == '') {        
        retorno = 'Campo ESCOPO / ATIVIDADE não pode ser vazio.';
    }    

    if(retorno == '' && cod_usuario_responsavel == '') {        
        retorno = 'Campo USUÁRIO RESPONSÁVEL não pode ser vazio.';
    }  

    if(retorno == '' && cod_orgao == '') {        
        retorno = 'Campo LOTAÇÃO não pode ser vazio.';
    } 

    return retorno;
}

function ValidarComplementar() {
    var retorno  = '';
    var nr_valor = $('#nr_valor').val();
    var cod_fonte_recurso = $('#cod_fonte_recurso').val();
    var cod_fonte_recurso_orcamento = $('#cod_fonte_recurso_orcamento').val();
    var dt_inicial = $('#dt_inicial').val();
    var dt_final = $('#dt_final').val();
    var dt_inauguracao_lancamento = $('#dt_inauguracao_lancamento').val();     

    if(retorno == '' && nr_valor == '') {        
        retorno = 'Campo VALOR não pode ser vazio.';
    }
    if(retorno == '' && cod_fonte_recurso == '') {        
        retorno = 'Campo FONTE DE RECURSO não pode ser vazio.';
    }
    if(retorno == '' && cod_fonte_recurso_orcamento == '') {        
        retorno = 'Campo ESPECIFICAÇÃO não pode ser vazio.';
    }
    if(retorno == '' && dt_inicial == '') {        
        retorno = 'Campo DATA INICIAL não pode ser vazio.';
    }
    if(retorno == '' && dt_final == '') {        
        retorno = 'Campo DATA FINAL não pode ser vazio.';
    }
    if(retorno == '' && dt_inauguracao_lancamento == '') {        
        retorno = 'Campo DATA INAUGURAÇÃO/LANÇAMENTO não pode ser vazio.';
    }    

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




function fn_usuario_orgao(cod_orgao) {
    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'fn_usuario_orgao',
            cod_orgao: cod_orgao           				
        },
        async: false,
        success: function (data) {
            var obj = JSON.parse(data);   
            var div = '';
            div += '<select id="cod_usuario_responsavel" name="cod_usuario_responsavel" data-placeholder="Obrigatório" class="form-control">';
            div += '<option></option>';                                      
            obj.forEach(function(i, item) {                                            
                div += '<option value="'+ i.cod_usuario +'">'+ i.txt_usuario +'</option>';                      
            });     
            div +='</select>';   
            
            $('#div_usuario').html(div); 
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_fonte_recurso(cod_fonte_recurso) {   
    $.ajax({
        type: 'POST',
        url: 'manter.php',
        data: {
            acao: 'fn_fonte_recurso',
            cod_fonte_recurso: cod_fonte_recurso           				
        },
        async: false,
        success: function (data) {
            var obj = JSON.parse(data);   
            var div = '';
            div += '<select id="cod_fonte_recurso_orcamento" name="cod_fonte_recurso_orcamento" data-placeholder="Obrigatório" class="form-control">';
            div += '<option></option>';                                      
            obj.forEach(function(i, item) {                                            
                div += '<option value="'+ i.cod_fonte_recurso_orcamento +'">'+ i.txt_fonte_recurso_orcamento +'</option>';                      
            });     
            div +='</select>';   
            
            $('#div_fonte_recurso').html(div); 
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_listar_tarefas(cod_plano_acao) { 
    var acao = $('#btn_tarefa_hidden_' + cod_plano_acao).val();      

    if (acao == '+' || acao == '') {        
        $('#btn_tarefa_' + cod_plano_acao).val("-"); 
        $('#btn_tarefa_hidden_' + cod_plano_acao).val("-");       

        $.ajax({
            type: 'POST',
            url: 'manter.php',
            data: {
                acao: 'fn_listar_tarefas',
                cod_plano_acao: cod_plano_acao           				
            },
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);   
                var div = '';         
                var dt_inauguracao_lancamento;      
                
                if (obj == '') {
                    div = '<center>NÃO EXISTEM TAREFAS CADASTRADAS PARA ESTA AÇÃO.</center><br />';
                } else {
                    div += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
                    div += '<thead><tr>';
                    div += '<th>Tarefa</th>';
                    div += '<th>Escopo (Tarefa)</th>';
                    div += '<th>Valor</th>';
                    div += '<th>Fonte</th>';
                    div += '<th>Data Inicial</th>';
                    div += '<th>Data Final</th>';
                    div += '<th>Data Inauguração</th>';
                    div += '<th>Status % Execução</th>';

                    div += '<th>Processo SEI n°</th>';
                    div += '<th>Reporte / Execução</th>';
                    div += '<th>Entraves / Riscos</th>';
                    div += '<th>Desburocratização (Apoio Casa Civil)</th>';



                    div += '<th>Usuário Responsável</th>';
                    div += '<th>Área</th>';
                    div += '<th>Ativo</th>';
                    div += '</tr></thead>';
        
                    obj.forEach(function(i, item) {                           
                        if (dt_inauguracao_lancamento == null || dt_inauguracao_lancamento == undefined) {
                            dt_inauguracao_lancamento = '';
                        }
                         
                        div += '<tr>';
                        div += '<td title=\"' + i.txt_tarefa + '\">' + TruncarStr(i.txt_tarefa,10) + '</td>';
                        div += '<td title=\"' + i.txt_escopo_tarefa + '\">' + TruncarStr(i.txt_escopo_tarefa,50) + '</td>';
                        div += '<td>' + i.nr_valor.replace(".", ",") + '</td>';
                        div += '<td>' + i.cod_fonte_recurso_orcamento + '</td>';
                        div += '<td>' + i.dt_inicial + '</td>';
                        div += '<td>' + i.dt_final + '</td>';
                        div += '<td>' + dt_inauguracao_lancamento + '</td>';
                        div += '<td>' + i.nr_status_percentual_execucao + '</td>';

                        div += '<td>' + i.nr_processo_sei + '</td>';
                        div += '<td title=\"' + i.txt_escopo_tarefa + '\">' + TruncarStr(i.txt_escopo_tarefa,50) + '</td>';
                        div += '<td title=\"' + i.txt_escopo_tarefa + '\">' + TruncarStr(i.txt_escopo_tarefa,50) + '</td>';
                        div += '<td title=\"' + i.txt_escopo_tarefa + '\">' + TruncarStr(i.txt_escopo_tarefa,50) + '</td>';

                        div += '<td>' + i.txt_usuario + '</td>';
                        div += '<td>' + i.txt_sigla + '</td>';
                        if (i.ind_habilitado = 'SIM') {
                            div += '<td><font color=\"green\"><b>' + i.ind_habilitado + '</b></font></td>';
                        } else if (i.ind_habilitado = 'NÃO') {
                            div += '<td><font color=\"red\"><b>' + i.ind_habilitado + '</b></font></td>';
                        }                
                        div += '</tr>';
                    });
                    
                    div += '</table>';
                }                            
    
                $('#div_tarefas_' + cod_plano_acao).html(div); 
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });

    } else {       
        $('#btn_tarefa_' + cod_plano_acao).val("+"); 
        $('#btn_tarefa_hidden_' + cod_plano_acao).val("+");          
        $('#div_tarefas_' + cod_plano_acao).html(''); 
    }    
}