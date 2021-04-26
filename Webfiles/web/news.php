	<head>
		<title>NEWS</title>	
		<link rel="stylesheet" href="assets/css/news.css" type="text/css" />  
    <link href="https://fonts.googleapis.com/css?family=Exo+2:300,400,600,900" rel="stylesheet">
    <script type="text/javascript" src="assets/js/jquery-min.js"></script>
    <script type="text/javascript" src="assets/js/slider.js"></script>
    <script type='text/javascript'>document.oncontextmenu = function(){return false}</script>
<style type="text/css">
body {
  background-image: url(assets/img/bgnews.jpg);
  background-repeat:no-repeat;
  background-color: #ecebe9ff;
  margin:0 auto;
  overflow:hidden;
}
.News {color: #4d80d4}
.Maintenance {color: #ea7272}
.Event {color: #a0d44d}
</style>
</head>
	<body>
<?php $elfin=include('config/rssConfig.php'); ?>
  <div class="newsblock" style="margin-top: 1px;">
              <?php
					require_once("config/rsslib.php");
					echo RSS_Display ( $elfin['RSSnews'], 6 );
			  ?></div>
	</body>
</html>