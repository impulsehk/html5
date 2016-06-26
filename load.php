
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="fonts/stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/page-theme.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<style>
  .loding-circle{
    margin: 50px auto;
    width: 300px;
    height: 500px;
    background: #fcb717;
    -webkit-border-radius: 150px;
    -moz-border-radius: 150px;
    border-radius: 150px;
    background: rgba(252,183,23,1);
    background: -moz-linear-gradient(top, rgba(252,183,23,1) 0%, rgba(255,146,10,1) 100%);
    background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(252,183,23,1)), color-stop(100%, rgba(255,146,10,1)));
    background: -webkit-linear-gradient(top, rgba(252,183,23,1) 0%, rgba(255,146,10,1) 100%);
    background: -o-linear-gradient(top, rgba(252,183,23,1) 0%, rgba(255,146,10,1) 100%);
    background: -ms-linear-gradient(top, rgba(252,183,23,1) 0%, rgba(255,146,10,1) 100%);
    background: linear-gradient(to bottom, rgba(252,183,23,1) 0%, rgba(255,146,10,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcb717', endColorstr='#ff920a', GradientType=0 );
    -webkit-box-shadow: 0px 10px 5px 0px rgba(225,225,225,1);
    -moz-box-shadow: 0px 10px 5px 0px rgba(225,225,225,1);
    box-shadow: 0px 10px 5px 0px rgba(225,225,225,1);
  }
  .loding-logo{
    padding: 70px 0 0;
    margin: 0 auto;
    width: 200px;
    display: block;
  }
  .loding-logo img{
    width: 100%;
  }
  .ajaxloding{
    display: block;
    margin: 40px auto 10px;
    width: 43px;
    height: 11px;
    background: url('img/ajax-loader.gif');    
  }
  .loding-text{
    display: block;
    font-size: 22px;
    color: #fff0ce;
    width: 100%;
    text-align: center;
  }
  .loding-text2{
    margin: 15px auto 5px;
    display: block;
    font-size: 16px;
    color: #fff0ce;
    width: 100%;
    text-align: center;
  }
  .loding-text3{
    display: block;
    font-size: 20px;
    color: #fff;
    width: 90%;
    padding: 0 5%;
    font-weight: bold;
    text-align: center;
    padding-bottom: 10px;
    overflow:hidden; 
    white-space:nowrap; 
    text-overflow: ellipsis;
  }
  .loding-text5{
    display: block;
    font-size: 13px;
    line-height: 30px;
    color: #555;
    background: #fff;
    width: 100%;
    text-align: center;
	font-weight:bold;
  }
</style>
<title>Loding...</title>
 <script>
	$(document).ready(function(){
          
	});
</script>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="loding-circle">
        <div class="loding-logo"><img alt="" src="http://178.62.5.12/bhbsp/images/demo-logo.png"></div>
        <div class="ajaxloding"></div>
        <div class="loding-text">Please Wait</div>
        <div class="loding-text2">We are searching for the best Value</div>
        <div class="loding-text3">Hotels In Kolkataaaaaaaaaaaaaaaaaaa</div>
        <div class="loding-text5 ">
        Check-in: Sat, Aug-08, 2015
        <br />
        Check-out: Sat, Aug-14, 2015
        </div>
        <div class="loding-text2">This will take only few seconds.</div>
      </div>
    </div>
  </div>
</div>

</body>
</html>