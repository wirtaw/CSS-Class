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
	    public function mobile_device_detect($iphone=true,$ipad=true,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=true){	
		  $mobile_browser   = false; // set mobile browser as false till we can prove otherwise
		$user_agent       = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed
		$accept           = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed
		
		switch(true){ // using a switch against the following statements which could return true is more efficient than the previous method of using if statements
		
			case (preg_match('/ipad/i',$user_agent)); // we find the word ipad in the user agent
			$mobile_browser = $ipad; // mobile browser is either true or false depending on the setting of ipad when calling the function
			$status = 'Apple iPad';
			if(substr($ipad,0,4)=='http'){ // does the value of ipad resemble a url
				$mobileredirect = $ipad; // set the mobile redirect url to the url value stored in the ipad value
			} // ends the if for ipad being a url
			break; // break out and skip the rest if we've had a match on the ipad // this goes before the iphone to catch it else it would return on the iphone instead
			
			case (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent)); // we find the words iphone or ipod in the user agent
			$mobile_browser = $iphone; // mobile browser is either true or false depending on the setting of iphone when calling the function
			$status = 'Apple';
			if(substr($iphone,0,4)=='http'){ // does the value of iphone resemble a url
				$mobileredirect = $iphone; // set the mobile redirect url to the url value stored in the iphone value
			} // ends the if for iphone being a url
			break; // break out and skip the rest if we've had a match on the iphone or ipod
			
			case (preg_match('/android/i',$user_agent));  // we find android in the user agent
			$mobile_browser = $android; // mobile browser is either true or false depending on the setting of android when calling the function
			$status = 'Android';
			if(substr($android,0,4)=='http'){ // does the value of android resemble a url
				$mobileredirect = $android; // set the mobile redirect url to the url value stored in the android value
			} // ends the if for android being a url
			break; // break out and skip the rest if we've had a match on android
			
			case (preg_match('/opera mini/i',$user_agent)); // we find opera mini in the user agent
			$mobile_browser = $opera; // mobile browser is either true or false depending on the setting of opera when calling the function
			$status = 'Opera';
			if(substr($opera,0,4)=='http'){ // does the value of opera resemble a rul
				$mobileredirect = $opera; // set the mobile redirect url to the url value stored in the opera value
			} // ends the if for opera being a url 
			break; // break out and skip the rest if we've had a match on opera
			
			case (preg_match('/blackberry/i',$user_agent)); // we find blackberry in the user agent
			$mobile_browser = $blackberry; // mobile browser is either true or false depending on the setting of blackberry when calling the function
			$status = 'Blackberry';
			if(substr($blackberry,0,4)=='http'){ // does the value of blackberry resemble a rul
				$mobileredirect = $blackberry; // set the mobile redirect url to the url value stored in the blackberry value
			} // ends the if for blackberry being a url 
			break; // break out and skip the rest if we've had a match on blackberry
			
			case (preg_match('/(palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent)); // we find palm os in the user agent - the i at the end makes it case insensitive
			$mobile_browser = $palm; // mobile browser is either true or false depending on the setting of palm when calling the function
			$status = 'Palm';
			if(substr($palm,0,4)=='http'){ // does the value of palm resemble a rul
				$mobileredirect = $palm; // set the mobile redirect url to the url value stored in the palm value
			} // ends the if for palm being a url 
			break; // break out and skip the rest if we've had a match on palm os
			
			case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent)); // we find windows mobile in the user agent - the i at the end makes it case insensitive
			$mobile_browser = $windows; // mobile browser is either true or false depending on the setting of windows when calling the function
			$status = 'Windows Smartphone';
			if(substr($windows,0,4)=='http'){ // does the value of windows resemble a rul
				$mobileredirect = $windows; // set the mobile redirect url to the url value stored in the windows value
			} // ends the if for windows being a url 
			break; // break out and skip the rest if we've had a match on windows
			
			case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i',$user_agent));
             // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive
			$mobile_browser = true; // set mobile browser to true
			$status = 'Mobile matched on piped preg_match';
			break; // break out and skip the rest if we've preg_match on the user agent returned true 
			
			case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0)); // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml
			$mobile_browser = true; // set mobile browser to true
			$status = 'Mobile matched on content accept header';
			break; // break out and skip the rest if we've had a match on the content accept headers
			
			case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])); // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this
			$mobile_browser = true; // set mobile browser to true
			$status = 'Mobile matched on profile headers being set';
			break; // break out and skip the final step if we've had a return true on the mobile specfic headers
			
			case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso',
            '4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i',
            '505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s',
            '802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn',
            'alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ',
            'aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco',
            'alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw',
            'aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird',
            'bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb',
            'blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi',
            'cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s',
            'dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi',
            'dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0',
            'esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos',
            'ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa',
            'fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u',
            'g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w',
            'good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p',
            'hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c',
            'htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp',
            'htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita',
            'huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma',
            'i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01',
            'im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java',
            'kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-',
            'klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b',
            'lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k',
            'lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s',
            'lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l',
            'lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/',
            'lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/',
            'maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi',
            'meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02',
            'mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50',
            'mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc',
            'mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100',
            'n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300',
            'n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700',
            'n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg',
            'neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x',
            'o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran',
            'p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3',
            'pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil',
            'pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire',
            'pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2',
            'qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12',
            'qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap',
            'qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9',
            'rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01',
            'sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-',
            'sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar',
            'sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3',
            'smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-',
            'sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo',
            'send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft',
            'sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600',
            't610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm',
            'tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5',
            'tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl',
            'hiba'=>'hiba','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400',
            'v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50',
            'vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg',
            'vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-',
            'wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ',
            'wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa',
            'waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu',
            'x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your',
            'zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca',
            'amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq',
            'bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw',
            'bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-',
            'dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc',
            'hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom',
            'inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java',
            'jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok',
            'leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-',
            'libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp',
            'mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto',
            'mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6',
            'noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana',
            'pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc',
            'port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo',
            'sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-',
            'sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar',
            'sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony',
            'sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-',
            'tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi',
            'vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60',
            'vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83',
            'vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp',
            'wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb',
            'xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match
			$mobile_browser = true; // set mobile browser to true
			$status = 'Mobile matched on in_array';
			break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it
			
			default;
			$mobile_browser = false; // set mobile browser to false
			$status = 'Desktop / full capability browser';
			break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it
			
		} // ends the switch 
		
		// tell adaptation services (transcoders and proxies) to not alter the content based on user agent as it's already being managed by this script, some of them suck though and will disregard this....
		// header('Cache-Control: no-transform'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
		// header('Vary: User-Agent, Accept'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
		
		// if redirect (either the value of the mobile or desktop redirect depending on the value of $mobile_browser) is true redirect else we return the status of $mobile_browser
		if($redirect = ($mobile_browser==true) ? $mobileredirect : $desktopredirect){
			//header('Location: http://www.poplauki.eu/buttons/detect.php'); // redirect to the right url for this device
			
			//exit;
			return array("redirect",$mobile_browser,$status);
		}else{ 
			// a couple of folkas have asked about the status - that's there to help you debug and understand what the script is doing
			return array("no redirect",$mobile_browser,$status); // is a mobile so we are returning an array ['0'] is true ['1'] is the $status value
		}
	    }
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
	    public function MakeHead2(){
		  return '/* Generate at '.date('Y-M-j H-i-s').' */
/* for mobile '.$this->mobile[2].' */';
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
	     public function MakeClear2(){
		  $str='/* How to create css stylesheets for mobile devices like tablets, mobile phones,
blackberry phones, android phones and iphones. */
/* http://www.seabreezecomputers.com/tips/mobile-css.htm */
/* If you have set your body tag or a wrapper div with class=\'wrapper\' in your desktop styles.css
   to a specific width then you will want to change it to width: auto;
   You may also have set a min-width in styles.css.  Best to change that to 0px
*/
body, .wrapper
{
   width: auto;
   /* max-width: 320px; */ /* max_width works with iPhones, but doesn\'t format well with new Android phones and devices that are wider than 320px */
   min-width: 0px;
}
/* There is no need to have a giant header on a small mobile screen */
h1
{
   font-size: 1em;
}
/* As a matter of fact, if you have any Divs with a set width you will want to change their class
   to have width: auto;
   Sometimes width: 100%; works better, so play with both
*/
.commentbox, .iframe_box,
{
   width: 100%;
}
/* Some images you may want to change the width to less than the width of the screen */
.photo img
{
   max-width: 160px;
}
/* If you have any pop-up help windows that appear in the middle of the screen or have a left
   of something like left: 100px; then you will want them to be closer to the left side
   of the screen, so that it appears correctly on the smaller displays
*/
.helpwindow
{
   left: 1px;
}
/* There are some elements of the webpage that you just won\'t want to display on a mobile device.
   For this page we don\'t want to display the normal google ads because they take up too much room
   on a mobile phone. So I have made two DIVs around the google ads with a class of google_top
   for the top one and google_left for the left one.
*/
.google_top, .google_left
{
   display: none;
}
/* But you may want to put in a special google mobile ad.  Surround that ad with a DIV with class=\'google_mobile\'.
   In the desktop stylesheet (styles.css) you would have display: none; for that class.  But in the mobile
   stylesheet you have display: block
*/
.google_mobile
{
   float: none;
   display: block;
}
/* On the desktop stylesheet you probably have many floats for side menus or ads next to elements in the page.
   You will want to cancel all these floats so that users don\'t have to scroll left and right to see everything
   on the page.  If you decide to include your side menu it will appear above the content of your page.  Make
   sure you set the width to auto or 100%
*/
.sidemenu
{
   padding: 0px;
   margin: 0px;
   width: 100%;
   float: none;
}
/* In a side menu you usually place anchor links or buttons.
If you have each link displayed as block you may want to let
them float next to each other so that they don\'t take up as much room vertically.
Put some margin around them so they are easy to press with a finger.
*/
.sidemenu a
{
   padding: 1px;
   margin: 3px;
   float: left;
}
.sidemenu a:hover
{
   padding: 1px;
   margin: 3px;
   float: left;
}
/* If you have input form elements of type=\'text\' that have a very long length attribute, you will
	want to stop using length and use a css width instead.  For mobile use width: auto;
*/
.input
{
	width: auto;
}	
/*If you have a textarea that has a wide
	cols attribute you will want to change it to use width: 100%
*/
textarea
{
	width: 100%;
}
/* Sometimes you might have a really wide table or div or pre that just won\'t fit in the width of a
mobile device causing the page to have to scroll sideways (horizontally) to view the whole
div or table.  Add the following break_word class and the table or div will even split in
the middle of words to try to format it to the width of the device:
Examples: <table class=\'break_word\'> or <div class=\'break_word\'>
*/
.break_word
{
	width: auto; 
	word-wrap: break-word; 
	word-break: break-all;
	white-space: pre-wrap;       /* css-3 */
	white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	word-wrap: break-word;       /* Internet Explorer 5.5+ */
}';

		  return $str;
	    }
	    public function MakeButtons($backgrcolor,$size,$strength,$padding,$margin){
		  $str="/* Make buttons http://mainview.ru/css/kak-sozdat-knopki-so-znachkami-bez-izobrazhenij-pri-pomoshhi-css3?utm_source=feedburner&utm_medium=feed&utm_campaign=Feed%3A+mainviewru+%28Main+View+-+%D0%9A%D0%BE%D0%BF%D0%B8%D0%BB%D0%BA%D0%B0+%D1%80%D0%B0%D0%B7%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%87%D0%B8%D0%BA%D0%B0%29 */ \n.buttons{
display: inline-block;
white-space: nowrap;
background: ".$backgrcolor."; /* Old browsers */\n";
		  switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']>=3.6){
				    $str.='background: -moz-linear-gradient(top, #eeeeee 0%, #eeeeee 100%); /* FF3.6+ */';
			      }
			break;
			case 'Internet Explorer':
			      if((int)$this->browser['version']<=9){
				    $str.='filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#eeeeee\', endColorstr=\'#eeeeee\',GradientType=0 ); /* IE6-9 */';
			      }elseif((int)$this->browser['version']>=10){
				    $str.='background: -ms-linear-gradient(top, #eeeeee 0%,#eeeeee 100%); /* IE10+ */';
			      }
			break;
			case 'Google Chrome':
			      if((int)$this->browser['version']<10){
				    $str.='background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#eeeeee)); /* Chrome,Safari4+ */';
			      }elseif((int)$this->browser['version']>=10){
				    $str.='background: -webkit-linear-gradient(top, #eeeeee 0%,#eeeeee 100%); /* Chrome10+,Safari5.1+ */';
			      }
			break;
			case 'Opera':
			      if((double)$this->browser['version']>=11.10){
				    $str.='background: -o-linear-gradient(top, #eeeeee 0%,#eeeeee 100%); /* Opera11.10+ */';
			      }
			break;
			case 'Apple Safari':
			      if((int)$this->browser['version']<=4){
				    $str.='background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#eeeeee)); /* Chrome,Safari4+ */';
			      }elseif((double)$this->browser['version']>=5.1){
				    $str.='background: -webkit-linear-gradient(top, #eeeeee 0%,#eeeeee 100%); /* Chrome10+,Safari5.1+ */';
			      }
			break;
			case 'Netscape':
			      $str.='background: linear-gradient(top, #eeeeee 0%,#eeeeee 100%);';
			break;
		  }
		  //background: linear-gradient(top, #eeeeee 0%,#eeeeee 100%); /* W3C */
		  $str.="\n
