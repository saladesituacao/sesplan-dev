$(document).ready(function() {    
    dashboard_eixo();
});

function tabelaStatus(valor) {
    $('#div_mes').hide();
    $('#div_bimestre').hide();
    $('#div_princ').hide();
    $('#div_princ_pas').hide();
    $('#div_princ_sag').hide();

    if (valor != '') {   
        var div_mes_bimestre = '';
        $('#cod_modulo_marcado').val(valor);

        fn_retorna_meta(valor);

        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_status',
                cod_modulo: valor              				
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                
        
                var div = '';

                obj.forEach(function(i, item) {
                    div += '<div class="row">';                    
                    div += '<div class="col-md-12">';
                    div += '<input type="checkbox" class="form-check-input" name="cod_status[]" value="'+ i.cod_status +'">'
                    div += '&nbsp;' + i.txt_status + '';
                    div += '</div></div>';
                });
                
                $('#div_status').html(div);

                var div_meta_acao_etapa = '';
                //PAS
                if (valor == 1) {
                    $('#div_princ_pas').show();

                    fn_relogio_pas();                                   
                }   
                //SAG
                else if (valor == 2) {
                    $('#div_princ_sag').show();
                    $('#div_bimestre').show();

                    fn_relogio_sag();   
                                                                        
                }      
                //INDICADOR
                else if (valor == 3) {                                                                            
                    $('#div_princ').show();
                    $('#div_mes').show();                                        

                    fn_relogio();
                    /*
                    FusionCharts.ready(function() {
                        var fusioncharts = new FusionCharts({
                          type: 'angulargauge',
                          renderAt: 'div_alerta',
                          width: '200',
                          height: '150',
                          dataFormat: 'json',
                          dataSource: {
                              "chart": {
                                  "caption": "ALERTA",
                                  "subcaption": "",
                                  "lowerLimit": "0",
                                  "upperLimit": "100",
                                  "theme": "fusion"
                              },
                              "colorRange": {
                                  "color": [{
                                      "minValue": "0",
                                      "maxValue": "100",
                                      "code": "#FFFF00"
                                  }]
                              },
                              "dials": {
                                  "dial": [{
                                      "value": "67"
                                  }]
                              }
                          }
                        }
                      );
                      fusioncharts.render();
                    });      
                    */
                }        
                                            
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });                  
    }    
}

function MarcarEmenda() {
    if ($('#btn_emenda_parlamentar').prop("checked")) {
        $('#btn_emenda_parlamentar').val('1');        
    } else {
        $('#btn_emenda_parlamentar').val('0');
    }
    
}

function dashboard_objetivo(cod_eixo, cod_perspectiva, cod_diretriz) {
    if (cod_eixo != '' && cod_perspectiva != '' && cod_diretriz != '') {        
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_objetivo',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva,
                cod_diretriz: cod_diretriz
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="row col-md-12" align="left"><br />';            
                obj.forEach(function(i, item){                                                                      
                    div += '<div class="col-md-3" align="left">';                                        
                    div += '<input type="checkbox" class="form-check-input" id="btn_objetivo_'+ i.cod_objetivo +'" name="cod_objetivo[]" value="'+ i.cod_objetivo +'" title="'+ i.txt_objetivo +'">'+ i.codigo_objetivo +'</input>';                    
                    div += '</div>'; 
                });  
                div += '</div>';           
    
                $('#div_objetivo').html(div);                                               
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });         
    }
}

