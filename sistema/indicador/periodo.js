$( function() {
    $( "#dt_inicio" ).datepicker();
    $( "#dt_fim" ).datepicker();
});

function Salvar() {
    var cod_ano = $('#cod_ano').val();  
    var dt_inicio = $('#dt_inicio').val();  
    var dt_fim = $('#dt_fim').val();

    if (cod_ano == '') {
        js_alert('', 'Campo COMPETÊNCIA não pode ser vazio.');
        return false;
    }
    if (dt_inicio == '') {
        js_alert('', 'Campo DATA INÍCIO não pode ser vazio.');
        return false;
    } else {
        if (!validateDate(dt_inicio)) {
            js_alert('', 'DATA INÍCIO inválida.');
            return false;
        }
    }        
    if (dt_fim == '') {
        js_alert('', 'DATA FIM não pode ser vazio.');
        return false;
    } else {
        if (!validateDate(dt_fim)) {
            js_alert('', 'DATA FIM inválida.');
            return false;
        }
    }

    var data_inicio = parseInt(dt_inicio.split("/")[2].toString() + dt_inicio.split("/")[1].toString() + dt_inicio.split("/")[0].toString());
    var data_fim = parseInt(dt_fim.split("/")[2].toString() + dt_fim.split("/")[1].toString() + dt_fim.split("/")[0].toString());;    
    if (data_fim < data_inicio) {
        js_alert('', 'Data Final não pode ser menor que a Data Inicial.');
        return false;
    }

    $('#frm1').attr('action', 'manter.php');
    $('#acao').val('incluir_periodo_atualizacao');
}

function Excluir(id) {
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O PERÍODO?',
        buttons: {
            SIM: function () {
                $.ajax({
                    type: 'POST',
                    url: 'manter.php',
                    data: {
                        acao: 'excluir_periodo_atualizacao',                        
                        id: id
                    },
                    async: false,
                    success: function (data) {                        
                        js_go('periodo.php');                                  
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