border: 1px solid #a1a1a1;
padding: ".$padding[0]." ".$padding[1]." ".$padding[2]." ".$padding[3].";
margin: ".$margin[0]." ".$margin[1]." ".$margin[2]." ".$margin[3].";
font: bold ".$size."em/".($size*2)."em Arial, Helvetica;
text-decoration: none;
color: #333;
text-shadow: 0 1px 0 rgba(255,255,255,.8);\n";
		switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']>=3.5){
				    $str.='-moz-border-radius: .2em;
				    -moz-box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);
border-radius: .2em;
box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Internet Explorer':
			      if((int)$this->browser['version']>=9){
				    $str.='border-radius: .2em;
				    box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Google Chrome':
			      if((int)$this->browser['version']>1){
				    $str.='-webkit-border-radius: .2em;
-webkit-box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);
border-radius: .2em;
box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Opera':
			      if((double)$this->browser['version']>=10.5){
				    $str.='border-radius: .2em;
				    box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Apple Safari':
			      if((int)$this->browser['version']>=4){
				    $str.='-webkit-border-radius: .2em;
-webkit-box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);
border-radius: .2em;
box-shadow: 0 0 1px 1px rgba(255,255,255,.8) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Netscape':
			      $str.='background: linear-gradient(top, #eeeeee 0%,#eeeeee 100%);';
			break;
		  }  
$str.="}\n
.buttons:hover
{
background: #ffffff; /* Old browsers */
";
		  switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']>=3.6){
				    $str.='background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* FF3.6+ */';
			      }
			break;
			case 'Internet Explorer':
			      if((int)$this->browser['version']<=9){
				    $str.="filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */";
			      }elseif((int)$this->browser['version']>=10){
				    $str.='background: -ms-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* IE10+ */';
			      }
			break;
			case 'Google Chrome':
			      if((int)$this->browser['version']<10){
				    $str.='background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */';
			      }elseif((int)$this->browser['version']>=10){
				    $str.='background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */';
			      }
			break;
			case 'Opera':
			      if((double)$this->browser['version']>=11.10){
				    $str.='background: -o-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Opera11.10+ */';
			      }
			break;
			case 'Apple Safari':
			      if((int)$this->browser['version']<=4){
				    $str.='background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */';
			      }elseif((double)$this->browser['version']>=5.1){
				    $str.='background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */';
			      }
			break;
			case 'Netscape':
			      $str.='background: linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* W3C */';
			break;
		  }
		  //background: linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* W3C */