function dashboard_diretriz(cod_eixo, cod_perspectiva) {     
    $('#div_objetivo').html('');
    
    if (cod_eixo != '' && cod_perspectiva != '') {
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_diretriz',
                cod_eixo: cod_eixo,
                cod_perspectiva: cod_perspectiva            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="row col-md-12" align="left"><br />';         
                obj.forEach(function(i, item){                                                                        
                    div += '<div class="col-md-3" align="left">';                                        
                    div += '<input type="radio" class="form-check-input" id="btn_diretriz_'+ i.cod_diretriz +'" name="cod_diretriz[]" value="'+ i.cod_diretriz +'" onclick="dashboard_objetivo('+ cod_eixo +', '+ cod_perspectiva +', '+ i.cod_diretriz +');">'+ i.txt_titulo +'</input>';                    
                    div += '</div>'; 
                });            
                div += '</div>'; 

                $('#div_diretriz').html(div);                
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_perspectiva(valor) {    
    $('#div_diretriz').html('');
    $('#div_objetivo').html('');

    if (valor != '') {
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tabela_perspectiva',
                cod_eixo: valor            
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                var div = '<div class="row col-md-12" align="left"><br />';                             
                obj.forEach(function(i, item) {                                       
                    div += '<div class="col-md-4" align="left">';                    
                    div += '<input type="radio" class="form-check-input" id="btn_perspectiva_'+ i.cod_perspectiva +'" name="cod_perspectiva[]" value="'+ i.cod_perspectiva +'" onclick="dashboard_diretriz('+ valor +', '+ i.cod_perspectiva +');">'+ i.txt_perspectiva +'</input>';                    
                    div += '</div>'; 
                });            
                div += '</div>'; 
    
                $('#div_perspectiva').html(div);                             
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        }); 
    }
}

function dashboard_eixo() {    
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'tabela_eixo'                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                                            
            var div = '';  
           
            obj.forEach(function(i, item) {                                               
                div += '<div class="col-md-4" align="left">';                
                div += '<input type="radio" class="form-check-input" id="btn_eixo_'+ i.cod_eixo +'" name="cod_eixo[]" value="'+ i.cod_eixo +'" onclick="dashboard_perspectiva('+ i.cod_eixo +');">'+ i.txt_eixo +'</input>';                
                div += '</div>';    
            });            

            $('#div_eixo').html(div);            
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}

