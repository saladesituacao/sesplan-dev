<?php
include_once (__DIR__ . "/../../include/conexao.php");

verifica_seguranca();
cabecalho();

?>
<div id="main" class="container-fluid" style="margin-top: 50px">    
    <div class="row">        
        <div class="col-md-3"></div>
        <div class="col-md-9"> 
            <img src="sesplan-logo-fundo-branco.png" width="60%">
        </div>            
    </div>  <br />
    <div class="row">         
        <div class="col-md-12"> 
            <center><h3><b>Sistema Estratégico de Planejamento da Secretaria de Saúde - SESPlan</b></h3></center>
        </div>                    
    </div> <br />  
    <div class="row"> 
        <div class="col-md-2"></div>       
        <div class="col-md-8"> 
            <p align='justify'>O SESPlan é um sistema voltado para o planejamento e programação em saúde no DF. Ele consolida informações e resultados para apoiar a tomada de decisão dos gestores, qualificando-se como um sistema institucional para o monitoramento da execução das ações estratégicas com o intuito de integrar os instrumentos de planejamento pactuados.</p>
        </div>                    
    </div> <hr /> 
    <div class="row">   
        <div class="col-md-12">       
            <center><h4><strong>Histórico</strong></h4></center>
        </div>
    </div><hr />  
    <div class="row">   
        <div class="col-md-2"></div> 
        <div class="col-md-8">
            <p align='justify'>
                O desenvolvimento da ferramenta SESPLAN foi realizado em 2016 pela Diretoria de Planejamento em Saúde (DIPLAN) composta pelas Gerencias de Orçamento, Planejamento e Monitoramento e Avaliação. Construída para a gestão do ciclo do planejamento, padroniza e sistematiza o recebimento de dados e informações ao mesmo tempo que permite aos profissionais analisarem a situação do seu desempenho, sem ficarem restritos a relatórios formais, que fundamentais para a prestação de contas, não são instrumentos adequados para o monitoramento.            
            </p>
            <p align='justify'>
                A SESPLAN foi construída inicialmente em plataforma de Excel com linguagem visual basic. Seu desenvolvimento durou cinco meses tendo um profissional exclusivo na elaboração, reuniões semanais com as gerentes e diretora para validação. A homologação ocorreu na própria diretoria por um mês, sendo no final aprovada pelo Secretário de Saúde. O processo de implantação contou com treinamento para todas as áreas do nível central da secretaria.
            </p>
            <p align='justify'>
                Sugerimos a leitura do artigo “Construção de um Modelo para a gestão do ciclo do Planejamento Integrado da Secretaria de Estado de Saúde do Distrito Federal: Relato de Experiência” publicado no periódico Comunicação em Ciências da Saúde (CCS), acessado por meio do endereço eletrônico:
            </p>
            <a href="http://www.escs.edu.br/revistaccs/index.php/comunicacaoemcienciasdasaude/article/view/182." target="_blank">http://www.escs.edu.br/revistaccs/index.php/comunicacaoemcienciasdasaude/article/view/182.</a>
        </div>          
    </div><br />  
    <div class="row">   
        <div class="col-md-12">   
        <hr />     
            <center><h4><strong>Linha do Tempo</strong></h4></center>
        </div>
    </div><hr />  
    <div class="row">        
        <div class="col-md-2"></div>
        <div class="col-md-10"> 
            <img src="linha_tempo.png" width="80%">
        </div>            
    </div>  <br />
    <div class="row">   
        <div class="col-md-12">   
        <hr />     
            <center><h4><strong>Para que serve?</strong></h4></center>
        </div>
    </div><hr /> 
    <div class="row">   
        <div class="col-md-2"></div> 
        <div class="col-md-8">
            <p align='justify'>
                O sistema permite a aproximação do planejamento ao orçamento com diretrizes na execução, monitoramento e avaliação contínua dos serviços de saúde na SES DF. Trata-se de um modelo integrado para a gestão dos instrumentos de planejamento com o objetivo de auxiliar os profissionais e gestores na análise da situação do seu desempenho, visando uma gestão para resultados.
            </p>                  
        </div>          
    </div><br />  
    <div class="row">   
        <div class="col-md-12">   
        <hr />     
            <center><h4><strong>Composição</strong></h4></center>
        </div>
    </div><hr /> 
    <div class="row">   
        <div class="col-md-2"></div> 
        <div class="col-md-8">
            <p>
                Plano Distrital de Saúde - PDS, Plano Plurianual - PPA, Pactuação Interfederativa de Indicadores, Programação Anual de Saúde - PAS, Lei Orçamentária Anual – LOA, e a Execução Orçamentária - Etapa SAG.
            </p>                  
        </div>
    </div><br /> 
    <div class="row">   
        <div class="col-md-12">   
        <hr />     
            <center><h4><strong>Estrutura</strong></h4></center>
        </div>
    </div><hr /> 
    <div class="row">   
        <div class="col-md-2"></div> 
        <div class="col-md-8">
            <p align='justify'>O sistema é integrado por sete módulos:</p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Ciclo geral do planejamento: apresenta todos os instrumentos de planejamento da SES-DF;
            </p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Metas e Indicadores: apresenta as pactuações, monitoramento e resultados com análise detalhada;
            </p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Programação Anual de Saúde - PAS: acompanha a execução das ações;
            </p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Execução Orçamentária - LOA: apresenta a programação e detalhamento das despesas, considerando a disponibilidade financeira;
            </p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Acompanhamento Governamental - Etapa orçamentária: acompanha a produção e o recurso orçamentário;
            </p>
            <p align='justify'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; •	Relatórios: contextualização das informações e resultados das pactuações e subsidiar as prestações de contas do SUS-DF.
            </p>            
                Os módulos integram as diversas áreas da secretaria que compartilham as informações do ciclo do planejamento, ampliando a compreensão dos macroprocessos, dos finalísticos até os de sustentação, e análise dos resultados.
            <p align='justify'>
                <br />
                <h6>
                Fonte: DIPLAN/COPLAN/SUPLANS/SES. Manual de Planejamento, Orçamento, Monitoramento e Avaliação da SES-DF. Brasília, DF, 2018, 69.
                </h6>
            </p>                              
        </div>          
    </div><br />
</div>
<?php
rodape($dbcon);
?>