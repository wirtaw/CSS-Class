<?php
      class Style{
	    var $name;
	    var $dirs;
	    var $source;
	    var $browser;
	    var $mobile;
	    var $clear;
	    var $elems=array();
	    var $errors=array();
	    var $type;
	    public function getBrowser(){
		  $u_agent = $_SERVER['HTTP_USER_AGENT'];
		  $bname = 'Unknown';
		  $platform = 'Unknown';
		  $version= "";

		  //First get the platform?
		  if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		  }elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		  }
   
		  // Next get the name of the useragent yes seperately and for good reason
		  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		  {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		  }
		  elseif(preg_match('/Firefox/i',$u_agent))
		  {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		  }
		  elseif(preg_match('/Chrome/i',$u_agent))
		  {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		  }
		  elseif(preg_match('/Safari/i',$u_agent))
		  {
			$bname = 'Apple Safari';
			$ub = "Safari";
		  }
		  elseif(preg_match('/Opera/i',$u_agent))
		  {
			$bname = 'Opera';
			$ub = "Opera";
		  }
		  elseif(preg_match('/Netscape/i',$u_agent))
		  {
			$bname = 'Netscape';
			$ub = "Netscape";
		  }
   
		  // finally get the correct version number
		  $known = array('Version', $ub, 'other');
		  $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		  if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		  }
   
		  // see how many we have
		  $i = count($matches['browser']);
		  if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			      $version= $matches['version'][0];
			}
			else {
			      $version= $matches['version'][1];
			}
		  }
		  else {
			$version= $matches['version'][0];
		  }
   
		  // check if we have a number
		  if ($version==null || $version=="") {$version="?";}
   
		  return array(
		  'userAgent' => $u_agent,
		  'name'      => $bname,
		  'version'   => $version,
		  'platform'  => $platform,
		  'pattern'    => $pattern
		  );
	    } 
	    public function Opacity($in,$op){
		  $str=$in;
		  switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']<=1.6){
				    $str.='-moz-opacity: '.($op/100).';';
			      }else{
				    $str.='opacity:'.($op/100).';';
			      }    
			break;
			case 'Internet Explorer':
			      if((double)$this->browser['version']>=9.0){
				    $str.='filter: alpha(opacity='.$op.');';
			      }else{
				    $str.='filter:progid:DXImageTransform.Microsoft.Alpha(opacity='.$op.');';
			      }  
			break;
			case 'Google Chrome':
			      $str.='opacity:'.($op/100).';';
			break;
			case 'Opera':
			      $str.='opacity:'.($op/100).';';
			break;
			case 'Apple Safari':
			      if((double)$this->browser['version']<=3.1){
				    $str.='-khtml-opacity:'.($op/100).';';
			      }else{
				    $str.='opacity:'.($op/100).';';
			      }  
			break;
			case 'Netscape':
			      $str.='-khtml-opacity:'.($op/100).';';
			break;
		  } 
		  $str.='}';
		  return $str;
	    }
	    public function MakeHead(){
		  return '/* Generate at '.date('Y-M-j H-i-s').' */
/* for agent '.$this->browser['userAgent'].' */
/* platform '.$this->browser['platform'].' */
/* version '.$this->browser['version'].'*/
';
	    } 
	    public function MakeClear(){
		  $str='/* CSS Framework by Erlang, 2009 */
/* General Cleaning */
* {
	margin:0;
	padding:0;
	font-family:Verdana, Arial, Helvetica, Sans-Serif;
	}
html, body {
	height:100%;
	}
input {
	padding:2px 4px;
	}
body, p, div, table, td, th, input, option, select, button, li, a {
	font-size:9pt;
	}
body {
	background-color:#fff;
	}
table, img {
	border:0;
	}
table {
	border-collapse:collapse;
	}
table td {
	padding:0px;
	vertical-align:top;
	}
div {
	';
      switch ($this->browser['name']){
	    case 'Mozilla Firefox':
		  $str.='-moz-box-sizing: border-box;';
	    break;
	    case 'Internet Explorer':
		   $str.='box-sizing: border-box;';
	    break;
	    case 'Google Chrome':
		   $str.='-webkit-box-sizing: border-box;';
	    break;
	    case 'Opera':
		   $str.='box-sizing: border-box;';
	    break;
	    case 'Apple Safari':
		   $str.='-webkit-box-sizing: border-box;';
	    break;
	    case 'Netscape':
		   $str.='-moz-box-sizing: border-box;';
	    break;
      }
      $str.='}
	    a, a:link, a:visited, a:active {
		  color:#00f;
	    }
	    a:hover {
		  color:#f00;
	    }
	    :focus {
		  outline:none;
	    }
	    label {
		  cursor:pointer;
	    }
	    ul, ol {
		  padding:2px 0;
	    }
	    li{
		  line-height:1.5;
		  margin-left:17px;
	    }';
		  
		  return $str;
	    }
	    public function MakeFont($src,$name){
			$str='@font-face {font-family: \''.$name.'\';';
			switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']>=3.5){
				    if(file_exists($src.'.ttf'))$str2='url(\''.$src.'.ttf\') format(\'truetype\'),';
			      } 
			break;
			case 'Internet Explorer':
			      if((double)$this->browser['version']>=9.0){
				    if(file_exists($src.'.woff'))$str2='url(\''.$src.'.woff\') format(\'woff\'),';
			      }else{
				    if(file_exists($src.'.eot'))$str2='src: url(\''.$src.'.eot\');
				    src: url(\''.$src.'.eot?#iefix\') format(\'embedded-opentype\'),';
			      }  
			break;
			case 'Google Chrome':
			       if((double)$this->browser['version']>=4.0){
				    if(file_exists($src.'.ttf'))$str2='url(\''.$src.'.ttf\') format(\'truetype\'),';
			       }
			break;
			case 'Opera':
			      if((double)$this->browser['version']>=10.0){
				    if(file_exists($src.'.ttf'))$str2='url(\''.$src.'.ttf\') format(\'truetype\'),';
			      }
			break;
			case 'Apple Safari':
			      if((double)$this->browser['version']>=4.0){
				    if(file_exists($src.'.ttf'))$str2='url(\''.$src.'.ttf\') format(\'truetype\'),';
			      }
			break;
			case 'Netscape':
			      if((double)$this->browser['version']>=4.0){
						$str2='url(\''.$src.'.ttf\') format(\'truetype\'),';
					}
			break;
			} 
			if(isset($str2)&&trim($str2)!=''){
			      $str.=$str2."font-weight: normal; font-style: normal;}";
			}else{
			      $str='';
			}
		  return $str;
	    }
	    public function ReplaceFont($name,$patt,$fr,$dec){
		  if(!is_array($fr)){
			if($dec&&strpos($fr,$patt)>0){
			      $fr= str_replace($patt, $name, $fr);
			}
		  }else{
			foreach($fr as $key => $value){
			      if($dec&&strpos($value,$patt)>0){
				  $fr[$key]=  str_replace($patt, $name, $value);
			      }
			}
		  }
		  return $fr;
	    }
	    public function FixImagePath($name,$patt,$fr){
		  if(strpos($fr,$patt)>0){
			$fr= str_replace($patt, $name, $fr);
		  }
		  return $fr;
	    }
	    public function Rounded($n,$color,$padding,$height){
		  $str="/* Round corner from */ \n";
		  for($i=1;$i<=$n;$i++){
			if($i==$n){$str.=".r".$i;}else{$str.=".r".$i.",";}
		  }
		  $str.="{display: block; height: 1px; background: ".$color."; overflow: hidden;} ";
		  $i=1;
		  $m=$n+$i;
		  while($i<$n){
			$str.=".r".$i."{ margin: 0 ".$m."px; }\n";
			$m-=2;
			$i++;
		  }
		  $str.=".r".$n."{ margin: 0 1px; height: ".$height."px; }\n";
		  $str.=".block-round-content  {background: ".$color."; /* Цвет фона */color: #fff;padding: ".$padding."px; /*  Поля вокруг текста */}";
		  return $str;
	    }
	    public function Check($mas){
		  $str='';
		  for($i=0;$i<count($mas);$i++){
			if(trim($mas[$i])!=''){
			      //$str.=$mas[$i];
			      if(strpos($mas[$i],'{')!==false){
				    $name=substr($mas[$i],0,strpos($mas[$i],'{'));
				    $body='';
			      }
			      if(isset($body))$body.=str_replace("\n", "", $mas[$i]);
			      if(strpos($mas[$i],'}')!==false&&isset($body)){
				    $this->elems[$name]=$body;
			      }
			}
		  }
		  $this->elems=array_unique ($this->elems);
		  foreach($this->elems as $key => $value){
			$str.=$value;
		  }
		  return $str;
	    }
	    public function Read(){
		  $files=array();
		  $fr=array();
		  for($i=0;$i<count($this->dirs);$i++){
			$directory=$this->dirs[$i]; 
			if(is_dir($directory)){
			      $d = @dir($directory);
			      while (false !==($file = $d->read())){
				    $exter=substr($file,strlen($file)-4,4);
				    if(strcmp($exter,'.css')===0&&strcmp($directory.$file,'css/'.$this->name)!==0){
					  $files[]=$directory.$file;
					  $fr=array_merge($fr,file($directory.'/'.$file));
				    }
			      }
			}
		  }
		  //var_dump($files);
			$this->source.=$this->MakeHead();
			$this->source.=$this->clear;
			$this->source.="\n";
			$this->source.=$this->MakeFont('fonts/lcsholbn-webfont.ttf','Lcsholbn');
			$fr=$this->ReplaceFont('Lcsholbn','##fontname##',$fr,1);
			$this->source.=$this->Check($fr);
		  }
	    public function Compress(){
	    
	    }
	    public function Write(){
		  if($handle = @fopen('css/'.$this->name,'w+')){
			fwrite($handle,$this->source);
			fclose($handle);
		  }
	    }
	    public function EchoMediaStyle(){
		 	//echo '<style type="text/css" media="';
		  echo "<style type=\"text/css\" media=\"";
		  if(isset($this->mobile)&&is_array($this->mobile)&&$this->mobile[1]){
			echo "handheld";
		  }else{
			echo "screen";
		  }
		  echo "\">\n";
		  echo "".$this->source."\n";
		  echo "</style>\n";
		  /*$str="<style type=\"text/css\" >".$this->source."\n</style>\n";
		  return $str;*/
	    }
	    public function Publish(){
		  echo '<link rel="stylesheet" type="text/css" href="css/'.$this->name.'">';
	    }
	    public function Style($dirs,$name,$type=0){
		  $this->name=$name;
		  $this->dirs=$dirs;
		  $this->source='';
		  $this->browser=$this->getBrowser();
		  $this->clear=$this->MakeClear();
		  $this->elems=array();
		  $this->errors=array();
		  $this->type=$type;
	    }
      }
      if(isset($_GET['type'])&&is_numeric($_GET['type'])){$type=intval($_GET['type']);}else{$type=1;}
      $name='css.css';
      $style=new Style(array('css/'),$name,$type);
      $style->Read();
      if($style->type==0){
	    $style->Write();
	    $style->Publish();
      }elseif($style->type==1){
	    $style->EchoMediaStyle();
      }elseif($style->type==2){
      	header('Content-type: text/css');
  			ob_start("compress");
  			if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start("compress");
  			function compress($buffer) {
    			/* remove comments */
    			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    			/* remove tabs, spaces, newlines, etc. */
    			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    			return $buffer;
  			}
  			echo compress($style->source);
  			ob_end_flush();
      }
?>