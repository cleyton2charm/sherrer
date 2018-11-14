<?php
header('Access-Control-Allow-Origin: *');
//header("Content-type: text/html; charset=iso-8859-1");
?>
<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
      <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
      <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase.js"></script>
      <script> 
        // Initialize Firebase
        var config = {
          apiKey: "AIzaSyALz4KmbCwiyjD2kkirCq5AOeoo_x9xA1I",
          authDomain: "sherrer-b43e8.firebaseapp.com",
          databaseURL: "https://sherrer-b43e8.firebaseio.com",
          projectId: "sherrer-b43e8",
          storageBucket: "sherrer-b43e8.appspot.com",
          messagingSenderId: "864938110565"
        };
        firebase.initializeApp(config);
      </script>
      <script src="js/funcoes.js"></script>
      <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" /> 
      <style>
        .wrap {
          /*Ajuste a largura e altura desejadas aqui*/
          width: 100%;
          height: 350px;
          position: relative;
          /*isto fará o elemento video e o .container se adaptarem ao .wrap*/
        }
        .wrap .bg-video {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1000; /*apenas um -1 é necessário quando se trabalha com relative + absolute, sendo pai e filho*/
            width: 100%;
            height: 100%;
            overflow: hidden; /* evita do video passar a altura desejada do .wrap */
        }
        .wrap .bg-video video {
            width: 100%;
        }
        .wrap .container{
          position: relative;
          z-index: 1;
          overflow: hidden; /* evita do video passar a altura desejada do .wrap */
        }
      </style>      
    </head>
    <body>
      <ul id="slide-out" class="sidenav" style="min-width: 40%">
        <div class="row">
          <div class="col s12 m12 l12">
            <ul id="itemcarrinho" class="collection with-header">
              <li class="collection-header"><h3 class="flow-text"><!--<i class="material-icons">shopping_cart</i>--> Meu Pedido<span id="qntditens" class="badge"></span></a></h3></li>
              
            </ul>    
          </div>
          <div class="col s12 m12 l12">
            <ul class="collapsible">
              <!--<li class="collapsible-header"><h3 class="flow-text">Resumo da compra</h3></li>-->
              <li>
                <div class="collapsible-header">
                  <i class="material-icons">attach_money</i>Subtotal
                  <span id="subtotal" class="badge"></span></div>
                  <input id="hiddenvalorsubtotal" name="hiddenvalorsubtotal" value="0" type="hidden" />
              </li>
              <li>
                <div id="targetperiodo" class="collapsible-header">
                  <i class="material-icons">date_range</i>Periodo
                  <span style="width:50%" id="btnbadgecalcularperiodo" class="new badge truncate" data-badge-caption=" ">calcular</span>
                  <span id="badgevalorperiodo" style="display:none; " class="badge" data-badge-caption=" "></span>
                  <input id="hiddenvalorperiodo" name="hiddenvalorperiodo" value="0" type="hidden" />
                </div>
                <div class="collapsible-body">
                  <div class="row s12 m12 l12">
                    <div class="input-field col s5 m5 l5">
                      <i class="material-icons prefix">today</i>
                      <label for="entrega">Dia da Entrega</label>
                      <input id="entrega" name="entrega" placeholder="Selecione a data de entrega" type="text" class="datepicker">
                      <!--<span class="helper-text" data-error="Endereço não encontrado" data-success="Endereço encontrado">Selecione a entrega</span>-->  
                    </div>
                    <div class="input-field col s5 m5 l5">
                      <i class="material-icons prefix">forward</i>
                      <label for="retirada">Dia da Retirada</label>
                      <input id="retirada" name="retirada" placeholder="Selecione a data de retirada" type="text" class="datepicker">
                      <!--<span class="helper-text" data-error="Endereço não encontrado" data-success="Endereço encontrado">Selecione a retirada</span>-->
                    </div>
                    <div class="input-field col s2 m2 l2">
                      <a class="waves-effect waves-light btn-small" id="closecollapsible2">OK</a>  
                    </div>                              
                  </div>  
                </div>
              </li>
              <li>
                <div id="targetfrete" class="collapsible-header">
                  <i class="material-icons">local_shipping</i>Frete
                  <span style="width:50%" id="btnbadgecalcular" class="new badge truncate" data-badge-caption=" ">calcular</span>
                  <span id="badgevalorfrete" style="display:none; " class="badge" data-badge-caption=" "></span>
                  <input id="hiddenvalorfrete" name="hiddenvalorfrete" value="0" type="hidden" />
                  <input id="hiddenfrete" name="hiddenfrete" type="hidden" /> 
                </div>
                <div class="collapsible-body">
                  <p> 
                    <div class="input-field col s9 m9 l9">
                      <input id="frete" type="text" class="validate">
                      <label for="frete">Digite o CEP ou ENDEREÇO</label>
                      <span id="enderecoachado" class="helper-text" data-error="Endereço não encontrado" data-success="Endereço encontrado"></span>
                    </div>
                    <div class="input-field col s3 m3 l3">
                      <a class="waves-effect waves-light btn-small" id="closecollapsible">OK</a>
                    </div>
                  </p>
                </div>
              </li>
              <!--
              <li>
                <div class="collapsible-header">
                  <i class="material-icons">monetization_on</i>Valor Total
                  <span id="valortotal" class="badge"></span></div>
              </li>
              -->
            </ul>
          </div> 
          <div class="col s12 m12 l12">
            <ul class="collection with-header">
              <li class="collection-header"><h3 class="flow-text">
                <!--<i class="material-icons">monetization_on</i>--> Valor Total
                <span id="valortotal" class="badge"></span></div></h3>
                <input id="hiddenvalortotal" name="hiddenvalortotal" value="0" type="hidden" />
              </li>
              <li class="collection-header">
                <a id="chamadadoscliente" class="waves-effect waves-light btn-large">Continuar<i class="material-icons right">send</i></a>
                <a class="continuarcomprando" href="#"><<< Continuar comprando</a>  
              </li>
            </ul>          
          </div>
        </div>            
      </ul>    
        <!-- Form with placeholder -->
        <div id="dadoscliente" class="modal col s12 m12 l12">
          <div class="card-panel" style="margin:10px 10px;">
            <!--<h5 class="flow-text">Dados da entrega</h5>-->
            <div  class="row">
              <form class="col s12">
                <div class="input-field col s8">
                  <input id="nome" name="nome" placeholder="Digite seu Nome completo" type="text" data-length="10">
                  <label for="input_text">*Nome completo do contratante</label>
                </div>
                <div class="input-field col s4">
                  <input id="cpf" name="cpf" placeholder="Digite seu CPF" type="text" data-length="10">
                  <label for="input_text">*CPF</label>
                </div>
                <div class="input-field col s6">  
                  <input id="email" name="email" placeholder="Digite seu E-mail" type="text" data-length="10">
                  <label for="input_text">*E-mail</label>
                </div>
                <div class="input-field col s4 m2 l2"> 
                    <input name="ddd" id="ddd" type="tel" value="21" placeholder="DDD" class="validate">
                    <label for="ddd">*DDD</label>
                </div>
                <div class="input-field col s8 m4 l4">
                    <input name="telefone" id="telefone" placeholder="Digite seu Telefone" type="tel" class="validate">
                    <label for="telefone">*Telefone</label>
                </div>
                <div class="input-field col s6">
                  <input id="endereco" style="color: #000" name="endereco" placeholder="Endereço" type="text" data-length="10" disabled>
                  <label for="endereco">Endereço</label>
                </div>
                <div class="input-field col s2">  
                  <input id="numero" style="color: #000" name="nunero" placeholder="Número" type="text" disabled>
                  <label for="numero">Número</label>
                </div>
                <div class="input-field col s4">  
                  <input id="complemento" style="color: #000" name="complemento" placeholder="Complemento" type="text" data-length="10">
                  <label for="complemento">Complemento</label>
                </div>
                <div class="input-field col s6">  
                  <input id="bairro" style="color: #000" name="bairro" type="text" placeholder="Bairro" data-length="10" disabled>
                  <label for="bairro">Bairro</label>
                </div>
                <div class="input-field col s4">  
                  <input id="cidade" style="color: #000" name="cidade" type="text" placeholder="Cidade" data-length="10" disabled>
                  <input id="cep" name="cep" type="hidden"  data-length="10" disabled>
                  <label for="cidade">Cidade</label>
                </div>
                <div class="input-field col s2">  
                  <input id="estado" style="color: #000" name="estado" type="text" placeholder="Estado" data-length="10" disabled>
                  <label for="cidade">Estado</label>
                </div>
                <div class="input-field col s6">
                  <a id="btnPedidoWhats" class="modal-close waves-effect waves-light btn right"><i class="material-icons right"><img width="20px" height="20px" src="https://criacaode.site/wp-content/uploads/2017/06/botao-whatsapp-no-seu-site-mercadobinario.png" /></i>pedir pelo whatsapp</a> 
                </div> 
                <div class="input-field col s6">
                  <a id="btnPedidoPagseguro" class="waves-effect waves-light btn right"><i class="material-icons left">shopping_cart</i>finalizar no pagseguro</a>
                </div>  
              </form>
            </div>
          </div>
        </div>
      <!--
      <nav class="white" role="navigation">       
        <div class="nav-wrapper container-fluid">
          <a id="logo-container" href="#" class="brand-logo" style="padding-top:7px; padding-left:2%;">
            <img src="img/logo.png" width="100" height="40" />
          </a>
          <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          
          <ul class="right hide-on-med-and-down">
            <li><a href="#">Whatsapp (21) 99963-4039</a></li>
            <li id="btncarrinhomenu" style="display:none"><a href="#"><span id="badgecarrinhomenu" class="new badge"></span></a></li>
          </ul>
        </div>
      </nav>
      <ul class="sidenav" id="mobile-demo">
        <li><a href="sass.html">Sass</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">Javascript</a></li>
        <li><a href="mobile.html">Mobile</a></li>
      </ul>
      <nav>
        <div class="nav-wrapper container">
          <form>
            <div class="input-field">
              <input id="search" type="search" class="autocomplete" required>
              <label class="label-icon" for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form>
        </div>
      </nav>
      -->
      
      <nav class="white">
        <div class="nav-wrapper">
          <ul class="left" style="width:70%">
            <li>
            <a href="#" class="brand-logo" style="padding-top:7px; padding-left:2%;"><img src="img/logo.png" width="100" height="40" /></a>
            </li>
            <li style="padding-top: 0px; margin-left:20%; width:70%;">    
              <div class="center row">
                <div class="col" >
                  <div class="row" id="topbarsearch">
                    <div class="input-field">
                      <input type="text" style="background-color:#f7f7f7; border-radius:3px; border:1px solid #ccc; width:600px;  height:40px; padding-left:10px;" id="search" placeholder="buscar por Andaimes, escoras , escadas..." id="autocomplete" class="autocomplete">
                    </div>  
                  </div>
                </div>
              </div>          
            </li> 
          </ul>    
          <ul class="hide-on-med-and-down right" style="width:30%">               
            <li><a href="#">Whatsapp (21) 99963-4039</a></li>
            <li id="btncarrinhomenu" style="display:block"><a href="#"><span id="badgecarrinhomenu" data-badge-caption="Carrinho (0)" class="new badge deep-orange darken-1"></span></a></li>          
          </ul>
        </div>
      </nav>
      
      <div class="container-fluid wrap">
        <div class="bg-video">
          <video muted autoplay loop >
            <source src="img/andaimes-novo.mp4" type="video/mp4">
          </video>
        </div>
        <div class="container">
          <div class="caption center-align">
            <h3 class="light white-text text-lighten-3">SELECIONE O EQUIPAMENTO E OBTENHA O ORÇAMENTO</h3>
            <!--
            <p class="flow-text light white-text text-lighten-3">Locadora de Equipamentos para Construção Civil</p>
            -->
            <br/>
            <br/>
            <a href="#" class="white-text pulse"><i class="material-icons">arrow_drop_down</i></a>
            <!--
            <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Whatsapp (21) 99963-4039</a>
          -->
          </div>  
        </div>  
      </div>  
      <div class="container-fluid">
        
        <div class="row">  
          <div class="section">
            <h3 class="flow-text black-text center-align">Faça seu orçamento online personalizado
              <i class="tiny material-icons">arrow_drop_down</i></h3>
          </div>
          
          <div class="section">    
            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">add_shopping_cart</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      <strong>1º PASSO</strong><br/>
                      Encontre o produto desejado e adicione a quantidade desejada ao seu carrinho 
                    </span>
                  </div>
                </div>
              </div>
            </div>  
            
            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">verified_user</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      <strong>2º PASSO</strong><br/>
                      Informe o período de locação e endereço de entrega para receber seu orçamento
                    </span>
                  </div>
                </div>
              </div>
            </div>  

            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">local_shipping</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      <strong>3º PASSO</strong><br/>
                      Preencha seus dados e confirme seu endereço para receber sua entrega
                    </span>
                  </div>
                </div>
              </div>
            </div>  
          </div>      
        </div>
          
        <div class="row">    
          <div class="section grey lighten-3">
            <h3 class="flow-text black-text center-align">O que está procurando? <i class="tiny material-icons">arrow_drop_down</i></h3>
          </div>
          <div class="section grey lighten-3">
            <div class="row" id="cards">
              <a id="abremodal" class="btn modal-trigger abremodal" style="display:none">teste</a>
            </div>
            <div class="row" id="modals">
              <div id="1" class="modal modal-fixed-footer classemodal">
              </div>  
            </div> 
          </div>  
        </div>

        <div class="row">  
          <div class="section">
            <h3 class="flow-text black-text center-align">Como Finalizar meu pedido?
              <i class="tiny material-icons">arrow_drop_down</i></h3>
          </div>
          
          <div class="section">    
            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">payment</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      Encontre o produto desejado e adicione a quantidade desejada ao seu carrinho 
                    </span>
                  </div>
                </div>
              </div>
            </div>  
            
            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">chat</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      Informe o período de locação e endereço de entrega para receber seu orçamento
                    </span>
                  </div>
                </div>
              </div>
            </div>  

            <div class="col s12 m4">
              <div class="card-panel grey lighten-5 z-depth-1" style="border-left: 4px solid #950000">
                <div class="row valign-wrapper">
                  <div class="col s2">
                    <i class="material-icons">phone</i>
                  </div>
                  <div class="col s10">
                    <span class="black-text">
                      Preencha seus dados e confirme seu endereço para receber sua entrega
                    </span>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </div>
      </div>

      <footer class="page-footer white">
        <!--
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5 class="black-text">Company Bio</h5>
              <p class="black-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>
            </div>
            <div class="col l3 s12">
              <h5 class="black-text">Settings</h5>
              <ul>
                <li><a class="black-text" href="#!">Link 1</a></li>
                <li><a class="black-text" href="#!">Link 2</a></li>
                <li><a class="black-text" href="#!">Link 3</a></li>
                <li><a class="black-text" href="#!">Link 4</a></li>
              </ul>
            </div>
            <div class="col l3 s12">
              <h5 class="black-text">Connect</h5>
              <ul>
                <li><a class="black-text" href="#!">Link 1</a></li>
                <li><a class="black-text" href="#!">Link 2</a></li>
                <li><a class="black-text" href="#!">Link 3</a></li>
                <li><a class="black-text" href="#!">Link 4</a></li>
              </ul>
            </div>
          </div>
        </div>
        -->
        <div class="footer-copyright" style="border-top: 1px solid #ccc">
          <div class="container">
            <a class="black-text center-align" href="http://materializecss.com">
            ©2018 Sherrer Montagens e Serviços Ltda.
