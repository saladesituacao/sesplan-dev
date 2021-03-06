<?php
function menu() {
    
?>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">                
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/index.php"><strong><?php echo($_SESSION["txt_sigla_sistema"]) ?></strong></a>-->
                <a class="navbar-brand" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/index.php">
                    <img src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/assets/img/sesplan-logo-para-fundo-branco.png" height="50" width="149" title="Sistema Estratégico de Planejamento"/>
                </a>                                
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#exampleModal">
                    <span class="hidden-xs"><?php echo($_SESSION['txt_usuario']) ?></span>
                </a>
                <a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/logout.php" title="SAIR COM SEGURANÇA" class="btn btn-default">Sair</a>
                <?php                
                include_once (__DIR__ . "/combo_usuario_orgao.php");                 
                ?>                                  
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">                                                                                             
                    <li class="dropdown">
                        <br />
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Administrador</strong><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (permissao_acesso(1)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/eixo/default.php">Eixos</a></li>
                            <?php
                            } ?>   
                            <?php if (permissao_acesso(5)) { ?>                         
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/perspectiva/default.php">Perspectivas</a></li>
                            <?php
                            } ?> 
                            <?php if (permissao_acesso(84)) { ?>  
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/diretriz/default.php">Diretrizes</a></li>
                            <?php
                            } ?> 
                            <?php if (permissao_acesso(9)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/objetivo/default.php">Objetivos</a></li>
                            <?php
                            } ?> 
                            <?php if (permissao_acesso(13)) { ?> 
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/objetivo_ppa/default.php">Objetivos PPA</a></li>
                            <?php
                            } ?>    
                            <?php if (permissao_acesso(17)) { ?> 
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/programa_trabalho/default.php">Programa de Trabalho</a></li>
                            <?php
                            } ?> 
                            <?php if (permissao_acesso(23)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/gerencia/default.php">Tabelas de Apoio</a></li>
                            <?php
                            } ?>
                        </ul>
                    </li>                      
                    <li class="dropdown">
                        <br />
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Monitoramento</strong><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (permissao_acesso(22)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/indicador/default.php">Filtro por Objetivo Estratégico</a></li>
                            <?php } ?> 
                            <?php if (permissao_acesso(60)) { ?>   
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/indicador/opcao.php">Indicador</a></li>  
                            <?php } ?> 
                            <?php if (permissao_acesso(67)) { ?>                   
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/pas/opcao.php">PAS</a></li>
                            <?php } ?> 
                            <?php if (permissao_acesso(76)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/sag/opcao.php">SAG</a></li>
                            <?php } ?> 
                            <?php if (permissao_acesso(59)) { ?>
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/execucao_orcamentaria/default.php">Execução Orçamentária</a></li>                         
                            <?php } ?>  
                            <?php if (permissao_acesso(97)) { ?>                          
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/plano_acao/default.php">Plano de Ação</a></li>                         
                            <?php } ?> 
                        </ul>
                    </li>  
                    <li><br /><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/ciclo/default.php"><strong>Ciclo Planejamento</strong></a></li>                                            
                    <li class="dropdown">
                        <br />
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Relatórios</strong><span class="caret"></span></a>
                        <?php if (permissao_acesso(24)) { ?>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/gerencia/relatorio/auditoria.php">Auditoria</a></li>                                
                                <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/gerencia/relatorio/analitico.php">Analítico</a></li>
                            </ul>
                        <?php } ?>
                    </li>  
                    <li class="dropdown">
                        <br />
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Saiba +</strong><span class="caret"></span></a>
                        <ul class="dropdown-menu"> 
                            <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/gerencia/saiba/informacao.php">O que é SESPlan?</a></li>
                            <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/gerencia/regua/default.php">Régua</a></li> 
                            <!--<li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"])?>/visualizador/web/viewer.html?file=<?php echo(urlencode($_SESSION["txt_caminho_aplicacao"]));?>/manual/Conceitos_Indicadores.pdf">Indicadores</a></li>-->
                            <?php     
                            $qsaiba = pg_query("SELECT cod_tipo_documento, txt_tipo_documento FROM tb_saiba_tipo WHERE cod_ativo = 1 ORDER BY txt_tipo_documento");                            
                            if (pg_num_rows($qsaiba) > 0) {
                                while($rs1Saiba = pg_fetch_array($qsaiba)) {
                                ?>
                                    <li><a href="<?php echo($_SESSION["txt_caminho_aplicacao"])?>/gerencia/saiba/manter.php?acao=temp&cod_tipo_documento=<?php echo($rs1Saiba['cod_tipo_documento'])?>"><?php echo($rs1Saiba['txt_tipo_documento'])?></a></li>
                                <?php 
                                }                            
                            }
                            ?>                            
                        </ul>
                    </li>                      
                </ul>                
            </div><!--/.nav-collapse -->
        </div>
    </nav>    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong><?php echo($_SESSION['txt_usuario']) ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="div_dados_usuario"></div>                    
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                    
                </div>         
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {        
            $.ajax({
                type: 'POST',
                url: '<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/arvore.php',
                data: {
                    acao: 'dados_usuario'                             				
                },
                async: false,
                success: function (data) {                                       
                    var obj = JSON.parse(data);                
        
                    var div_dados_usuario = '<div class="row">';  
                    div_dados_usuario += '<div class="form-group col-md-12">';
                    
                    obj.forEach(function(i, item) {
                        div_dados_usuario += '<strong>LOGIN:</strong> ' + i.txt_login + '<br />';
                        div_dados_usuario +=  '<strong>E-MAIL:</strong> ' + i.txt_email + '<br />';    
                        div_dados_usuario += '<strong>CARGO:</strong> ' + i.txt_cargo + '<br />';    
                        div_dados_usuario += '<strong>PERFIL:</strong> ' + i.txt_perfil + '<br />';    
                        div_dados_usuario += '<strong>LOTAÇÃO:</strong> ' + i.txt_sigla;    
                    });
                    div_dados_usuario += '</div></div>'
        
                    $('#div_dados_usuario').html(div_dados_usuario);                                
                }
            });
        });          
    </script>
<?php
}
?>