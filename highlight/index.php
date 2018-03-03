<?php
       $mas=explode('/',$_SERVER["PHP_SELF"]);
       $dir='';
       $dirstyle='';
       $dirimage='';
       if(count($mas)>2){
				$dir='../conf/';
				$dirstyle='../';
			}elseif(count($mas)==1){
				$dir='conf/';
				$dirstyle='';
			}
       foreach($mas as $key => $value){
			if(strpos($value,'.php')!==false){$pageself=$value;}else{$dir.='/'.$value;}
			if(strcmp($value,'config')!==false){$dir='';$dirstyle='../';}
       }
       unset($mas);
      session_start();
      
      if(file_exists($dir.'Lang.php'))include($dir.'Lang.php');
      if(file_exists($dir.'Menu.php'))include($dir.'Menu.php');
      if(file_exists($dir.'Gallery.php'))include($dir.'Gallery.php');
      if(file_exists($dir.'Slides.php'))include($dir.'Slides.php');
      if(file_exists($dir.'Contacts.php'))include($dir.'Contacts.php');
      if(file_exists($dir.'Blog.php'))include($dir.'Blog.php');
      if(file_exists($dir.'module.php'))include($dir.'module.php');
		//echo ' dir  '.$dir;
?>

<!DOCTYPE html>
<title><?php echo ShoWord('title','Poplauki').' | '.WhatPage();?></title>
<meta charset="utf-8" />
<?php
	echo '<link rel="stylesheet" href="'.$dirstyle.'styles/style.css" type="text/css" />
<script src="'.$dirstyle.'scripts/std.js" type="text/javascript"></script>
<script src="'.$dirstyle.'scripts/elegant-press.js" type="text/javascript"></script>
<link rel="shortcut icon" href="'.$dirstyle.'favicon.ico" />';
?>


<!--[if IE]><style>#header h1 a:hover{font-size:75px;}</style><![endif]-->
</head>
<body>
<div class="main-container">
  <div id="header">
      <h1><a href="http://poplauki.eu/index.php"><?php echo ShoWord('title','Poplauki');?></a></h1>
    <p id="tagline"><strong><?php echo ShoWord('pagename','Web page');?></strong></p>
  </div>
</div>

<div class="main-container">
  <div id="sub-headline">
    <div class="tagline_left">
    <?php
				echo '<p id="tagline2">'.ShoWord('warning','Warning').'</p><br />';
			?>
     <br style="clear:both;"/>
    </div>
    <div class="tagline_right">
      
    </div>
    <br class="clear" />
  </div>
</div>
<div class="main-container">
  <div class="container1">


    <div class="box">
           <div class="content">
        
 <?php
				echo '<p>'.ShoWord('noaccess','No access!!!').'<br /> '.ShoWord('backto','Back to ').' <a href="../index.php">'.ShoWord('page','page').'</a></p>';
			?>
      </div>
      
     <div class="sidebar">

       <div class="subnav">
	  <?php
	    if(isset($_SESSION['contacts'])&&is_array($_SESSION['contacts'])&&count($_SESSION['contacts'])>0)
	    { 
		  echo '<h5>'.ShoWord('follow','Follow Us!').'</h5>
		  <ul>';
			if(isset($_SESSION['contacts']['facebook'])&&is_object($_SESSION['contacts']['facebook']))echo $_SESSION['contacts']['facebook']->Show();
			if(isset($_SESSION['contacts']['twitter'])&&is_object($_SESSION['contacts']['twitter']))echo $_SESSION['contacts']['twitter']->Show();
			if(isset($_SESSION['contacts']['linkedin'])&&is_object($_SESSION['contacts']['linkedin']))echo $_SESSION['contacts']['linkedin']->Show();
		   echo '</ul>';
	    }
	    ?>
        </div>
      </div>

      
      
      <div class="clear"></div>
    </div>
    
 
 </div>
 <div id="copyright">
     <?php
		if(isset($_SESSION['referer'])&&is_array($_SESSION['referer']))
		{
		echo '<p class="tagline_left">Copyright &copy; '.date('Y').' - '.ShoWord('rights','All Rights Reserved').' - '.$_SESSION['referer'][0]->Link();
		for($i=2;$i<count($_SESSION['referer']);$i++){
			if(is_object($_SESSION['referer'][$i]))echo $_SESSION['referer'][$i]->Span();
		}
		echo '</p>
		<p class="tagline_right">Design by '.$_SESSION['referer'][1]->Span().'</p><br class="clear" />';
		}else{
			echo '<p class="tagline_left">Copyright &copy; '.date('Y').' - '.ShoWord('rights','All Rights Reserved').' - <a href="#">poplauki</a> </p>
			<p class="tagline_right">Design by <span onclick="location.href=\'http://www.priteshgupta.com/\';" style="cursor:pointer;color:blue;">PriteshGupta.com</span></p>
    <br class="clear" />';
		}
    ?>
<br />
<br />
</div>
<!-- *Free template distributed by http://freehtml5templates.com -->
    </body>
</html>

