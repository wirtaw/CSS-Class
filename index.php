<?php
      //include('gzip_top.php');
      if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
      $version='1.0';
      $features='
      <ul class="list">
      <li>Detect browser or mobile device type</li>
      <li>Clean and reset CSS</li>
      <li>Read all css files in directed path</li>
      <li>Delete all free spaces</li>
      <li>Write to file</li>
      <li>Publish link to this in head file</li>
      <li>Gzip in header</li>
      <li>Three different types of including</li>
      </ul><br/>
      <h4>Addional options for different browsers and their versions</h4><br/>
      <ul class="list">
      <li>Generate opacity</li>
      <li>Rounded corners</li>
      <li>Concrete font by version or default if old browser</li>
      <li>Select and verify font code by css, generate code(replace by font name if use $font variable in style.css)</li>
      </ul>
      ';
      $todo='Generate several file for every client<br/>
      
      ';
      $fixed='';
      $samples=array(array('css','php','It put in reset verified type of box-sizing by browser type.',"div {
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      -ms-box-sizing: border-box;
      box-sizing: border-box;
}","     switch (\$this->browser['name']){
      case 'Mozilla Firefox':
	    \$str.='-moz-box-sizing: border-box;';
	    break;
      case 'Internet Explorer':
	    \$str.='box-sizing: border-box;';
	    break;
      case 'Google Chrome':
	    \$str.='-webkit-box-sizing: border-box;';
	    break;
      case 'Opera':
	    \$str.='box-sizing: border-box;';
	    break;
      case 'Apple Safari':
	    \$str.='-webkit-box-sizing: border-box;';
	    break;
      case 'Netscape':
	    \$str.='-moz-box-sizing: border-box;';
	    break;
      }
      "),array('css','php','Make different precentage of opacity for different browser ',"div{
-ms-filter:\"progid:DXImageTransform.Microsoft.Alpha(Opacity=\$op)\";
filter:alpha(opacity=\$op);		  
/* CSS3 standard */
opacity:\$op;}","switch (\$this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)\$this->browser['version']&lt;=1.6){
				    \$str.='-moz-opacity: '.(\$op/100).';';
			      }else{
				    \$str.='opacity:'.(\$op/100).';';
			      }    
			break;
			case 'Internet Explorer':
			      if((double)\$this->browser['version']&gt;=9.0){
\$str.='filter: alpha(opacity='.\$op.');';
			      }else{
\$str.='filter:progid:DXImageTransform.Microsoft.Alpha(opacity='.\$op.');';
			      }  
			break;
			case 'Google Chrome':
			      \$str.='opacity:'.(\$op/100).';';
			break;
			case 'Opera':
			      \$str.='opacity:'.(\$op/100).';';
			break;
			case 'Apple Safari':
			      if((double)\$this->browser['version']&lt;=3.1){
				    \$str.='-khtml-opacity:'.(\$op/100).';';
			      }else{
				    \$str.='opacity:'.(\$op/100).';';
			      }  
			break;
			case 'Netscape':
			      \$str.='-khtml-opacity:'.(\$op/100).';';
			break;
		  } 
		  \$str.='}';"),array('css','php','It put type of shadow by browser type.',"span{ -moz-border-radius: 30px;
			-webkit-border-radius: 30px;
			-khtml-border-radius: 30px;
			behavior: url(border-radius.htc);
			border-radius: 30px;
			}","switch (\$this-&gt;browser['name']){
			case 'Mozilla Firefox':
			      if((double)\$this-&gt;browser['version']&gt;=3.5){
				    \$str.='-moz-border-radius: 30px;		    
				    border-radius: 30px;
			      }
			      break;
			case 'Internet Explorer':
			      if((int)\$this-&gt;browser['version']&gt;=9){
				    \$str.='border-radius: 30px;
			      }
			break;
			case 'Google Chrome':
			      if((int)\$this-&gt;browser['version']&gt;1){
				    \$str.='-webkit-border-radius: 30px;
				    border-radius: 30px;
			      }
			break;
			case 'Opera':
			      if((double)\$this-&gt;browser['version']&gt;=10.5){
				    \$str.='border-radius: 30px;
				    
			      }
			break;
			case 'Apple Safari':
			      if((int)\$this-&gt;browser['version']&gt;=4){
				    \$str.='-webkit-border-radius: 30px;
				    border-radius: 30px;
			      }
			break;
			case 'Netscape':
			      \$str.='
			break;
		  }"),array('css','php','Make differnt font file interpretation',"@font-face {
    font-family: 'Font Name';
    src: url('font_name.eot');
    src: local('Font Name'),
         local('Font Name'),
         url('font_name.eot.ttf') format('truetype'),
         url('font_name.eot.svg#font') format('svg');
}","\$str='@font-face {font-family: \''.\$name.'\';';
			switch (\$this-&gt;browser['name']){
			case 'Mozilla Firefox':
			      if((double)\$this-&gt;browser['version']&gt;=3.5){
				    if(file_exists(\$src.'.ttf'))\$str2='url(\''.\$src.'.ttf\') format(\'truetype\'),';
			      } 
			break;
			case 'Internet Explorer':
			      if((double)\$this-&gt;browser['version']&gt;=9.0){
						if(file_exists(\$src.'.woff'))\$str2='url(\''.\$src.'.woff\') format(\'woff\'),';
			      }else{
						if(file_exists(\$src.'.eot'))\$str2='src: url(\''.\$src.'.eot\');
						src: url(\''.\$src.'.eot?#iefix\') format(\'embedded-opentype\'),';
			      }  
			break;
			case 'Google Chrome':
			       if((double)\$this-&gt;browser['version']&gt;=4.0){
						if(file_exists(\$src.'.ttf'))\$str2='url(\''.\$src.'.ttf\') format(\'truetype\'),';
					}
			break;
			case 'Opera':
				if((double)\$this-&gt;browser['version']&gt;=10.0){
			      if(file_exists(\$src.'.ttf'))\$str2='url(\''.\$src.'.ttf\') format(\'truetype\'),';
			     }
			break;
			case 'Apple Safari':
			      if((double)\$this-&gt;browser['version']&gt;=4.0){
						if(file_exists(\$src.'.ttf'))\$str2='url(\''.\$src.'.ttf\') format(\'truetype\'),';
					}
			break;
			case 'Netscape':
			      if((double)\$this-&gt;browser['version']&gt;=4.0){
						\$str2='url(\''.\$src.'.ttf\') format(\'truetype\'),';
					}
			break;
			} 
			if(isset(\$str2)&&amp;&amp;trim(\$str2)!=''){
			      \$str.=\$str2.\"font-weight: normal; font-style: normal;}\";
			}else{
			      \$str='';
			}"));
			$info=date ("D, d M Y H:i:s.", filemtime("index.php"));
			header("Expires: Mon, 1 Jan 1970 05:00:00 GMT");// дата в прошлом
			header("Last-Modified: " . $info . " GMT");  // всегда модифицируется
			header("Cache-Control: no-store, no-cache, must-revalidate");// HTTP/1.1
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");// HTTP/1.0
?>
<!DOCTYPE html>
<html lang="en">
		<head>
			<title>CSS-Class Cros Browser Clean <? echo $version; ?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<meta name="Author" content="Vladimir Poplavskij"/>
			<meta name="Description" content="css,browser,styles,mobile"/>
			<meta name="Keywords" content="CSS-Class Cros Browser Clean <? echo $version; ?>"/>
			<meta name="Robots" content="all"/>			
			<link rel="Canonical" href="#"/>
			<link rel="stylesheet" title="IDEA" href="highlight/styles/idea.css">			
			<?php
			      include('css/css.php');
			      include('js/js.php');
			?>	
		</head>		
		<body>
		<?php
		  //var_dump($style->mobile);
		  if(isset($style->mobile)&&is_array($style->mobile)&&$style->mobile[1]){
		  
		  ?>
		  <h1>CSS-Class Cros Browser Clean mobile<? echo $version; ?></h1> 
		  <span class="wrapper"> <a href="https://github.com/wirtaw/CSS-Class">Github</a> </span><br/>
		  <div class="iframe_box">
			<?php
			echo '<br/><h2>Features</h2><br/>'.$features.'<span class="wrapper"></span>';
			echo '<br/><h2>Todo</h2><br/>'.$todo.'<span class="wrapper"></span>';
			echo '<br/><h2>Fixed</h2><br/>'.$fixed.'<span class="wrapper"></span>';
			?>
		  </div>
		  <?php
			echo '<br/><h2>Sample</h2><br/>';
			foreach($samples as $key => $value){
			      echo '<div class="iframe_box">'.$value[2].'<br/><table><tr><td>Before</td><td>After</td></tr><tr><td><pre><code class="'.$value[0].'">'.$value[3].'</code></pre></td><td><pre><code class="'.$value[1].'">'.$value[4].'</code></pre></td></tr></table></div>';
			}
		  ?>
		  
		  <?php
		  
		  }else{
			?>
			<div id="up"><h1>CSS-Class Cros Browser Clean <? echo $version; ?></h1><br/>	
		</div>
		<div id="mid">
		  <div id="leftcontent">
			<?php
			echo '<br/><h2>Samples</h2><br/>';
			foreach($samples as $key => $value){
			      echo '<div class="tab2">'.$value[2].'<br/><table style="width:100%;"><tr><td style="width:50%;">Before</td><td style="width:50%;">After</td></tr><tr><td><pre><code class="'.$value[0].'">'.$value[3].'</code></pre></td><td><pre><code class="'.$value[1].'">'.$value[4].'</code></pre></td></tr></table></div>';
			}
			?>
		  </div>
		  <br style="clear:both;"/>
		  <div id="rightcontent"><img src="img/github.png" width="24" height="24" class="giticon"> <a href="https://github.com/wirtaw/CSS-Class" class="git">Github</a> <br/>
			<?php
			echo '<br/><h2>Features</h2><br/>'.$features;
			echo '<br/><h2>Todo</h2><br/>'.$todo;
			echo '<br/><h2>Fixed</h2><br/>'.$fixed;
			/*if(isset($info)){
			      var_dump($info);
			}
			if(isset($style)&&is_object($style)){
			      //var_dump($style->elems);
			      echo '<br/>fff<br/>';
			      //var_dump($style->elems2);
			}
			echo '<span class="but">Button font</span>';*/
			?>
		  </div>
		</div>
			<?php
		  }
		  
			?>
		
		</body>		
</html>
<?php
      ob_end_flush();
?>