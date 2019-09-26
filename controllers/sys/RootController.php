<?php

class RootController extends RootThemeController
{

    protected $theme = '';

    public function init()
    {
        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $csrf = session_id();

        //     $csrfToken = isset($_POST['csrfToken']) ? $_POST['csrfToken'] : '';
        //     if ($csrf != $csrfToken) {
        //         echo "No Csrf Error";
        //         return;
        //     }
        // }
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function authorize()
    {
        return true;
    }

    public function __destruct()
    {
        $this->get_footer();
    }

    /**
     *@noAuth
     *@url GET /
     *@url GET /index
     */
    public function index()
    {
        ob_start();
        $this->get_header();
        require $this->themepath . '/index.php';
        $this->get_footer();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
        // $csrf = session_id();
        // require_once $_SERVER['DOCUMENT_ROOT'] . '/views/index.html';
        // $data = ['name' => 'aaax', 'xxx' => 'xxx'];
        // RoundService::insertOrupdate($data);
        // $data['id'] = 1;
        // $data['name'] = 'update';
        // RoundService::insertOrupdate($data);
        // $all = RoundService::All();
        // $all = TypeService::allinput();
        // $types = Type::get();
        // foreach ($types as $type) {
        //     echo $type->name,'--',$type->lname, '<br/>';
        //     $lots = LotService::lotsumarybyround(1, $type->id);
        //     echo $lots;
        //     echo '<br/><hr/>';
        // }
        // echo '<br/><hr/>';
        // echo LotService::sumbyround(1)->get();
        // echo '<br/><hr/>';
        // echo LotService::sumbyRoundType(1)->get()->toJson(JSON_UNESCAPED_UNICODE);
        // echo '<br/><hr/>';
    }

    /**
     *@noAuth
     *@url GET /facebook
     *----------------------------------------------
     *FILE NAME:  RootController.php gen for Servit Framework Controller
     *DATE:                 2019-01-22(Tue)  21:07:34

     *----------------------------------------------
     */
    public function facebook()
    {

        $html = <<<HTML
            <center><h1>Facebook Test 414027695458963</h1></center>
            <div id="fb-root"></div>
            <div class="fb-login-button"
            data-size="large"
            data-button-type="continue_with"
            data-auto-logout-link="true"
            data-use-continue-as="true"></div>

            <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=414027695458963&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

  <script>
    window.fbAsyncInit = function () {
        console.log('facebok init');
        FB.init({
            appId: '414027695458963',
            cookie: true,
            xfbml: true,
            version: 'v2.8'
        });
        FB.getLoginStatus(function (response) {
            console.log('getloginstatus',response);
            if(response.status =="connected"){
                facebookdata();
            }
        });

        FB.Event.subscribe('auth.login', function (response) {
            console.log('authlogin',response);
            if (response . status == "connected") {
                facebookdata();
            }
        });
        FB.Event.subscribe('auth.logout', function (response) {
            console.log('authlogout',response);
        });

        function facebookdata(){
              FB.api('/me',{ fields: 'id,name,email'}, function (response) {
                console.log('facebook login successed!',response);
            });
        }

    };
  </script>
HTML;
        echo $html;
    }

    /**
     *@noAuth
     *@url GET /google
     *----------------------------------------------
     *FILE NAME:  RootController.php gen for Servit Framework Controller
     *DATE:                 2019-01-22(Tue)  23:03:25

     *----------------------------------------------
     */
    public function google()
    {

        $html = <<<HTML

<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
  <script src="https://apis.google.com/js/api:client.js"></script>
  <script>
  var googleUser = {};
  var goo = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '124411842099-uhj3hof63vvt2rmrdrbrthuem7tkj0ef.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      window.auth2 = auth2;
      attachSignin(document.getElementById('customBtn'));
    });
  };

  function signOut() {
    auth2.signOut().then(function () {
        window.goo = {};
      console.log('User signed out.');
    });
  }

  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          console.log('sign in--->',googleUser);
          window.goo = googleUser;
          console.log('id--->',googleUser.getBasicProfile().getId());
          console.log('name--->',googleUser.getBasicProfile().getName());
          console.log('email--->',googleUser.getBasicProfile().getEmail());

          document.getElementById('name').innerText = "Signed in: " +
              googleUser.getBasicProfile().getName();
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
  }
  </script>
  <style type="text/css">
    #customBtn {
      display: inline-block;
      background: white;
      color: #444;
      width: 190px;
      border-radius: 5px;
      border: thin solid #888;
      box-shadow: 1px 1px 1px grey;
      white-space: nowrap;
    }
    #customBtn:hover {
      cursor: pointer;
    }
    span.label {
      font-family: serif;
      font-weight: normal;
    }
    span.icon {
      background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;
      display: inline-block;
      vertical-align: middle;
      width: 42px;
      height: 42px;
    }
    span.buttonText {
      display: inline-block;
      vertical-align: middle;
      padding-left: 42px;
      padding-right: 42px;
      font-size: 14px;
      font-weight: bold;
      /* Use the Roboto font that is loaded in the <head> */
      font-family: 'Roboto', sans-serif;
    }
  </style>
  </head>
  <body>
  <div id="gSignInWrapper">
    <span class="label">Sign in with:</span>
    <div id="customBtn" class="customGPlusSignIn">
      <span class="icon"></span>
      <span class="buttonText">Google</span>
    </div>
  </div>
  <div id="name"></div>
  <a href="#" onclick="signOut();">Sign out</a>
  <script>startApp();</script>

</body>
</html>
HTML;
        echo $html;

    }

    /**
     *@noAuth
     *@url GET /lineauth
     *----------------------------------------------
     *FILE NAME:  RootController.php gen for Servit Framework Controller
     *DATE:                 2019-01-23(Wed)  10:47:56

     *----------------------------------------------
     */
    public function lineauth()
    {
        $linesrv = new LineService();
        $rs = $linesrv->authorize();

    }

    /**
     *@noAuth
     *@url GET /line
     *----------------------------------------------
     *FILE NAME:  RootController.php gen for Servit Framework Controller
     *DATE:                 2019-01-23(Wed)  10:47:56

     *----------------------------------------------
     */
    public function line()
    {
        $linesrv = new LineService();
        $result = $linesrv->requestAccessToken($_GET, true);
        dump($_GET);
        dump($result);
    }

}
