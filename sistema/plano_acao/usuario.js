function fn_usuario_orgao(cod_orgao) {
    $.ajax({
        type: 'POST',
        url: 'usuario.php',
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