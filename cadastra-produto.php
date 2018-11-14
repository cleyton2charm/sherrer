<!DOCTYPE html>
  <html>
    <head>
      <script src="https://www.gstatic.com/firebasejs/5.3.1/firebase.js"></script>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
      <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" /> 
    </head>
    <body> 
      <div class="container">   
        <div class="row">
          <form class="col s12">
            <div class="row">  
              <div class="input-field col s6">
                <input placeholder="Ex: Plataformas Metálicas" id="nome" type="text" class="validate">
                <label>Nome do produto</label>
              </div>
              <div class="file-field input-field col s6">
                <div class="btn">
                  <span>Foto</span>
                  <input type="file" id="imagem">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea placeholder="Ex: Produto revestido de metal com interior do madeira compensada" id="descricao" class="materialize-textarea"></textarea>
                <label>Descrição do produto</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <input placeholder="Ex: 50" id="quantidade" type="text" class="validate">
                <label>Quantidade do produto</label>
              </div>
              <div class="input-field col s6">
                <input id="valor" type="text" placeholder="Ex: 20,00">
                <label>Valor do produto</label>
              </div>
              <div class="input-field col s6">
                <div class="switch">
                  <label>
                    Desabilitar
                    <input id="situacao" type="checkbox" checked>
                    <span class="lever"></span>
                    Habilitar
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="button" onclick="cadastrar()" name="action">Cadastrar
                <i class="material-icons right">send</i>
                </button>
              </div>  
            </div>      
          </form>
        </div>
        <div class="row" id="cards">
          <a id="abremodal" class="btn modal-trigger abremodal" style="display: none">teste</a>
        </div>
        <div class="row" id="modals">
          <div id="1" class="modal classemodal">
            <div class="modal-content">
              <h4>Nome</h4>
              <p>Texto</p>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
            </div>
          </div>
        </div>        
      </div>
      <!-- Compiled and minified JavaScript -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="js/app.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
    </body>
  </html>