function  fn_retorna_meta(i) {    
    var cod_exibir_meta_complemento = $('#cod_exibir_meta_complemento').val();        

    if (i != 3 && i != 2 && i != 4 && i != 1) {
        cod_exibir_meta_complemento = 0;
    } 
    else {        
        cod_exibir_meta_complemento = i;
    }

    $('#cod_exibir_meta_complemento').val(cod_exibir_meta_complemento);
    
    if (cod_exibir_meta_complemento == 3) {   
        $('#div_complemento').html('');

        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'tag_indicador'                
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);                                            
                //var div = '<center><font color="blue">INSTRUMENTOS DE PLANEJAMENTO</font></center>';                                
                var div = '';
                obj.forEach(function(i, item) {                                         
                    div += '<div class="col-md-4">';                                  
                    div += '<input type="checkbox" class="form-check-input" id="cod_tag_'+ i.ds_tag +'" name="cod_tag[]" value="'+ i.ds_tag +'">'+ " " + i.ds_tag +'</input>';                    
                    div += '</div>'; 
                });                                         

                $('#div_complemento').html('<div class="col-md-12">' + div + '</div>'); 
                $('#div_espaco').html('<div class="row"><div class="col-md-12">&nbsp;</div></div>');                
    
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });
    }
    else if (cod_exibir_meta_complemento == 2 || cod_exibir_meta_complemento == 4) {
        $('#div_complemento').html('');

        var div = '';

        if (cod_exibir_meta_complemento == 2) {
            //ETAPA SAG
            $.ajax({
                type: 'POST',
                url: 'include/painel.php',
                data: {
                    acao: 'etapa_sag'                
                },
                async: false,
                success: function (data) {                              
                    var obj = JSON.parse(data);  
                    div += '<div class="col-md-4">ETAPA';            
                    div += '<select id="cod_etapa_sag" name="cod_etapa_sag[]" data-placeholder="." multiple class="chosen-select">';
                    div += '<option></option>';                                      
                    obj.forEach(function(i, item) {                                            
                        div += '<option value="'+ i.cod_sag +'">'+ i.nr_etapa_trabalho +' - '+ i.txt_etapa_trabalho +'</option>';                      
                    });     
                    div +='</select></div>';

                },				
                error: function (xhr, status, error) {
                    alert(xhr.responseText);    				
                }
            }); 
            
            //Emenda Parlamentar
            div += '<div class="col-md-2">';
            div += 'Emenda';                         
            div += '<select id="btn_emenda_parlamentar" name="btn_emenda_parlamentar" class="form-control">';
            div += '<option value=""></option>';
            div += '<option value="0">NÃO</option>';
            div += '<option value="1">SIM</option>';
            div +='</select></div>';     
            
            //EMPENHO
            div += '<div class="col-md-2">';
            div += 'Empenho';                         
            div += '<select id="btn_empenho" name="btn_empenho" class="form-control">';
            div += '<option value=""></option>';
            div += '<option value="0">NÃO</option>';
            div += '<option value="1">SIM</option>';
            div +='</select></div>';     
        }        
           
        /*div += '<div class="funkyradio" align="left">'
        div += '<div class="col-md-4">';
        div += '<div class="funkyradio-success">';
        div += '<input type="checkbox" id="btn_emenda_parlamentar" name="btn_emenda_parlamentar" value="" onclick="MarcarEmenda();"></input>';
        div += '<label for="btn_emenda_parlamentar">EMENDA PARLAMENTAR</label>';                    
        div += '</div></div></div>';*/

        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'programa_trabalho'                
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);      
                div += '<div class="col-md-4" align="left">' 
                div += 'Programa de Trabalho';                                                                                     
                div += '<select id="cod_progr" name="cod_progr[]" data-placeholder="." multiple class="chosen-select">';
                div += '<option></option>';
                obj.forEach(function(i, item) {                                            
                    div += '<option value="'+ i.cod_programa_trabalho +'">'+ i.nr_programa_trabalho +'</option>';

                    /*div += '<div class="funkyradio" align="left">'
                    div += '<div class="col-md-4">';
                    div += '<div class="funkyradio-success">';                    
                    div += '<input type="checkbox" id="cod_progr_'+ i.cod_programa_trabalho +'" name="cod_progr[]" value="'+ i.cod_programa_trabalho +'"></input>';
                    div += '<label for="cod_progr_'+ i.cod_programa_trabalho +'">'+ i.nr_programa_trabalho +'</label>';
                    div += '</div></div></div>'; */
                });     
                div +='</select></div>';

                $('#div_complemento').html(div);                                  
    
                $('#cod_progr').chosen();
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });     
        
        if (cod_exibir_meta_complemento == 2) {
            $('#cod_etapa_sag').chosen(); 
        }        
    }
    else if (cod_exibir_meta_complemento == 1) {
        var div = '';
                        

        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'acao_pas'                
            },
            async: false,
            success: function (data) {                              
                var obj = JSON.parse(data);  
                div += '<div class="col-md-6">AÇÃO';            
                div += '<select id="cod_acao_pas" name="cod_acao_pas[]" data-placeholder="." multiple class="chosen-select">';
                div += '<option></option>';                                      
                obj.forEach(function(i, item) {                                            
                    div += '<option value="'+ i.cod_pas +'">'+ i.codigo_acao +' - '+ i.txt_acao +'</option>';
                  
                });     
                div +='</select></div>';

                $('#div_complemento').html(div);   
                $('#cod_acao_pas').chosen();                               
                    
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });         
    }
    else if (cod_exibir_meta_complemento == 0) {
        $('#div_complemento').html('');                 
    }
      
}

function MarcarDesmarcar(id) {       
    if ($('#' + id + '').css('background-color') == 'rgb(252, 81, 13)') {
        $('#' + id + '').css('background-color', '#ffffff');        
    } else if($('#' + id + '').css('background-color') == 'rgb(244, 244, 244)' || $('#' + id + '').css('background-color') == 'rgb(255, 255, 255)') {
        $('#' + id + '').css('background-color', '#fc510d');
    }    
}

