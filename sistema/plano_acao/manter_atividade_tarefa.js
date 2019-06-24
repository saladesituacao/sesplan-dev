function fn_listar_atividades(cod_plano_acao) { 
    var acao = $('#btn_atividade_hidden_' + cod_plano_acao).val();      

    if (acao == '+' || acao == '') {        
        $('#btn_atividade_' + cod_plano_acao).val("-"); 
        $('#btn_atividade_hidden_' + cod_plano_acao).val("-");

        $.ajax({
            type: 'POST',
            url: 'manter_atividade_tarefa.php',
            data: {
                acao: 'fn_listar_atividades',
                cod_plano_acao: cod_plano_acao           				
            },
            async: false,
            success: function (data) {                
                var obj = JSON.parse(data);   
                var div = '';         
                var dt_inauguracao_lancamento;      
                
                if (obj == '') {
                    div = 'NÃO EXISTEM ATIVIDADES CADASTRADAS PARA ESTA AÇÃO.<br />';
                } else {
                    div += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
                    div += '<thead><tr>';
                    div += '<th>N.º da Atividade</th>';
                    div += '<th>Escopo (Atividade)</th>';
                    div += '<th>Prazo</th>';
                    div += '<th>Unidade</th>';
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
                        div += '<td title=\"' + i.nr_atividade + '\">';
                        div += '<input type="button" id="btn_tarefa_'+ i.cod_atividade_plano_acao +'" onclick="fn_listar_tarefas('+ i.cod_atividade_plano_acao +');" class="btn btn-default" value="+" title="Exibir tarefas"/>';
						div += '<input type="hidden" name="btn_tarefa_hidden_'+ i.cod_atividade_plano_acao +'"id="btn_tarefa_hidden_'+ i.cod_atividade_plano_acao +'" value="" /> ';
                        div += TruncarStr(i.nr_atividade,10) + '</td>';
                        div += '<td title=\"' + i.txt_atividade + '\">' + TruncarStr(i.txt_atividade,50) + '</td>';
                        div += '<td>' + i.nr_prazo + '</td>';
                        div += '<td>' + i.txt_unidade_prazo + '</td>';
                        div += '<td>' + i.nr_valor.replace(".", ",") + '</td>';
                        div += '<td>' + i.cod_fonte_recurso_orcamento + '</td>';
                        div += '<td>' + i.dt_inicial + '</td>';
                        div += '<td>' + i.dt_final + '</td>';
                        div += '<td>' + dt_inauguracao_lancamento + '</td>';
                        div += '<td>' + i.nr_status_percentual_execucao + '</td>';

                        div += '<td>' + i.nr_processo_sei + '</td>';
                        div += '<td title=\"' + i.txt_reporte_execucao + '\">' + TruncarStr(i.txt_reporte_execucao,50) + '</td>';
                        div += '<td title=\"' + i.txt_entraves_riscos + '\">' + TruncarStr(i.txt_entraves_riscos,50) + '</td>';
                        div += '<td title=\"' + i.txt_desburocratizacao + '\">' + TruncarStr(i.txt_desburocratizacao,50) + '</td>';

                        div += '<td>' + i.txt_usuario + '</td>';
                        div += '<td>' + i.txt_sigla + '</td>';
                        if (i.ind_habilitado = 'SIM') {
                            div += '<td><font color=\"green\"><b>' + i.ind_habilitado + '</b></font></td>';
                        } else if (i.ind_habilitado = 'NÃO') {
                            div += '<td><font color=\"red\"><b>' + i.ind_habilitado + '</b></font></td>';
                        }                
                        div += '</tr>';
                        div += '<tr><td colspan="7">';						
                        div += '<div id="div_tarefas_'+ i.cod_atividade_plano_acao +'"></div>';
                        div += '</td></tr>';								
                    });
                    
                    div += '</table>';
                }                            
    
                $('#div_atividades_' + cod_plano_acao).html(div); 
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });

    } else {       
        $('#btn_atividade_' + cod_plano_acao).val("+"); 
        $('#btn_atividade_hidden_' + cod_plano_acao).val("+");          
        $('#div_atividades_' + cod_plano_acao).html(''); 
    }    
}

function fn_listar_tarefas(cod_atividade_plano_acao) { 
    var acao = $('#btn_tarefa_hidden_' + cod_atividade_plano_acao).val();      

    if (acao == '+' || acao == '') {        
        $('#btn_tarefa_' + cod_atividade_plano_acao).val("-"); 
        $('#btn_tarefa_hidden_' + cod_atividade_plano_acao).val("-");

        $.ajax({
            type: 'POST',
            url: 'manter_atividade_tarefa.php',
            data: {
                acao: 'fn_listar_tarefas',
                cod_atividade_plano_acao: cod_atividade_plano_acao           				
            },
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);   
                var div = '';         
                var dt_inauguracao_lancamento;      
                
                if (obj == '') {
                    div = '<center>NÃO EXISTEM TAREFAS CADASTRADAS PARA ESTA ATIVIDADE.</center><br />';
                } else {
                    div += '<table class="table table-striped" cellspacing="0" cellpadding="0">';
                    div += '<thead><tr>';
                    div += '<th>N.º da Tarefa</th>';
                    div += '<th>Escopo (Tarefa)</th>';
                    div += '<th>Prazo</th>';
                    div += '<th>Unidade</th>';
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
                        div += '<td title=\"' + i.nr_tarefa + '\">' + TruncarStr(i.nr_tarefa,10) + '</td>';
                        div += '<td title=\"' + i.txt_tarefa + '\">' + TruncarStr(i.txt_tarefa,50) + '</td>';
                        div += '<td>' + i.nr_prazo + '</td>';
                        div += '<td>' + i.txt_unidade_prazo + '</td>';
                        div += '<td>' + i.nr_valor.replace(".", ",") + '</td>';
                        div += '<td>' + i.cod_fonte_recurso_orcamento + '</td>';
                        div += '<td>' + i.dt_inicial + '</td>';
                        div += '<td>' + i.dt_final + '</td>';
                        div += '<td>' + dt_inauguracao_lancamento + '</td>';
                        div += '<td>' + i.nr_status_percentual_execucao + '</td>';

                        div += '<td>' + i.nr_processo_sei + '</td>';
                        div += '<td title=\"' + i.txt_reporte_execucao + '\">' + TruncarStr(i.txt_reporte_execucao,50) + '</td>';
                        div += '<td title=\"' + i.txt_entraves_riscos + '\">' + TruncarStr(i.txt_entraves_riscos,50) + '</td>';
                        div += '<td title=\"' + i.txt_desburocratizacao + '\">' + TruncarStr(i.txt_desburocratizacao,50) + '</td>';

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
    
                $('#div_tarefas_' + cod_atividade_plano_acao).html(div); 
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });

    } else {       
        $('#btn_tarefa_' + cod_atividade_plano_acao).val("+"); 
        $('#btn_tarefa_hidden_' + cod_atividade_plano_acao).val("+");          
        $('#div_tarefas_' + cod_atividade_plano_acao).html(''); 
    }    
}