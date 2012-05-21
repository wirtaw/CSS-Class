<?php
      class JavaScript{
	    var $name;
	    var $dirs;
	    var $files;
	    var $source;
	    var $browser;
	    var $clear;
	    var $type;
	    var $elems=array();
	    var $errors=array();
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
	    public function Check($mas){
		  $str='';
		  for($i=0;$i<count($mas);$i++){
			if(trim($mas[$i])!=''){
			      //$str.=$mas[$i];
			      $str.=$mas[$i];
			}
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
				    $exter=substr($file,strlen($file)-3,3);
				    if(strcmp($exter,'.js')===0&&strcmp($directory.$file,'js/'.$this->name)!==0){
					  $files[]=$directory.$file;
				    }
			      }
			}
		  }
		  if(isset($this->files)&&is_array($this->files)&&count($this->files)>0){
			foreach($this->files as $key => $value){
			      $exter=substr($value,strlen($value)-3,3);
			      if(strcmp($exter,'.js')===0&&file_exists($value)&&strcmp($directory.$file,'js/'.$this->name)!==0){
					  $files[]=$value;
			      }
			}
		  }
		  //var_dump($files);
		  for($i=0;$i<count($files);$i++){
			$this->source=$this->Check(file($files[$i]));
			$this->source.="\n";
			//$fr=array_merge($fr,$f);
		  }
		  
		  //var_dump($this->source);
	    }
	    public function Compress(){
	    
	    }
	    public function EchoMediaStyle(){
		  //echo '<style type="text/css" media="';
		  echo "\n<script type=\"text/javascript\">\n";
		  echo "\n".$this->source."\n";
		  echo "</script>\n";
		  /*$str="<style type=\"text/css\" >".$this->source."\n</style>\n";
		  return $str;*/
	    }
	    public function Write(){
		  if($handle = @fopen('js/'.$this->name,'w+')){
			fwrite($handle,$this->source);
			fclose($handle);
		  }
	    }
	    public function Publish(){
		  echo '<script type="text/javascript" src="js/'.$this->name.'"></script>
			<script type="text/javascript">
			      hljs.tabReplace = \'     \';
			      hljs.initHighlightingOnLoad();
			</script>';
		  
	    }
	    public function JavaScript($dirs,$files,$name,$type=0){
		  $this->name=$name;
		  $this->dirs=$dirs;
		  $this->files=$files;
		  $this->source='';
		  $this->browser=$this->getBrowser();
		  $this->clear='';
		  $this->type=$type;
		  $this->elems=array();
		  $this->errors=array();
	    }
      }
      
      $name='scrpt.js';
      $scrpt=new JavaScript(array('js/'),array('highlight/highlight.pack.js'),$name,0);
      $scrpt->Read();
     // var_dump($style->elems);
      if($scrpt->type==0){
	   
	    $scrpt->Write();
	    $scrpt->Publish();
      }elseif($scrpt->type==1){
	    $scrpt->EchoMediaStyle();
      }
      echo "\n";
?>