function Unidades(id) {
    var sigla = '';
    
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'sigla_unidade',
            cod_orgao: id                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                    
            obj.forEach(function(i, item) { 
                sigla = i.txt_sigla            
            });                        
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });         

    var div = '';

    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'unidades_filhas',
            cod_orgao: id                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                    
            obj.forEach(function(i, item) {                
                div += '<div class="row col-md-12">&nbsp;&nbsp;';
                div += '<input type="checkbox" class="form-check-input" name="cod_orgao[]" value="'+ i.cod_orgao +'">&nbsp;'+ i.txt_sigla.replace(sigla + "/", "") +'</input>';                
                div += '<a class="btn btn btn-xs" id="btn_cod_orgao_2_'+ i.cod_orgao +'" onclick="Unidades2('+ i.cod_orgao +', '+ id +');">+</a>';
                div += '<div id="div_cod_orgao_2_'+ i.cod_orgao +'"</div>';
                div += '</div>';
            });                        
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });      
    
    $('#div_cod_orgao_' + id).html(div);
}

function Unidades2(id, id_pai) { 
    var sigla = '';
    var sigla2 = '';
    var _sigla = '';
    
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'sigla_unidade',
            cod_orgao: id_pai                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                    
            obj.forEach(function(i, item) { 
                sigla = i.txt_sigla  + "/";                                                                     
            });                        
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });      
    
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'sigla_unidade',
            cod_orgao: id                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                    
            obj.forEach(function(i, item) {                                     
                sigla2 = i.txt_sigla.replace(sigla + '/', "");                                
            });                        
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });     

    var div = '';

    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'unidades_filhas',
            cod_orgao: id                
        },
        async: false,
        success: function (data) {                              
            var obj = JSON.parse(data);                                            
            obj.forEach(function(i, item) { 
                _sigla = i.txt_sigla.replace(sigla2 + "/", "");                                             

                div += '<div class="row col-md-12">&nbsp;&nbsp;&nbsp;&nbsp;';
                div += '<input type="checkbox" class="form-check-input" name="cod_orgao[]" value="'+ i.cod_orgao +'">&nbsp;'+ _sigla +'</input>';
                div += '</div>';
            });                        
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });      
    
    $('#div_cod_orgao_2_' + id).html(div);
}

function fn_relogio_sag() {
    var opts_normal = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#00CCFF',   // Colors
        colorStop: '#00CCFF',    // just experiment with them
        strokeColor: '#00CCFF',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_normal'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_normal); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_sag',
                cod_status: 9          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_normal_result').html('<strong>Normal '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_normal_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/

      var opts_critico_sag = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FF9933',   // Colors
        colorStop: '#FF9933',    // just experiment with them
        strokeColor: '#FF9933',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_critico_sag'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_critico_sag); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_sag',
                cod_status: 18          
            },
            async: false,
            success: function (data) { 
                x = data.split('|');                                     
                gauge.set(x[0]); // set actual value 
                $('#div_critico_sag_result').html('<strong>Crítico '+ x[0] +'% ('+ x[1] +')</strong><br />');   
                $('#hidden_critico_sag_result').val(x[0]);                                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });   

      /*---------------------------------------------------------------------------*/

      var opts_alerta_sag = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FFFF00',   // Colors
        colorStop: '#FFFF00',    // just experiment with them
        strokeColor: '#FFFF00',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_alerta_sag'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_alerta_sag); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_sag',
                cod_status: 16          
            },
            async: false,
            success: function (data) { 
                x = data.split('|');                                     
                gauge.set(x[0]); // set actual value 
                $('#div_alerta_sag_result').html('<strong>Alerta '+ x[0] +'% ('+ x[1] +')</strong><br />');   
                $('#hidden_alerta_sag_result').val(x[0]);                                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });   

      /*---------------------------------------------------------------------------*/

      var opts_nao_analisado_sag = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#D1D3D4',   // Colors
        colorStop: '#D1D3D4',    // just experiment with them
        strokeColor: '#D1D3D4',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_nao_analisado_sag'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_nao_analisado_sag); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_sag',
                cod_status: 24          
            },
            async: false,
            success: function (data) { 
                x = data.split('|');                                     
                gauge.set(x[0]); // set actual value 
                $('#div_nao_analisado_sag_result').html('<strong>Não analisado '+ x[0] +'% ('+ x[1] +')</strong><br />');   
                $('#hidden_nao_analisado_sag_result').val(x[0]);                                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });   

      /*---------------------------------------------------------------------------*/
      
    //TOTAL DE CADASTRADOS SAG
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'qtd_total_sag'            
        },
        async: false,
        success: function (data) {                                    
            $('#div_total_sag').html('<strong>Total:</strong> '+ data);              
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
      
}

