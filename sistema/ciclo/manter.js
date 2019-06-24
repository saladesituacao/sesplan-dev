function ValidarIncluir() {
    var cod_tipo_documento = $('#cod_tipo_documento').val();
    var txt_arquivo = $('#txt_arquivo').val();
    var retorno = true;

    if (retorno && cod_tipo_documento == '') {
        js_alert('', 'Campo DOCUMENTO não pode ser vazio.');
        retorno = false;
    }
    if (retorno && txt_arquivo == '') {
        js_alert('', 'Campo ARQUIVO não pode ser vazio.');
        retorno = false;
    }    

   
    return retorno;
}

function verificaExtensao($input) {
    //var extPermitidas = ['jpg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
    var extPermitidas = ['pdf', 'PDF'];
    var extArquivo = $input.value.split('.').pop();

    if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
        $('#txt_arquivo').val('');
        js_alert('', 'EXTENSÃO ' + extArquivo + ' NÃO PERMITIDA.');
        return false;
    } else {
       return true;
    }
}

function Excluir(id)
{
    $.confirm({
        title: '',
        content: 'DESEJA EXCLUIR O ARQUIVO E O LINK DO DOCUMENTO?',
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
                        js_go('incluir.php');                                        
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