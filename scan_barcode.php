<?php 
      session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>KEY BARCODE</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.css" />
    <link rel='stylesheet' href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" >
    <style>
    body, input {font-size:14pt}
    input, label {vertical-align:middle}
    .qrcode-text {padding-right:1.7em; margin-right:0}
    .qrcode-text-btn {display:inline-block; background:url(//dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg) 50% 50% no-repeat; height:1em; width:1.7em; margin-left:-1.7em; cursor:pointer}
    .qrcode-text-btn > input[type=file] {position:absolute; overflow:hidden; width:1px; height:1px; opacity:0}
    </style>
<!-- <style> 
    input[type=text] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid red;
    border-radius: 4px;
    }
    </style> -->

</head>
<body>
<?php
  $User_status = $_SESSION["Status"];
  // echo $User_status;
if($User_status == "ADMIN") {
  include("navbar_full.php");
} elseif($User_status == "USER") {
  include("navbar.php");
}
?>
<div id="app">
    <p>ทำการยิงรหัส barcode ของ  palate:</p>
    <?php 
          $UserLogin = $_SESSION["UserName"];
    ?>
    
    <label for ="Username"> Username: </label><br>
    <input id=Username type="text" name="Username" value ="<?php echo $UserLogin; ?>" /><br>
	  <label for ="locate"> Location: </label>
        <select name="locate" v-model="locate">
            <option value="ลำปาง">ลำปาง</option>
            <option value="สิงห์บุรี">สิงห์บุรี</option>
        </select>

	<br>
  
<input type=text id="barcode" name="barcode_id" size=16 placeholder="Tracking Code" class=qrcode-text><label class=qrcode-text-btn><input type=file accept="image/*" capture=environment onchange="openQRCamera(this);" tabindex=-1></label> 
<button type=button onclick="addbarcode">Go</button>

<table>
      <tr v-for="(b,idx) in barcodes" :key="idx"><td>{{b}}</td></tr>
    </table>
   

<script src="https://dmla.github.io/jsqrcode/src/qr_packed.js"></script>
<script>
function openQRCamera(node) {
  var reader = new FileReader();
  reader.onload = function() {
    node.value = "";
    qrcode.callback = function(res) {
      if(res instanceof Error) {
        alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
      } else {
        node.parentNode.previousElementSibling.value = res;
      }
    };
    qrcode.decode(reader.result);
  };
  reader.readAsDataURL(node.files[0]);
}
</script>






	<br>
		<label for ="barcode"> Barcode: </label><br>
		<input id="barcode" type="text" v-model="barcode" name="barcode_id" @keydown="addbarcode" >
	<br>
    <table>
      <tr v-for="(b,idx) in barcodes" :key="idx"><td>{{b}}</td></tr>
    </table>
</div>	    
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script type="text/javascript">
    window.vm = new Vue({
    el:'#app',
    data(){
        return {
            locate:   'ลำปาง',
            barcode:  '',
            barcodes: [],
            username: '<?=$UserLogin?>',
        };
    },
    methods:{
      addbarcode(e){
        if(e.key =="Enter"){
          axios.post('./barcode_save.php',{ barcode_id:this.barcode, locate:this.locate, Username:this.username } ).then(rs=>console.log).catch(err=>console.log)
          this.barcodes.push(this.barcode);
          this.barcode = '';
        }
      }
    }
  });
</script>
</html>

