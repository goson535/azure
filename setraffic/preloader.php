<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
   <title>Подтверждения возраста</title>
   <meta name="description" content="" />
   <meta name="robots" content="noindex">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<style>
body {
font: 13px/22px Arial, sans-serif;
overflow-x: hidden;
color: #9d9d9d;
}
.preloader {
max-width: 450px;
margin: 12% auto;
position: relative;
text-align: center;
}
.preloader h1 {
color: #000;
}
.preloader div {
}
.preloader p {
font-size: 10px;
}
.btn-success {
background: #39ab58;
margin: 5px 15px;
border-top: 1px solid #67c722;
border-bottom: 4px solid #228b3f;
color: #fff;
font-weight: bold;
width: 140px;
padding: 10px;
font-size: 18px;
display: inline-block;
border-radius: 25px;
-webkit-border-radius: 25px;
-moz-border-radius: 25px;
cursor: pointer;
}
.btn-success:hover {
background: #4bca6e;	
}
.btn-error {
background: #d02e2e;
margin: 5px 15px;
border-top: 1px solid #f54949;
border-bottom: 4px solid #a92020;
color: #fff;
font-weight: bold;
width: 140px;
padding: 10px;
font-size: 18px;
display: inline-block;
border-radius: 25px;
-webkit-border-radius: 25px;
-moz-border-radius: 25px;
cursor: pointer;
}
.btn-error:hover {
background: #ec3f3f;
}
</style>
<script>
   function link_mirror() {
	  window.location.href = '<?php echo $mirror; ?>';   
   }
   function visit_close() {
	   
   }
</script>
<body>
   <div class="preloader"> 
      <h1>Вам уже есть 18+?</h1>  
      <div>
	     <div class="btn-success" onclick="link_mirror();">ДА</div>
	     <div class="btn-error" onclick="visit_close();">НЕТ</div>
	  </div>
      <div>
	     <p>Данный сайт не является казино, не проводит и не организовывает азартные игры на деньги. Сайт носит информационный характер, не имеет рекламного характера и не предназначен для деятельности, запрещенной N 244-ФЗ «О государственном регулировании деятельности по организации и проведению азартных игр и о внесении изменений в некоторые законодательные акты Российской Федерации» от 29.12.2006.</p>
	  </div>
   </div>
</body>
</html>