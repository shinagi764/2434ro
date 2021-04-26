<html>
  <head>
    <title>SLIDESHOW</title>  
    <link rel="stylesheet" href="assets/css/principal.css" type="text/css" />  
    <script type="text/javascript" src="assets/js/jquery-min.js"></script>
    <script type="text/javascript" src="assets/js/slider.js"></script>
    <script type='text/javascript'>document.oncontextmenu = function(){return false}</script>
    <style type="text/css">
body {
  background-repeat:no-repeat;
  background-color: #ecebe9;
  margin:0 auto;
  overflow:hidden;
}
</style>
</head>
  <body>  
                    
<div id="slider">
   <ul>
  <li style="background: url('assets/img/slide.png');">    </li>
  <li style="background: url('assets/img/slide2.png');">    </li>
</div>
<script type="text/javascript">
$(function(){
  $("#slider").easySlider();
});
</script>
</body>
</html>