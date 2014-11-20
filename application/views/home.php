<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/ico/favicon.png">

    <title>LA Lights</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?=base_url()?>css/main.css">
    <link href="<?=base_url()?>css/style.css" rel="stylesheet">
    

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    {MENU}
<div class="container content">
      <div class="hero-banner">
        <div class="desc-banner">
          <h1 class="col-md-9">Buat <span>meme</span> kreasi lo dan menangkan gadget super keren!</h1>
          <?
		 // session_destroy();
          $user=get_login_fb();
		  if(!$user)
		  {
			 $href= "<a href = '".base_url()."howto'>"  ;
		  }else
		  {
			  $href= "<a href = '".base_url()."howto'>"  ;
		  }
		  ?>
           <?=$href?>
          <button type="button" class="btn btn-danger btn-lg">START NOW</button>
          </a>
        </div>
        <img src="img/banner.jpg" alt="hero banner" class="img-responsive" >
        <div class="vid-embed visible-lg visible-md">
          <iframe width="420" height="315" src="//www.youtube.com/embed/ymdBOQHE-ms?controls=0&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe><br>
        </div>
        <div class="vid-play visible-xs visible-sm">
          <a href="http://www.youtube.com/watch?v=ymdBOQHE-ms"><img src="img/play.png" alt="link youtube"></a>
        </div>
        <p>
          Pesta demokrasi dimulai, kalo mau pilih, #CariYangKerja
        </p>
      </div>
    </div><!-- /.container -->
  
    <div class="big-red">
      <center>MEME</center>
    </div>
    <div class="list-item">
		<?	foreach($collection as $items) {
			
			  //$pos = strpos($items['content'], 'RT');
			  //print_r($pos);
    		//if ($pos !== false) {
        // array_shift($matches);
        // print_r($matches);
        //}else{
        			
        			 ?>
        		
                
                 <div class="items col-xs-6 col-sm-4 col-md-3 hover_content">
        			<a rel="lightbox[group]" href="<?=$items['media']?>"><img src="<?=$items['media']?>" alt="<?=$items['from_name']?>" class="img-responsive" style="max-height:395px;">
        			</a>			
        			 
        				<div class="content_desc"><?=strip_tags($items['content'])?></div>
        		  </div>
        		 <?
        //}
			}
		 ?>
     
      <div class="clear"></div>
    </div>
    <div id="light" class="white_content">
            <p>Satu Langkah Lagi!</p>
            <a href=""><img src="img/facebook.jpg" alt=""></a>
            <a href=""><img src="img/twitter.jpg" alt=""></a>
            <div class="clear"></div>
            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
          </div>
          <div id="fade" class="black_overlay"></div>
   {FOOTER}
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="<?=base_url()?>js/bootstrap.min.js"></script>
    
    <script src="<?=base_url()?>js/plugins.js"></script>
    <script src="<?=base_url()?>js/jquery.prettyPhoto.js"></script>
    <script src="<?=base_url()?>js/main.js"></script>
    <script src="<?=base_url()?>js/style.js"></script>
  <!--script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49935973-1', 'la-lights.com');
  ga('send', 'pageview');
  </script-->  
  <script>
     var _gaq=[['_setAccount','UA-25056701-1'],['_trackPageview']];
     (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
     g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
     s.parentNode.insertBefore(g,s)})(document,'script');
  </script>
  </body>
</html>