$str.="
}
.buttons:active
{
        ";
		  switch ($this->browser['name']){
			case 'Mozilla Firefox':
			      if((double)$this->browser['version']>=3.5){
				    $str.='-moz-box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);
				    box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Internet Explorer':
			      if((int)$this->browser['version']>=9){
				    $str.='box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Google Chrome':
			      if((int)$this->browser['version']>1){
				    $str.='-webkit-box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Opera':
			      if((double)$this->browser['version']>=10.5){
				    $str.='box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Apple Safari':
			      if((int)$this->browser['version']>=4){
				    $str.='-webkit-box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);
				    box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			      }
			break;
			case 'Netscape':
			      $str.='box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset, 0 1px 0 rgba(0,0,0,.3);';
			break;
		  } 
$str.="
position: relative;
        top: 1px;
}
.buttons:focus
{
        outline: 0;
        background: #fafafa;
}
.buttons:before
{
        float: left;
        width: 1em;
        text-align: center;
        font-size: 1.7em;
        margin: 0 0.5em 0 -1em;
        padding: 0 .2em;
	pointer-events: none;
}
/* buttons */\n";
$str.='
/*Forms*/
.add:before {   content: "\271A"; }
.edit:before {  content: "\270E"; }
.delete:before{ content: "\2718";}
.save:before{   content: "\2714";}
.email:before{  content: "\2709";}
.cross:before { content: "\2716"; }
/*Currency*/
.dollar:before{ content:"\0024"; }
.euro:before{ content:"\20AC"; }
.pound:before{  content: "\00A3";}
.cent:before { content: "\20B5"; }
/*Temp*/
.celsius:before { content: "\2103"; }
.fahrenheit:before { content: "\2109"; }
/*Math & Factions*/
.pi:before { content: "\213C"; }
.one_thrid:before { content: "\2153"; }
.two_thrid:before { content: "\2154"; }
.one_fifth:before { content: "\2155"; }
.two_fifth:before { content: "\2156"; }
.three_fifth:before { content: "\2157"; }
.four_fifth:before { content: "\2158"; }
.one_sixth:before { content: "\2159"; }
.five_sixth:before { content: "\215A"; }
.one_eighth:before { content: "\215B"; }
.three_eighth:before { content: "\215C"; }
.five_eighth:before { content: "\215D"; }
.seven_eighth:before { content: "\215E"; }
.quarter:before { content: "\00BC"; }
.half:before { content: "\00BD"; }
.three_quarter:before { content: "\00BE"; }
/*Arrows*/
.next:before{   content: "\279C";}
.left_arrow:before { content: "\2190"; }
.up_arrow:before { content: "\2191"; }
.right_arrow:before { content: "\2192"; }
.down_arrow:before { content: "\2193"; }
.up_left_arrow:before { content: "\2196"; }
.up_right_arrow:before { content: "\2197"; }
.down_left_arrow:before { content: "\2199"; }
.down_right_arrow:before { content: "\2198"; }
/*Symbols*/
.like:before{   content: "\2764";}
.star:before{   content: "\2605";}
.spark:before{  content: "\2737";}
.play:before{   content: "\25B6";}
.blacksun:before { content: "\2600"; }
.cloud:before { content: "\2601"; }
.umbrella:before { content: "\2602"; }
.snowman:before { content: "\2603"; }
.blackstar:before { content: "\2605"; }
.whitestar:before { content: "\2606"; }
.blackphone:before { content: "\260E"; }
.saltire:before { content: "\2613"; }
.hot_drink:before { content: "\2615"; }
.skull:before { content: "\2620"; }
.radioactive:before { content: "\2622"; }
.biohazard:before { content: "\2623"; }
.peace:before { content: "\262E"; }
.yingyang:before { content: "\262F"; }
.frowning_face:before { content: "\2639"; }
.smiling_face:before { content: "\263A"; }
.first_quarter_moon:before { content: "\263D"; }
.last_quarter_moon:before { content: "\263E"; }
.wheelchair:before { content: "\267F"; }
.recycle:before { content: "\267D"; }
.recycle2:before { content: "\267C"; }
.music_note:before { content: "\266C"; }
.warning:before { content: "\26A0"; }
.male_and_female:before { content: "\26A4"; }
.scissors:before { content: "\2701"; }
.airplane:before { content: "\2708"; }
.snow:before { content: "\2042"; }
';
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
		  if(isset($this->mobile)&&is_array($this->mobile)&&$this->mobile[1]){
			$this->source.=$this->MakeHead2();
			$this->source.=$this->MakeClear2();
		  }else{
			$this->source.=$this->MakeHead();
			$this->source.=$this->clear;
			$this->source.="\n";
			$this->source.=$this->MakeFont('fonts/lcsholbn-webfont.ttf','Lcsholbn');
			$fr=$this->ReplaceFont('Lcsholbn','##fontname##',$fr,1);
			$this->source.=$this->Check($fr);
		  }
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
		  $this->mobile=$this->mobile_device_detect();
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