<!doctype html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" /> 
    <title>Finalização</title>
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
      var user = '<?=$_GET['id_cliente']?>';
      var idPedido = '<?=$_GET['id_pedido']?>'; 
      var idTransacao = '<?=$_GET['transaction_id']?>'; 
      var bancodedados = firebase.database().ref("usuario/"+user);
      //console.log(user);
      bancodedados.once('value', snapshot => {
        if(snapshot.exists()) {
          //console.log(snapshot.val().email+snapshot.val().nome+idPedido);
          document.getElementById("nome_cliente").innerHTML=snapshot.val().nome;
          document.getElementById("email_cliente").innerHTML=snapshot.val().email;
          document.getElementById("pedido_cliente").innerHTML=idPedido;
          return true;
        }else{
          console.log("User not exist");
          return true;
        }
      });
      var bancodedados = firebase.database().ref("usuario/"+user+"/pedido/"+idPedido);
      bancodedados.once('value', snapshot => {
        if(snapshot.exists()) {
          //console.log(snapshot.val().entrega+snapshot.val().retirada+idPedido);
          document.getElementById("entrega_cliente").innerHTML=snapshot.val().entrega;
          document.getElementById("retirada_cliente").innerHTML=snapshot.val().retirada;
          insereCodPS(idTransacao);
          return true;
        }else{
          console.log("User not exist");
          return true;
        }
      });
      function insereCodPS(obj){        
        firebase.database().ref("usuario/"+user+"/pedido/"+idPedido).update({  
          situacao:'2',
          status:'2',
          codpagseguro:obj
        },function(error) {
            if(error) {
              console.log("Erro ao cadastrar código do pagseguro: "+error);
            } else {
              console.log("Código do pagseguro cadastrado com sucesso.");
            }
        });    
      };
    </script>
  </head>
  <body>
    <nav class="white" role="navigation">       
      <div class="nav-wrapper container">
        <a id="logo-container" href="#" class="brand-logo" style="padding-top:7px "><img src="img/logo.png" width="100" height="40" /></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="#">Whatsapp (21) 99963-4039</a></li>
          <li id="btncarrinhomenu" style="display:none"><a href="#"><span id="badgecarrinhomenu" class="new badge"></span></a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <div class="section">
        <div class="row">
          <div class="card-panel">
            <h1 class="flow-text">Olá <strong id="nome_cliente"></strong>!</h1>
            <p>
              <span class="black-text">
                o pagamento efetuado com sucesso. Enviamos um email para sua conta <strong id="email_cliente"></strong>, com os dados da locação, verifique!
              </span>
            </p>
            <p>
              <span class="black-text">
                O código do seu pedido é: <strong id="pedido_cliente"></strong><br/> O código do pagseguro é: <strong><?=$_GET["transaction_id"]?></strong>.<br>
                Seu comprovante de serviço será emitido e enviado junto a sua entrega, que será realizada no dia <strong id="entrega_cliente"></strong> até às 11h.
                A nota fiscal será enviada no data da retirada no dia <strong id="retirada_cliente"></strong>. 
              </span>
            </p>
            <p>
              <span class="black-text">
                Para mais informações entre em contato: (21)99963-4039 Whatsapp 24h.
              </span>
            </p>
            <p>
              <a href="index-teste.php" class="btn waves-effect waves-light geen right-align">Voltar para Loja</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
      var clientId = '61673060512-b3vkgp1kv0fjl6pdd06voco1smgr7b6j.apps.googleusercontent.com';
      var apiKey = 'AIzaSyCXTe1xqBLGpycnqaSK7L7Ld-ogDO67VRg';
      var scopes = 'https://mail.google.com/';
      function handleClientLoad() {
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth, 1);
      }
      function checkAuth() {
        gapi.auth.authorize({
          client_id: clientId,
          scope: scopes,
          immediate: true
        }, handleAuthResult);
      }
      function handleAuthClick() {
        gapi.auth.authorize({
          client_id: clientId,
          scope: scopes,
          immediate: false
        }, handleAuthResult);
        return false;
      }
      function handleAuthResult(authResult) {
        if(authResult && !authResult.error) {            
          loadGmailApi();
        } else {
          handleAuthClick();
        }
      }
      function sendEmails(){
        function getDataFormat(){
            d = new Date();
            locale = "en-us",
                date =  d.toLocaleString(locale, {weekday: 'short'})+", "+d.getDate()+" "+d.toLocaleString(locale, { month: 'short'})+" "+ d.getFullYear();
            date+=  " "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()+" "+new Date(d.getTime() + (d.getTimezoneOffset() * 60000)).toString().split(" ")[5].split("T")[1];
            return d;
        }
        //RFC 5322 formatted String
        //http://wesmorgan.blogspot.com.br/2012/07/understanding-email-headers-part-ii.html
        email = 'Subject: Email de Teste1 \r\n';
        email += 'To: tom.soarez@gmail.com \r\n';
        email += 'From: claytonsoares1985@gmail.com \r\n';
        email += 'Date: '+getDataFormat()+'\r\n';
        email += '\Message-ID: \<1234@gmail.com\> \r\n';
        email += 'Isso é um teste! <?=$_GET["transaction_id"]?> \r\n';
        //var base64EncodedEmail = Base64.encodeURI(email);
        var request = gapi.client.gmail.users.messages.send({
          'userId': 'me',
          'resource': {
              'raw': window.btoa(email).replace(/\+/g, '-').replace(/\//g, '_')
          }
        });
        request.execute(function(resp) {
            console.log(resp)
        });
      }    
      function loadGmailApi() {
        gapi.client.load('gmail', 'v1', sendEmails);
      }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
  </body>
</html>