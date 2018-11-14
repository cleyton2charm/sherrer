<!DOCTYPE html>
<html>
  <head>
    <title>Gmail API Quickstart</title>
    <meta charset="utf-8" />
  </head>
  <body>
    <p>Gmail API Quickstart</p>

    <!--Add buttons to initiate auth sequence and sign out-->
    <button id="authorize_button" style="display: none;">Authorize</button>
    <button id="signout_button" style="display: none;">Sign Out</button>

    <pre id="content"></pre>

    <script type="text/javascript">
      // Client ID and API key from the Developer Console
      
      var CLIENT_ID = '61673060512-b3vkgp1kv0fjl6pdd06voco1smgr7b6j.apps.googleusercontent.com';

      // Array of API discovery doc URLs for APIs used by the quickstart
      var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/gmail/v1/rest"];

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      var SCOPES = 'https://mail.google.com/';

      var authorizeButton = document.getElementById('authorize_button');
      var signoutButton = document.getElementById('signout_button');

      /**
       *  On load, called to load the auth2 library and API client library.
       */
      function handleClientLoad() {
        gapi.load('client:auth2', initClient);
      }

      /**
       *  Initializes the API client library and sets up sign-in state
       *  listeners.
       */
      function initClient() {
        gapi.client.init({
          discoveryDocs: DISCOVERY_DOCS,
          clientId: CLIENT_ID,
          scope: SCOPES
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
          authorizeButton.onclick = handleAuthClick;
          signoutButton.onclick = handleSignoutClick;
        });
      }

      /**
       *  Called when the signed in status changes, to update the UI
       *  appropriately. After a sign-in, the API is called.
       */
      function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
          authorizeButton.style.display = 'none';
          signoutButton.style.display = 'block';
          listLabels();
        } else {
          authorizeButton.style.display = 'block';
          signoutButton.style.display = 'none';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
      }

      /**
       * Append a pre element to the body containing the given message
       * as its text node. Used to display the results of the API call.
       *
       * @param {string} message Text to be placed in pre element.
       */
      function appendPre(message) {
        var pre = document.getElementById('content');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
      }

      /**
       * Print all Labels in the authorized user's inbox. If no labels
       * are found an appropriate message is printed.
       */
      function listLabels() {
        gapi.client.gmail.users.labels.list({
          'userId': 'me'
        }).then(function(response) {
          var labels = response.result.labels;
          appendPre('Labels:');
          //console.log(labels);
          getListEmails1();
          //sendEmails();
          getEmail();
          if (labels && labels.length > 0) {
            for (i = 0; i < labels.length; i++) {
              var label = labels[i];
              appendPre(label.name)
            }
          } else {
            appendPre('No Labels found.');
          }
        });
      }

      //Listar
      function getListEmails1(){
          userId = 'me'
          var request = gapi.client.gmail.users.messages.list({
              'userId': 'me',
              'maxResults': 20,
              'labelIds': 'SENT',
              'includeSpamTrash': true
          });
          request.execute(function(resp) {
              console.log(resp)
          });
      }

      //Listar todos
      function getListEmails2(){
          userId = 'me'
          query = "is:unread";

          var request = gapi.client.gmail.users.messages.list({
              'userId': 'me',
              'q': query
          });
          function showListEmails(request, result){
              request.execute(function(resp){
                  result = resp.messages;
                  console.log(result);
                  var nextPageToken = resp.nextPageToken;
                  if(nextPageToken){
                      request = gapi.client.gmail.users.messages.list({
                          'userId': userId,
                          'pageToken': nextPageToken,
                          'q': query
                      });
                      showListEmails(request, result);
                  }
              });
          }
          showListEmails(request, []);
      }

      //NOVA API 

      function getEmail(){
        var request = gapi.client.gmail.users.messages.get({
            'userId': 'me',
            'id': '16494840436b0435'
        });
        request.execute(function(resp) {
            console.log(getBody(resp.payload));
        });

        //https://github.com/sitepoint-editors
        function getBody(message) {
            var encodedBody = '';
            if(typeof message.parts === 'undefined')
            {
                encodedBody = message.body.data;
            }
            else
            {
                encodedBody = getHTMLPart(message.parts);
            }
            encodedBody = encodedBody.replace(/-/g, '+').replace(/_/g, '/').replace(/\s/g, '');
            return appendPre(decodeURIComponent(escape(window.atob(encodedBody))));
        }
      }


      //FIM NOVA API

      //CRIAR
      //escopo https://www.googleapis.com/auth/gmail.send
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
          email += 'Isso é um teste! \r\n';

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

    </script>

    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
  </body>
</html>