CNPJ n.º 19.68.820/0001-43 | Rua feira nova nº 8 - Realengo, Rio de Janeiro/RJ
            </a>
          </div>
        </div>
      </footer>
      <!-- Compiled and minified JavaScript -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
      <script>
        var arrayObjetoProduto = [];
        var arrayAutoComplete = {};
        $(document).ready(function(){
          $("#search").focus();
          $('#cpf').mask('000.000.000-00', {reverse: true});
          var maskBehavior = function (val) {
           return val.replace(/\D/g, '').length === 9 ? '00000-0000' : '0000-00009';
          },
          options = {onKeyPress: function(val, e, field, options) {
           field.mask(maskBehavior.apply({}, arguments), options);
           }
          };
          $('#telefone').mask(maskBehavior, options);
          //$('input#nome, input#cpf, input#email, input#ddd1, input#telefone1, input#ddd2, input#telefone2').characterCounter(); 
          $('.slider').slider({
            indicators: false
          });
          $('.slidermodal').slider({
            height:280,
          });
          $('.sidenav').sidenav({
            edge:'right',
          });
          $('.parallax').parallax();
          $('.modal').modal();
          $('select').formSelect();
          $('.materialboxed').materialbox();
          $('.collapsible').collapsible();
          $("#closecollapsible" ).on( "click", function() {
            $("#targetfrete").trigger('click');
            //distanceMatrix($('#hiddenfrete').val());
            //alert($(this).parents(".collapsible-header"));
            geocode2();
            atualizaValor();
          });
          $("#btncarrinhomenu" ).on( "click", function() {
            $("#slide-out ").sidenav('open');
          });
          $(".continuarcomprando").on( "click", function() {
            $("#slide-out ").sidenav('close');
          });
          $("#closecollapsible2" ).on( "click", function() {
            $("#targetperiodo").trigger('click');
            periodo();
          });
          $('.datepicker').datepicker({
            i18n: {  
              months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
              monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
              weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
              weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
              weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
              today: 'Hoje',
              clear: 'Limpar',
              cancel: 'Sair',
              done: 'Confirmar',
              labelMonthNext: 'Próximo mês',
              labelMonthPrev: 'Mês anterior',
              labelMonthSelect: 'Selecione um mês',
              labelYearSelect: 'Selecione um ano',
              selectMonths: true, 
              selectYears: 15,
            },
            format: 'dd mmmm, yyyy',
            onSelect: function(){
              periodo();
            },
            onClose: function(){
              periodo();
            },
            container: 'body',
            disableWeekends: true,
            minDate: new Date(), 
          });
          $("#btnPedidoWhats").on( "click", function() {
            var enderecofrete = $("#hiddenfrete").val();
            var frete = $("#hiddenvalorfrete").val();
            var periodo = $("#hiddenvalorperiodo").val();
            var entrega = $("#entrega").val();
            var retirada = $("#retirada").val();
            var txtvalortotal = $("#valortotal").text();
            var nome = $("#nome").val();
            var cpf = $("#cpf").val();
            var ddd = $("#ddd").val();
            var telefone = $("#telefone").val();
            var email = $("#email").val();
            var a = [];
            for ( var i = 0; i < $(".title").length; i++ ) {
              a.push( $(".title")[i].innerHTML );
            }
            var txtitens = a.join(" e ");
            var erro = 0;
            //alert(frete+periodo+enderecofrete+txtitens);
            //alert($(".title").length);
            var qntdpedido = $(".title").length;
            var erro = 0;
            var email = $("#email").val();
            var validaEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if($("#nome").val().indexOf(" ") == -1 || $("#nome").val().length>60){
              erro = 1;
              M.toast({html: 'Digite um Nome Completo válido'});
            }
            if(validaEmail.test(email)==false || email.length>60){
              erro = 1;
              M.toast({html: 'Digite um E-mail válido'});
            }
            if($("#cpf").val().length<14){
              erro = 1;
              M.toast({html: 'Digite um CPF válido'});
            }
            if($("#telefone").val().length<9 || $("#telefone").val().length>10){
              erro = 1;
              M.toast({html: 'Digite um Telefone válido'});
            }
            if(frete==0 && enderecofrete==""){
              //alert(frete+periodo);
              erro=1;
              M.toast({html: 'Calcule o frete'});
            }
            if(periodo==0 && entrega=="" || retirada==""){
              //alert("Periodo Nulo");
              erro=1;
              M.toast({html: 'Calcule o período'});
            }
            if(erro==0){
              window.open("https://api.whatsapp.com/send?phone=5521970014995&text=Solicito "+qntdpedido+" Iten(s): "+txtitens+" | Endereço: "+enderecofrete+" | Entrega: "+entrega+" | Retirada: "+retirada+" | Valor: "+txtvalortotal+" | Nome: "+nome+" | CPF: "+cpf+" | Telefone: ("+ddd+")"+telefone+" | Email: "+email);
            }else{
              //alert("Erro");
              return false;
            }
          });
          $("#btnPedidoPagseguro").on( "click", function() {
            var enderecofrete = $("#hiddenfrete").val();
            var frete = $("#hiddenvalorfrete").val();
            var periodo = $("#hiddenvalorperiodo").val();
            var entrega = $("#entrega").val();
            var retirada = $("#retirada").val();
            var txtvalortotal = $("#valortotal").text();
            var a = [];
            for ( var i = 0; i < $(".title").length; i++ ) {
              a.push( $(".title")[i].innerHTML );
            }
            var txtitens = a.join(" e ");
            var erro = 0;
            //alert(frete+periodo+enderecofrete+txtitens);
            //alert($(".title").length);
            var qntdpedido = $(".title").length;
            if(frete==0 && enderecofrete==""){
              //alert(frete+periodo);
              erro=1;
              M.toast({html: 'Calcule o frete'});
            }
            if(periodo==0 && entrega=="" || retirada==""){
              //alert("Periodo Nulo");
              erro=1;
              M.toast({html: 'Calcule o período'});
            }
            if(erro==0){
              lightboxpagseguro();
            }else{
              //alert("Erro");
              return false;
            }
          });
          $("#chamadadoscliente").on( "click", function() { 
            var enderecofrete = $("#hiddenfrete").val();
            var verificacidade = enderecofrete.split(',');
            //alert(verificacidade[2]);
            var frete = $("#hiddenvalorfrete").val();
            var periodo = $("#hiddenvalorperiodo").val();
            var entrega = $("#entrega").val();
            var retirada = $("#retirada").val();
            var erro = 0;
            var cidade = verificacidade[2];
            switch($.trim(cidade)){
              case "Rio de Janeiro - RJ":
                erro = 0;
                break;
              case "Duque de Caxias - RJ":
                erro = 0;
                break;
              case "Nova Iguaçu - RJ":
                erro = 0;
                break;
              case "Belford Roxo - RJ":
                erro = 0;
                break;
              case "São João de Meriti - RJ":
                erro = 0;
                break;
              case "Itaguaí - RJ":
                erro = 0;
                break;
              case "Niterói - RJ":
                erro = 0;
                break;
              case "São Gonçalo - RJ":
                erro = 0;
                break;
              case "Nilópolis - RJ":
                erro = 0;
                break;
              case "Queimados - RJ":
                erro = 0;
                break;          
              default:
                M.toast({html: 'No momento não há atendimento para sua região'});
                erro=1;
                //return false;
            }
            if(frete==0 && enderecofrete==""){
              //alert(frete+periodo);
              erro=1;
              M.toast({html: 'Calcule o frete'});
            }
            if(periodo==0 && entrega=="" || retirada==""){
              //alert("Periodo Nulo");
              erro=1;
              M.toast({html: 'Calcule o período'});
            }
            if(erro==0){
              $("#slide-out").sidenav('close');
              $("#dadoscliente").modal('open');
            }else{
              //alert("Erro");
              return false;
            }
          });

          var bdproduto = firebase.database().ref().child('produto');
          var textoCard;
          var textoModal;
          //var arrayObjetoProduto = [];
          bdproduto.on('child_added', function(snapshot) {
            arrayObjetoProduto.push({key: snapshot.key.replace(/-/g, ""), nome: snapshot.child("nome").val(), imagem: snapshot.child("imagem").val(), descricao: snapshot.child("descricao").val(), quantidade: snapshot.child("quantidade").val(), valor: snapshot.child("valor").val()});
            arrayAutoComplete[snapshot.child("nome").val()+" ("+snapshot.key.replace(/-/g, '')+")"] = snapshot.child("imagem").val();
            var card = criaCard(snapshot.key.replace(/-/g, ""), snapshot.child("nome").val(), snapshot.child("imagem").val(), snapshot.child("descricao").val(), snapshot.child("valor").val());
          });  
          function criaCard(key, name, image, desc, price) {
            textoCard = '<div class="col s12 m3"><div class="card hoverable"><div class="card-image"><img src="'+image+'" width="200px" height="150px" ><a href="#'+key+'" class="btn-floating halfway-fab waves-effect waves-light red modal-trigger"><i class="material-icons">shopping_cart</i></a></div><div class="card-content"><span class="card-title activator grey-text text-darken-2">'+name+'</span><p><a href="#'+key+'" class="black-text text-darken-5 modal-trigger"><strong>A partir de R$ '+price+'<strong></a></p></div></div></div>';
            $("#cards").append(textoCard);
            //$("#modals").append(textoModal);
          }
          $(window).on('hashchange', function(e){
            var hash = window.location.hash.replace(/#/g, "");
            if(hash=="!"){
              console.log("entrou no gargalo!");
            }else{
              $(".abremodal").attr({"id":"#"+hash});
              $(".classemodal").attr({"id":hash});
              for(var i = 0; i < arrayObjetoProduto.length; i++){
                if(hash==arrayObjetoProduto[i].key){
                  var option = "";
                  for(var q = 1; q <= arrayObjetoProduto[i].quantidade; q++){
                    //$("#selectquantidade").append("<option value='"+q+"'>"+q+"</option>");
                    option +="<option value='"+q+"'>"+q+"</option>";
                    //console.log(q);
                  }
                  $(".classemodal").html('<div class="modal-content"><div class="row"><div class="col s12 m5 l7"><div class="slider slidermodal"><ul class="slides"><li><img src="'+arrayObjetoProduto[i].imagem+'"></li></ul></div></div><div class="col s12 m7 l5"><h3>'+arrayObjetoProduto[i].nome+'</h3><p class="brown-text text-lighten-3">'+arrayObjetoProduto[i].descricao+'</p><h4>R$'+arrayObjetoProduto[i].valor+'</h4><div class="input-field inline col s12 m12 l12"><select id="selectquantidade" name="andaime">'+option+'</select><label>Selecione a Quantidade</label></div></div></div></div><div class="modal-footer"><div class="left"><a href="#!" class="modal-action modal-close waves-effect waves-teal btn-flat white red-text text-lighten-2 lighten-1 left-align">sair (x)</a></div><div class="right"><a onclick="addProdutos('+arrayObjetoProduto[i].key+')" class="btn waves-effect waves-light geen right-align">FAZER ORÇARMENTO</a></div></div>');
                  //console.log('Tem no Array: '+arrayObjetoProduto[i].nome+' - Key:'+arrayObjetoProduto[i].key+' - Hash:'+hash);
                  $("#"+hash).trigger('click');
                  //console.log(hash);
                  $('.modal').modal();
                  $("#"+hash).modal('open');
                  $('select').formSelect();
                  $('.slider').slider();
                  $('.slidermodal').slider({
                    height:280,
                  });

                }else{
                  //console.log('Não Tem no Array: '+arrayObjetoProduto[i].nome);
                }
              }  
            }
          });

          $('.autocomplete').autocomplete({
            data: arrayAutoComplete,
            limit: 5
          }).on('change', function name(argumento) {
            var getsearch = this.value;
            var splitsearch = getsearch.split("(");
            var getid = splitsearch[1].replace(')', "");
            $(".abremodal").attr({"id":"#"+getid});
            $(".classemodal").attr({"id":getid});
            for(var i = 0; i < arrayObjetoProduto.length; i++){
              if(getid==arrayObjetoProduto[i].key){
                var option = "";
                for(var q = 1; q < arrayObjetoProduto[i].quantidade; q++){
                  //$("#selectquantidade").append("<option value='"+q+"'>"+q+"</option>");
                  option +="<option value='"+q+"'>"+q+"</option>";
                  //console.log(q);
                }
                $(".classemodal").html('<div class="modal-content"><div class="row"><div class="col s12 m5 l7"><div class="slider slidermodal"><ul class="slides"><li><img src="'+arrayObjetoProduto[i].imagem+'"></li></ul></div></div><div class="col s12 m7 l5"><h3>'+arrayObjetoProduto[i].nome+'</h3><p class="brown-text text-lighten-3">'+arrayObjetoProduto[i].descricao+'</p><h4>R$'+arrayObjetoProduto[i].valor+'</h4><div class="input-field inline col s12 m12 l12"><select id="selectquantidade" name="andaime">'+option+'</select><label>Selecione a Quantidade</label></div></div></div></div><div class="modal-footer"><div class="left"><a href="#!" class="modal-action modal-close waves-effect waves-teal btn-flat white red-text text-lighten-2 lighten-1 left-align">sair (x)</a></div><div class="right"><a onclick="addProdutos('+arrayObjetoProduto[i].key+')" class="btn waves-effect waves-light geen right-align">FAZER ORÇARMENTO</a></div></div>');
                //console.log('Tem no Array: '+arrayObjetoProduto[i].nome+' - Key:'+arrayObjetoProduto[i].key+' - Hash:'+hash);
                $("#"+getid).trigger('click');
                //console.log(hash);
                $('.modal').modal();
                $("#"+getid).modal('open');
                $('select').formSelect();
                $('.slider').slider();
                $('.slidermodal').slider({
                  height:280,
                });
              }else{
                //console.log('Não Tem no Array: '+arrayObjetoProduto[i].nome);
              }
            }         
          });
        });

        

        function addProdutos(key){         
          for(var i = 0; i < arrayObjetoProduto.length; i++){
            if($(".classemodal").attr("id")==arrayObjetoProduto[i].key){
              var imagem = arrayObjetoProduto[i].imagem; 
              var titulo = arrayObjetoProduto[i].nome;
              var quantidade = $("#selectquantidade option:selected").val();
              var subtitulo = arrayObjetoProduto[i].descricao;
              //var recebeValor = arrayObjetoProduto[i].valor;
              var recebeValor = parseFloat(quantidade) * parseFloat(arrayObjetoProduto[i].valor);
              var valor = recebeValor.toFixed(2).replace(".",","); 
              var item =
              '<li class="collection-item avatar"><img src="'+imagem+'" alt="" class="circle"><span class="title truncate">('+quantidade+') '+titulo+', '+subtitulo+'</span><p>R$<span class="valor">'+valor+'</span></p><p><a onclick="removeProduto(this)" class="removal">remover</a></p></li>';
              $("#itemcarrinho").append(item);
              $(".classemodal").modal('close');
              //$("#carrinho").modal('open');
              $("#slide-out ").sidenav('open');
              atualizaValor();  
              console.log(quantidade+" - "+valor);
            }else{
              //console.log(key+" "+arrayObjetoProduto[i].key);
            }
          }        
        }
        function removeProduto(obj){
          $(obj).parents("li").remove();
          atualizaValor();
        }
        function atualizaValor(){
          var subtotal = 0;
          var qntdItens = 0;
          var frete = $("#hiddenvalorfrete").val();
          var periodo = $("#hiddenvalorperiodo").val();
          $( ".valor" ).each(function(i) {
            qntdItens += 1;
            var valorItem = $(this).text(); 
            subtotal += parseFloat(valorItem.replace(",","."));
          });
          $("#qntditens").text("("+qntdItens+")");
          $("#btncarrinhomenu").show();
          //$("#badgecarrinhomenu").text("("+qntdItens+")");
          $("#badgecarrinhomenu").text("");
          $("#badgecarrinhomenu").attr("data-badge-caption", "Seu Carrinho ("+qntdItens+")");
          $("#hiddenvalorsubtotal").val(subtotal.toFixed(2));
          $("#subtotal").text("R$ "+subtotal.toFixed(2).replace(".",","));
          console.log("subtotal:"+subtotal+" frete:"+frete+" periodo:"+periodo);
          var valorTotal = parseFloat(subtotal) + parseFloat(frete) + parseFloat(periodo);
          $("#hiddenvalortotal").val(valorTotal.toFixed(2));
          $("#valortotal").text("R$ "+valorTotal.toFixed(2).replace(".",","));
        }     
        var typingTimer; //timer identifier
        var doneTypingInterval = 1000; //time in ms, 1 second for example
        //on keyup, start the countdown
        $('#frete').keyup(function() {
          clearTimeout(typingTimer);
          if ($('#frete').val) {
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
          }
        });
        //user is "finished typing," do something
        function doneTyping() {
          geocode();
        }
        function geocode(){
        // Prevent actual submit
        //e.preventDefault();
        //var location = document.getElementById('location-input').value;
        var location = $('#frete').val(); 
        axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
          params:{
            address:location,
            key:'AIzaSyADoArgfgf0BYq0tcAW4Y1hmyMbtm1Xa10'
          }
        })
        .then(function(response){
          // Log full response
          console.log(response);
          // Formatted Address
          var formattedAddress = response.data.results[0].formatted_address;
          var addressComponent = response.data.results[0].address_components;
          $("#numero").val(addressComponent[0].long_name);
          $("#endereco").val(addressComponent[1].long_name);
          $("#bairro").val(addressComponent[2].long_name);
          $("#cidade").val(addressComponent[3].long_name);
          $("#estado").val(addressComponent[4].short_name);
          $("#pais").val(addressComponent[5].short_name);
          $("#cep").val(("00000000"+addressComponent[6].long_name.replace(/-/g, "")).slice(-8));
          $("#end").children("label").remove();
          $("#enderecoachado").attr("data-success", formattedAddress);
          $("#btnbadgecalcular").attr("data-badge-caption", formattedAddress);
          $("#hiddenfrete").val(formattedAddress);
          $("#btnbadgecalcular").text("");
          //var novoBadge = '<span class="new badge" data-badge-caption="'+formattedAddress+'"></span>';
          //$("#targetfrete").append(novoBadge);
        })
        .catch(function(error){
          $("#enderecoachado").attr("data-error", "Endereço não encontrado");
        });
      }
      function geocode2(){
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
          {
            origins: ['Rua Feira Nova 8 realengo'],
            destinations: [$('#hiddenfrete').val()],
            travelMode: 'DRIVING'
          }, callback);

        function callback(response, status) {
          if (status == 'OK') {
            var origins = response.originAddresses;
            var destinations = response.destinationAddresses;
            for (var i = 0; i < origins.length; i++) {
              var results = response.rows[i].elements;
              for (var j = 0; j < results.length; j++) {
                var element = results[j];
                var distance = element.distance.text;
                var duration = element.duration.text;
                var from = origins[i];
                var to = destinations[j];
              }
            }
          }
          var distanciaTotal = distance.replace(",",".");
          var arrayDistancia = distanciaTotal.split(' ');
          var km = 8;
          var gasolina = 4.79;
          var calculo = parseFloat(arrayDistancia[0]) / parseFloat(km);
          var custo = parseFloat(calculo) * parseFloat(gasolina); 
          var custoTotal = custo.toFixed(2).replace(".",",");
          $("#hiddenvalorfrete").val(custo.toFixed(2));
          $("#badgevalorfrete").text("R$ "+custoTotal);
          $("#badgevalorfrete").css("display", "block");
          atualizaValor();
          //return custoTotal;
        }
      }
      function periodo(){
        var custoValorSubtotal = $("#hiddenvalorsubtotal").val();
        $.ajax({ 
          type: 'POST', 
          url: 'js/ajax-teste-data.php', 
          data: { entrega: $( "#entrega" ).val(), retirada: $( "#retirada" ).val(), valor: custoValorSubtotal},
          dataType: 'json',
          success: function(data){ 
            console.log(data.valor);
            //$("#valor").val(data.valor+",00");
            //$("#diasCorridos").val(data.dias+" Dias Corridos");
            var custoPeriodo = parseFloat(data.valor) - parseFloat(custoValorSubtotal);
            $("#hiddenvalorperiodo").val(custoPeriodo+".00");
            $("#badgevalorperiodo").text("R$ "+custoPeriodo+",00");
            $("#badgevalorperiodo").css("display", "block");
            //$("#enderecoachado").attr("data-success", formattedAddress);
            $("#btnbadgecalcularperiodo").text("");
            $("#btnbadgecalcularperiodo").attr("data-badge-caption", data.dias+" Dias Corridos"); 
          }   
        });
        atualizaValor();   
      }

      function lightboxpagseguro(){
        var itens = [];
        for ( var i = 0; i < $(".title").length; i++ ) {
          itens.push({produto: $(".title")[i].innerHTML.substring(0, 25), valor: $(".valor")[i].innerHTML.replace(",",".")});
        }
        var produtosArray = [];
        for ( var i = 0; i < $(".title").length; i++ ) {
          produtosArray.push({
            id:i,
            produto:$(".title")[i].innerHTML.substring(0, 25),
            descricao:'',
            acessorios:'',
            quantidade:'',
            valor:$(".valor")[i].innerHTML.replace(",","."),
          });
        }
        var arrayprodutos = produtosArray;  
        var erro = 0;
        var txtitens = itens;
        var email = $("#email").val();
        var validaEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
        if($("#nome").val().indexOf(" ") == -1 || $("#nome").val().length>60){
          erro = 1;
          M.toast({html: 'Digite um Nome Completo válido'});
        }
        if(validaEmail.test(email)==false || email.length>60){
          erro = 1;
          M.toast({html: 'Digite um E-mail válido'});
        }
        if($("#cpf").val().length<14){
          erro = 1;
          M.toast({html: 'Digite um CPF válido'});
        }
        if($("#telefone").val().length<9 || $("#telefone").val().length>10){
          erro = 1;
          M.toast({html: 'Digite um Telefone válido'});
        }
        
        if(erro==1){

        }else{  
          var user;
          var idPedido;
          var bancodedados = firebase.database();
          var db = bancodedados.ref("usuario");
          var query = db.orderByChild("cpf").equalTo($("#cpf").val().replace(/[\.-]/g,"")).limitToFirst(1);
          query.once('value', snapshot => {
            if(snapshot.exists()) {
              snapshot.forEach(function(childSnapshot) {
                user = childSnapshot.key;
                return true;  
                //console.log(user+childSnapshot.val().cpf+childSnapshot.val().nome);
              });
              inserePedidoFB(user);
              return true;
            }else{
              insereUsuarioFB();
              return true;
            }
          });
          function insereUsuarioFB(){
            var bancodedados = firebase.database().ref('usuario');
            //var bancodedados = firebase.database().ref('cpf');          
            var idCliente = bancodedados.push({
              nome: $("#nome").val(),
              cpf: $("#cpf").val().replace(/[\.-]/g,""),
              email: email,
              ddd: $("#ddd").val(),
              telefone: $("#telefone").val().replace(/[\.-]/g,""),
              endereco:
              {
                logradouro: $("#endereco").val(),
                numero: $("#numero").val(),
                complemento: $("#complemento").val(),
                bairro: $("#bairro").val(),
                cidade: $("#cidade").val(),
                estado: $("#estado").val(),
                //pais: $("#pais").val(),
                cep: $("#cep").val()
              },
              pedido:'',  
            });  
            console.log(idCliente.key+": Inserimos Cliente");
            inserePedidoFB(idCliente.key);
          }
          function inserePedidoFB(objetoid){        
            var objpedido = firebase.database().ref('usuario/' + objetoid + '/pedido').push();
            objpedido.set({  
              produtos: arrayprodutos,
              enderecodentrega:
              { 
                entlogradouro: $("#endereco").val(),
                entnumero: $("#numero").val(),
                entcomplemento: $("#complemento").val(),
                entbairro: $("#bairro").val(),
                entcidade: $("#cidade").val(),
                entestado: $("#estado").val(),
                //entpais: $("#pais").val(),
                entcep: $("#cep").val()
              },
              entrega: $("#entrega").val(),
              retirada: $("#retirada").val(),
              subtotal:$("#hiddenvalorsubtotal").val(),
              extra: $("#hiddenvalorperiodo").val(),
              frete: $("#hiddenvalorfrete").val(),
              valor: $("#hiddenvalortotal").val(),
              situacao:'1',
              status:'1',
              codpagseguro:''
            });
            user = objetoid;
            idPedido = objpedido.key;
            console.log("Revelado o ID do Pedido do "+objpedido.key+": Inserimos Pedido do Usuario"+user);
          }
          //console.log(chaveCliente);
          var txtcliente = [{nome: $("#nome").val(), cpf: $("#cpf").val().replace(/[\.-]/g,""), email: $("#email").val(), ddd: $("#ddd").val(), telefone: $("#telefone").val().replace(/[\.-]/g,""), periodo: $("#hiddenvalorperiodo").val(), endereco: $("#endereco").val(), numero: $("#numero").val(), complemento: $("#complemento").val(), bairro: $("#bairro").val(), cidade: $("#cidade").val(), estado: $("#estado").val(), pais: $("#pais").val(), cep: $("#cep").val()}];
          $.ajax({ 
            type: 'POST', 
            url: 'js/btnpagseguro.php',
            data: { produto: txtitens, frete: $("#hiddenvalorfrete").val(), periodo: $("#hiddenvalorperiodo").val(), cliente: txtcliente}, 
            dataType: 'json',
            success: function(data){ 
              //Parse the givn XML
              $("#slide-out ").sidenav('close');
              $("#dadoscliente").modal('close');
              var xmlDoc = $.parseXML( data ); 
              var $xml = $(xmlDoc);
              // Find Code Tag
              var codigoPagseguro = $xml.find("code").text();
              PagSeguroLightbox({
                code: codigoPagseguro
                }, {
                success : function(transactionCode) {
                  console.log("success - " + transactionCode);
                  window.location.replace("finalizacao.php?transaction_id="+transactionCode+"&id_cliente="+user+"&id_pedido="+idPedido);
                },
                abort : function() {
                  alert("abort");
                }
              });
            }   
          });
        } 
      }  
    </script>
    <script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMXICDxVwaJlDZ_dYidRbRM_fwdt51dcg&callback=geocode2">
    </script>
    <script type="text/javascript"
src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
    </script>
    <script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js">
    </script>
    </body>
  </html>