function fn_relogio_pas() {
    var opts_cancelada = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#D1D3D4',   // Colors
        colorStop: '#D1D3D4',    // just experiment with them
        strokeColor: '#D1D3D4',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_cancelada'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_cancelada); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 6          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_cancelada_result').html('<strong>Cancelada '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_cancelada_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/

      var opts_concluida = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#00CCFF',   // Colors
        colorStop: '#00CCFF',    // just experiment with them
        strokeColor: '#00CCFF',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_concluida'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_concluida); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 4          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_concluida_result').html('<strong>Concluída '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_concluida_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/
/*
      var opts_pendente = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#D1D3D4',   // Colors
        colorStop: '#D1D3D4',    // just experiment with them
        strokeColor: '#D1D3D4',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_pendente'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_pendente); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 21          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_pendente_result').html('<strong>Pendente '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_pendente_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      */
      /*---------------------------------------------------------------------------*/
        /*
      var opts_prorrogada = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#D1D3D4',   // Colors
        colorStop: '#D1D3D4',    // just experiment with them
        strokeColor: '#D1D3D4',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_prorrogada'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_prorrogada); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 22          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_prorrogada_result').html('<strong>Prorrogada '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_prorrogada_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      */
      /*---------------------------------------------------------------------------*/

      var opts_atrasada = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FFFF00',   // Colors
        colorStop: '#FFFF00',    // just experiment with them
        strokeColor: '#FFFF00',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_atrasada'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_atrasada); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 5          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_atrasada_result').html('<strong>Atrasada '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_atrasada_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/
/*
      var opts_iniciada = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FF3333',   // Colors
        colorStop: '#FF3333',    // just experiment with them
        strokeColor: '#FF3333',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_iniciada'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_iniciada); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 1          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_iniciada_result').html('<strong>A ser iniciada '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_iniciada_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      */
      /*---------------------------------------------------------------------------*/

      var opts_andamento = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#009933',   // Colors
        colorStop: '#009933',    // just experiment with them
        strokeColor: '#009933',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_andamento'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_andamento); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 2          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_andamento_result').html('<strong>Andamento Normal '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_andamento_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/

      var opts_prazo = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#0099CC',   // Colors
        colorStop: '#0099CC',    // just experiment with them
        strokeColor: '#0099CC',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_prazo'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_prazo); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 3          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_prazo_result').html('<strong>Andamento Fora do Prazo '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_prazo_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/
/*
      var opts_postergada = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#9966CC',   // Colors
        colorStop: '#9966CC',    // just experiment with them
        strokeColor: '#9966CC',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_postergada'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_postergada); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 15          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_postergada_result').html('<strong>Postergada '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_postergada_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      */
      /*---------------------------------------------------------------------------*/

      var opts_nao_concluida = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FF3333',   // Colors
        colorStop: '#FF3333',    // just experiment with them
        strokeColor: '#FF3333',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_nao_concluida'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_nao_concluida); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_pas',
                cod_status: 25          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_nao_concluida_result').html('<strong>Não Concluída '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_nao_concluida_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       

      /*---------------------------------------------------------------------------*/
    //TOTAL DE CADASTRADOS PAS
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'qtd_total_pas'            
        },
        async: false,
        success: function (data) {                                    
            $('#div_total_pas').html('<strong>Total:</strong> '+ data);              
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_relogio() {
    var opts_alerta = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FFFF00',   // Colors
        colorStop: '#FFFF00',    // just experiment with them
        strokeColor: '#FFFF00',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_alerta'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_alerta); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_indicador',
                cod_status: 16          
            },
            async: false,
            success: function (data) {  
                x = data.split('|');                                   
                gauge.set(x[0]); // set actual value 
                $('#div_alerta_result').html('<strong>Alerta '+ x[0] +'% ('+ x[1] +')</strong><br />');  
                $('#hidden_alerta_result').val(x[0]);                                        
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });       
      
      /*---------------------------------------------------------------------------*/

      var opts_muito_critico = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FF3333',   // Colors
        colorStop: '#FF3333',    // just experiment with them
        strokeColor: '#FF3333',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_muito_critico'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_muito_critico); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
      $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_indicador',
            cod_status: 17          
        },
        async: false,
        success: function (data) {      
            x = data.split('|');                               
            gauge.set(x[0]); // set actual value 
            $('#div_muito_critico_result').html('<strong>Muito Crítico '+ x[0] +'% ('+ x[1] +')</strong><br />');  
            $('#hidden_muito_critico_result').val(x[0]);
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });   

      /*---------------------------------------------------------------------------*/

      var opts_critico = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#FF9933',   // Colors
        colorStop: '#FF9933',    // just experiment with them
        strokeColor: '#FF9933',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_critico'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_critico); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
        $.ajax({
            type: 'POST',
            url: 'include/painel.php',
            data: {
                acao: 'porcentagem_indicador',
                cod_status: 18          
            },
            async: false,
            success: function (data) { 
                x = data.split('|');                                     
                gauge.set(x[0]); // set actual value 
                $('#div_critico_result').html('<strong>Crítico '+ x[0] +'% ('+ x[1] +')</strong><br />');   
                $('#hidden_critico_result').val(x[0]);                                       
            },				
            error: function (xhr, status, error) {
                alert(xhr.responseText);    				
            }
        });   

      /*---------------------------------------------------------------------------*/

      var opts_esperado = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#009933',   // Colors
        colorStop: '#009933',    // just experiment with them
        strokeColor: '#009933',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_esperado'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_esperado); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
      $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_indicador',
            cod_status: 19          
        },
        async: false,
        success: function (data) { 
            x = data.split('|');                                    
            gauge.set(x[0]); // set actual value 
            $('#div_esperado_result').html('<strong>Esperado '+ x[0] +'% ('+ x[1] +')</strong><br />');    
            $('#hidden_esperado_result').val(x[0]);                                      
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });   

      /*---------------------------------------------------------------------------*/

      var opts_superado = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#00CCFF',   // Colors
        colorStop: '#00CCFF',    // just experiment with them
        strokeColor: '#00CCFF',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_superado'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_superado); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
      $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_indicador',
            cod_status: 20          
        },
        async: false,
        success: function (data) {   
            x = data.split('|');                                  
            gauge.set(x[0]); // set actual value 
            $('#div_superado_result').html('<strong>Superado '+ x[0] +'% ('+ x[1] +')</strong><br />');   
            $('#hidden_superado_result').val(x[0]);                                       
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });  

    /*---------------------------------------------------------------------------*/

    var opts_nao_analisado = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
          length: 0.6, // // Relative to gauge radius
          strokeWidth: 0.035, // The thickness
          color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#D1D3D4',   // Colors
        colorStop: '#D1D3D4',    // just experiment with them
        strokeColor: '#D1D3D4',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support
        
      };
      var target = document.getElementById('div_nao_analisado'); // your canvas element
      var gauge = new Gauge(target).setOptions(opts_nao_analisado); // create sexy gauge!
      gauge.maxValue = 100; // set max gauge value
      gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
      gauge.animationSpeed = 32; // set animation speed (32 is default value)
      
      $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_indicador',
            cod_status: "0",
            hidden_alerta_result: $('#hidden_alerta_result').val(),
            hidden_muito_critico_result: $('#hidden_muito_critico_result').val(),
            hidden_critico_result: $('#hidden_critico_result').val(),
            hidden_esperado_result: $('#hidden_esperado_result').val(),
            hidden_superado_result: $('#hidden_superado_result').val()
        },
        async: false,
        success: function (data) {   
            x = data.split('|');          
            gauge.set(x[0]); // set actual value 
            $('#div_nao_analisado_result').html('<strong>Não Analisado '+ x[0] +'% ('+ x[1] +')</strong><br />');                
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });

    /*---------------------------------------------------------------------------*/
    //TOTAL DE INDICADORES CADASTRADOS
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'qtd_total_indicadores'            
        },
        async: false,
        success: function (data) {                                    
            $('#div_total_indicadores').html('<strong>Total de indicadores cadastrados:</strong> '+ data);              
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_total_status_pas(cod_status) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_pas',
            cod_status: cod_status,            
        },
        async: false,
        success: function (data) {  
            x = data.split("|");   
            if (cod_status == 6) {
                document.getElementById("div_cancelada").title = 'Total: ' + x[1]; 
            }                                                                       
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_total_status_sag(cod_status) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_sag',
            cod_status: cod_status,            
        },
        async: false,
        success: function (data) {  
            x = data.split("|");   
            if (cod_status == 9) {
                document.getElementById("div_normal").title = 'Total: ' + x[1]; 
            }                                                                       
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function fn_total_status(cod_status) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'porcentagem_indicador',
            cod_status: cod_status,            
        },
        async: false,
        success: function (data) {  
            x = data.split("|");   
            if (cod_status == 16) {
                document.getElementById("div_alerta").title = 'Total: ' + x[1]; 
            } else if (cod_status == 17) {
                document.getElementById("div_muito_critico").title = 'Total: ' + x[1]; 
            } else if (cod_status == 18) {
                document.getElementById("div_critico").title = 'Total: ' + x[1]; 
            } else if (cod_status == 19) {
                document.getElementById("div_esperado").title = 'Total: ' + x[1]; 
            } else if (cod_status == 20) {
                document.getElementById("div_superado").title = 'Total: ' + x[1]; 
            } else if (cod_status == 0) {
                document.getElementById("div_nao_analisado").title = 'Total: ' + x[1]; 
            }                                                                               
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });
}

