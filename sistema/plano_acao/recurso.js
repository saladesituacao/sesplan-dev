function fn_fonte_recurso(cod_fonte_recurso) {   

    $.ajax({
        type: 'POST',
        url: 'recurso.php',
        data: {
            acao: 'fn_fonte_recurso',
            cod_fonte_recurso: cod_fonte_recurso           				
        },
        async: false,
        success: function (data) {
            var obj = JSON.parse(data);   
            var div = '';
            div += '<select id="cod_fonte_recurso_orcamento" name="cod_fonte_recurso_orcamento" class="form-control">';
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