function AnoCorrente(id) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'ano_corrente',
            cod_ano_corrente: id,            
        },
        async: false,
        success: function (data) {                      
            var cod_modulo_marcado = document.getElementById('cod_modulo_marcado').value;
            tabelaStatus(cod_modulo_marcado);  
            document.getElementById('cod_modulo_' + cod_modulo_marcado).checked = true;
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}

function MesCorrente(id) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'mes_corrente',
            cod_mes_corrente: id,            
        },
        async: false,
        success: function (data) {                      
            var cod_modulo_marcado = document.getElementById('cod_modulo_marcado').value;
            tabelaStatus(cod_modulo_marcado);  
            document.getElementById('cod_modulo_' + cod_modulo_marcado).checked = true;
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}

function BimestreCorrente(id) {
    $.ajax({
        type: 'POST',
        url: 'include/painel.php',
        data: {
            acao: 'bimestre_corrente',
            cod_bimestre_corrente: id,            
        },
        async: false,
        success: function (data) {                      
            var cod_modulo_marcado = document.getElementById('cod_modulo_marcado').value;
            tabelaStatus(cod_modulo_marcado);  
            document.getElementById('cod_modulo_' + cod_modulo_marcado).checked = true;
        },				
        error: function (xhr, status, error) {
            alert(xhr.responseText);    				
        }
    });    
}