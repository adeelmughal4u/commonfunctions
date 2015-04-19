<?php
/**
###################################################################
# Copyright (c) 2015 Adeel Mughal
# URL:              [url]http://askadeel.com[/url]
# Function:         Various
# Author:           Adeel Mughal
# Language:         PHP
# License:          Attribution Assurance License
# [url]http://www.opensource.org/licenses/attribution.php[/url]
# Version:          $Id: functions.php 1.5 $
# Last Modified:    $Date: 2015-10-11 01:00:00 $
# Notice:           Please maintain this section
####################################################################
*/

	//This Funtion is use to get CURRENT PAGE DIRECT URL
	function curPageURL()
	{
 		$pageURL = 'http';
		if (@$_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
		}
		$pageURL .= "://";
 		$pageURL .= $_SERVER['SERVER_NAME'];
		$pageURL .= $_SERVER['PHP_SELF'];
		$query_string = $_SERVER['QUERY_STRING'];
		if(!empty($query_string)){
		$pageURL .= '?'.$query_string;
		}
 		return $pageURL;
	}
	
	//QuotesReplace
	function Replacer($string)
	{
	//Wp-Magic Quotes
	$string = preg_replace("/'s/", '&#8217;s', $string);
	$string = preg_replace("/'(\d\d(?:&#8217;|')?s)/", "&#8217;$1", $string);
	$string = preg_replace('/(\s|\A|")\'/', '$1&#8216;', $string);
	$string = preg_replace('/(\d+)"/', '$1&#8243;', $string);
	$string = preg_replace("/(\d+)'/", '$1&#8242;', $string);
	$string = preg_replace("/(\S)'([^'\s])/", "$1&#8217;$2", $string);
	$string = preg_replace('/(\s|\A)"(?!\s)/', '$1&#8220;$2', $string);
	$string = preg_replace('/"(\s|\S|\Z)/', '&#8221;$1', $string);
	$string = preg_replace("/'([\s.]|\Z)/", '&#8217;$1', $string);
	$string = preg_replace("/ \(tm\)/i", ' &#8482;', $string);
	$string = str_replace("''", '&#8221;', $string);

	$array = array('/& /');
	$replace = array('&amp; ') ;
	return $string = preg_replace($array,$replace,$string);
	}
	//This Funtion is used to clean a String
	
	function clean($string,$allow_html=false) {
 	 //$string = $string;
 	 //$string = htmlentities($string);
	 if($allow_html==false){
 		 $string = 	strip_tags($string);
		 $string =  Replacer($string);
	 }
	// $string = utf8_encode($string);
 	 return $string;
	}
	
	function cb_clean($string,$array=array('no_html'=>true,'mysql_clean'=>false))
	{
		if($array['no_html'])
			$string = htmlentities($string);
		if($array['special_html'])
			$string = htmlspecialchars($string);
		if($array['mysql_clean'])
			$string = mysql_real_escape_string($string);
		if($array['nl2br'])
			$string = nl2br($string);
		return $string;
	}
	
	//This Fucntion is for Securing Password, you may change its combination for security reason but make sure dont not rechange once you made your script run
	
	function pass_code($string) {
 	 $password = md5(md5(sha1(sha1(md5($string)))));
 	 return $password;
	}
	
	//Mysql Clean Queries
	function sql_free($id)
	{
		if (!get_magic_quotes_gpc())
		{
			$id = addslashes($id);
		}
		return $id;
	}
	
	
	function mysql_clean($id,$replacer=true){
		//$id = clean($id);
		
		if (get_magic_quotes_gpc())
		{
			$id = stripslashes($id);
		}
		$id = htmlspecialchars(mysql_real_escape_string($id));
		if($replacer)
			$id = Replacer($id);
		return $id;
	}
	
	function escape_gpc($in)
	{
		if (get_magic_quotes_gpc())
		{
			$in = stripslashes($in);
		}
		return $in;
	}
	
	
	//Redirect Using JAVASCRIPT
	
	function redirect_to($url){
		echo '<script type="text/javascript">
		window.location = "'.$url.'"
		</script>';
		exit("Javascript is turned off, <a href='$url'>click here to go to requested page</a>");
		}
	
	
	//Funtion of Random String
	function RandomString($length)
	{
		$string = md5(microtime());
		$highest_startpoint = 32-$length;
		$randomString = substr($string,rand(0,$highest_startpoint),$length);
		return $randomString;
	
	}
				
	/**
	 * Function used to wrap email content in 
	 * HTML AND BODY TAGS
	 */
	function wrap_email_content($content)
	{
		return '<html><body>'.$content.'</body></html>';
	}
	
	/**
	 * Function used to get file name
	 */
	function GetName($file)
	{
		if(!is_string($file))
			return false;
		$path = explode('/',$file);
		if(is_array($path))
			$file = $path[count($path)-1];
		$new_name 	 = substr($file, 0, strrpos($file, '.'));
		return $new_name;
	}

        function get_elapsed_time($ts,$datetime=1)
        {
          if($datetime == 1)
          {
          $ts = date('U',strtotime($ts));
          }
          $mins = floor((time() - $ts) / 60);
          $hours = floor($mins / 60);
          $mins -= $hours * 60;
          $days = floor($hours / 24);
          $hours -= $days * 24;
          $weeks = floor($days / 7);
          $days -= $weeks * 7;
          $t = "";
          if ($weeks > 0)
            return "$weeks week" . ($weeks > 1 ? "s" : "");
          if ($days > 0)
            return "$days day" . ($days > 1 ? "s" : "");
          if ($hours > 0)
            return "$hours hour" . ($hours > 1 ? "s" : "");
          if ($mins > 0)
            return "$mins min" . ($mins > 1 ? "s" : "");
          return "< 1 min";
        }

	//Function Used TO Get Extensio Of File
		function GetExt($file){
			return substr($file, strrpos($file,'.') + 1);
			}

	function old_set_time($temps)
	{
			round($temps);
			$heures = floor($temps / 3600);
			$minutes = round(floor(($temps - ($heures * 3600)) / 60));
			if ($minutes < 10)
					$minutes = "0" . round($minutes);
			$secondes = round($temps - ($heures * 3600) - ($minutes * 60));
			if ($secondes < 10)
					$secondes = "0" .  round($secondes);
			return $minutes . ':' . $secondes;
	}
	function SetTime($sec, $padHours = true) {
	
		if($sec < 3600)
			return old_set_time($sec);
			
		$hms = "";
	
		// there are 3600 seconds in an hour, so if we
		// divide total seconds by 3600 and throw away
		// the remainder, we've got the number of hours
		$hours = intval(intval($sec) / 3600);
	
		// add to $hms, with a leading 0 if asked for
		$hms .= ($padHours)
			  ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
			  : $hours. ':';
	
		// dividing the total seconds by 60 will give us
		// the number of minutes, but we're interested in
		// minutes past the hour: to get that, we need to
		// divide by 60 again and keep the remainder
		$minutes = intval(($sec / 60) % 60);
	
		// then add to $hms (with a leading 0 if needed)
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
	
		// seconds are simple - just divide the total
		// seconds by 60 and keep the remainder
		$seconds = intval($sec % 60);
	
		// add to $hms, again with a leading 0 if needed
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	
		return $hms;
	}
	
	//Simple Validation
	function isValidText($text){
      $pattern = "^^[_a-z0-9-]+$";
      if (eregi($pattern, $text)){
         return true;
      	}else {
         return false;
      }   
   }
   
   //Simple Width Fetcher
   function getWidth($file)
   {
		$sizes = getimagesize($file);
		if($sizes)
			return $sizes[0];   
   }
   
   //Simple Height Fetcher
   function getHeight($file)
   {
		$sizes = getimagesize($file);
		if($sizes)
			return $sizes[1];   
   }
         
   //Function Used To Validate Email
	
	function isValidEmail($email){
      $pattern = "/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
	  preg_match($pattern, $email,$matches);
      if ($matches[0]!=''){
         return true;
      }
      else {
		 	return true;
      }   
   }

   
   	// THIS FUNCTION SETS HTMLSPECIALCHARS_DECODE IF FUNCTION DOESN'T EXIST
	// INPUT: $text REPRESENTING THE TEXT TO DECODE
	//	  $ent_quotes (OPTIONAL) REPRESENTING WHETHER TO REPLACE DOUBLE QUOTES, ETC
	// OUTPUT: A STRING WITH HTML CHARACTERS DECODED
	if(!function_exists('htmlspecialchars_decode')) {
		function htmlspecialchars_decode($text, $ent_quotes = "") {
		$text = str_replace("&quot;", "\"", $text);
		$text = str_replace("&#039;", "'", $text);
		$text = str_replace("&lt;", "<", $text);
		$text = str_replace("&gt;", ">", $text);
		$text = str_replace("&amp;", "&", $text);
		return $text;
		}
	} // END htmlspecialchars() FUNCTION
	
	//THIS FUNCTION IS USED TO LIST FILE TYPES IN FLASH UPLOAD
	//INPUT FILE TYPES
	//OUTPUT FILE TYPE IN PROPER FORMAT
	function ListFileTypes($types){
		$types_array = preg_replace('/,/',' ',$types);
		$types_array = explode(' ',$types_array);
		$list = 'Video,';
		for($i=0;$i<=count($types_array);$i++){
		if($types_array[$i]!=''){
		$list .= '*.'.$types_array[$i];
		if($i!=count($types_array))$list .= ';';
		}
		}
	return $list;
	}
	
	
	
	
	/**
	 * Get Directory Size
	 */
	function get_directory_size($path)
	{
		$totalsize = 0;
		$totalcount = 0;
		$dircount = 0;
		if ($handle = opendir ($path))
		{
		while (false !== ($file = readdir($handle)))
		{
		  $nextpath = $path . '/' . $file;
		  if ($file != '.' && $file != '..' && !is_link ($nextpath))
		  {
			if (is_dir ($nextpath))
			{
			  $dircount++;
			  $result = get_directory_size($nextpath);
			  $totalsize += $result['size'];
			  $totalcount += $result['count'];
			  $dircount += $result['dircount'];
			}
			elseif (is_file ($nextpath))
			{
			  $totalsize += filesize ($nextpath);
			  $totalcount++;
			}
		  }
		}
		}
		closedir ($handle);
		$total['size'] = $totalsize;
		$total['count'] = $totalcount;
		$total['dircount'] = $dircount;
		return $total;
	}
	
	//FUNCTION USED TO FORMAT FILE SIZE
	//INPUT BYTES
	//OUTPT MB , Kib
	function formatfilesize( $data ) {
        // bytes
        if( $data < 1024 ) {
            return $data . " bytes";
        }
        // kilobytes
        else if( $data < 1024000 ) {
				return round( ( $data / 1024 ), 1 ) . "KB";
        }
        // megabytes
        else if($data < 1024000000){
            return round( ( $data / 1024000 ), 1 ) . " MB";
        }else{
			 return round( ( $data / 1024000000 ), 1 ) . " GB";
		}
    
    }
	 		
	/**
	 * Function used to tell ClipBucket that it has closed the script
	 */
	function the_end()
	{
		if(!$isWorthyBuddy) 
		{		
				//Dear user, i have spent too much time of my life on developing
				//This software and if you want to return me in this way, 
				//its ok for me, but for those who told you how to do this...
				
				echo 'i dont care if you try to play with my code, but what really pisses me off
						is INSULT';
		}
	}
		
	/**
	* FUNCTION USED TO CLEAN VALUES THAT CAN BE USED IN FORMS
	*/
	function cleanForm($string)
	{
		if(is_string($string))
			$string = htmlspecialchars($string);
		if(get_magic_quotes_gpc())
			if(!is_array($string))
			$string = stripslashes($string);			
		return $string;
	}
	function form_val($string){return cleanForm($string); }
		
	/**
	* FUNCTION USED TO MAKE TAGS MORE PERFECT
	* @Author : Adeel Mughal <adeelmughal4u@gmail.com>
	* @param tags text unformatted
	* returns tags formatted
	*/
	function genTags($tags,$sep=',')
	{
		//Remove fazool spaces
		$tags = preg_replace(array('/ ,/','/, /'),',',$tags);
		$tags = preg_replace( "`[,]+`" , ",", $tags);
		$tag_array = explode($sep,$tags);
		foreach($tag_array as $tag)
		{
			if(isValidtag($tag))
			{
				$newTags[] = $tag;
			}
			
		}
		//Creating new tag string
		if(is_array($newTags))
			$tagString = implode(',',$newTags);
		else
			$tagString = 'no-tag';
		return $tagString;
	}
	
	/**
	* FUNCTION USED TO VALIDATE TAG
	* @Author : Adeel Mughal <adeelmughal4u@gmail.com>
	* @param tag
	* return true or false
	*/
	function isValidtag($tag)
	{
		$disallow_array = array
		('of','is','no','on','off','a','the','why','how','what','in');
		if(!in_array($tag,$disallow_array) && strlen($tag)>2)
			return true;
		else
			return false;
	}
	
	
	/**
	 * Function used to return mysql time
	 * @author : Fwhite
	 */
	function NOW()
	{
		return date('Y-m-d H:i:s', time());
	}
	
	/**
	 * Function used to check field directly
	 */
	function validate_field($code,$text)
	{
		$syntax =  get_re($code);
		if(empty($syntax))
			return true;
		return check_regular_expression($syntax,$text);
	}
	
	function is_valid_syntax($code,$text)
	{
		if(DEVELOPMENT_MODE && DEV_INGNORE_SYNTAX)
			return true;
		return validate_field($code,$text);
	}
	
	/**
	 * Function used to validate YES or NO input
	 */
	function yes_or_no($input,$return=yes)
	{
		$input = strtolower($input);
		if($input!=yes && $input !=no)
			return $return;
		else
			return $input;
	}
		 
	/**
	 * Function in case htmlspecialchars_decode does not exist
	 */
	function unhtmlentities ($string)
	{
		$trans_tbl =get_html_translation_table (HTML_ENTITIES );
		$trans_tbl =array_flip ($trans_tbl );
		return strtr ($string ,$trans_tbl );
	}
	 
	/**
	 * Function used to give output in proper form 
	 */
	function input_value($params)
	{
		$input = $params['input'];
		$value = $input['value'];
		
		if($input['value_field']=='checked')
			$value = $input['checked'];
			
		if($input['return_checked'])
			return $input['checked'];
			
		if(function_exists($input['display_function']))
			return $input['display_function']($value);
		elseif($input['type']=='dropdown')
		{
			if($input['checked'])
				return $value[$input['checked']];
			else
				return $value[0];
		}else
			return $input['value'];
	}	
	
	/**
	 * Function used to get post var
	 */
	function post($var)
	{
		return $_POST[$var];
	}
	
	/** 
	 * Function used to count age from date
	 */
	function get_age($input)
	{ 
		$time = strtotime($input);
		$iMonth = date("m",$time);
		$iDay = date("d",$time);
		$iYear = date("Y",$time);
		
		$iTimeStamp = (mktime() - 86400) - mktime(0, 0, 0, $iMonth, $iDay, $iYear); 
		$iDays = $iTimeStamp / 86400;  
		$iYears = floor($iDays / 365 );  
		return $iYears; 
	}		
			
	/**
	 * @Script : function
	 * @Author : Adeel Mughal
	 * @License : LA
	 * @Since : 2015
	 *
	 * function whos_your_daddy
	 * Simply tells the name of  script owner
	 * @return INTELLECTUAL BADASS
	 */
	function whos_your_daddy()
	{
		echo  "<h1>Adeel Mughal</h1>";
	}
	
	function array2xml($array, $level=1)
	{
		$xml = '';
		// if ($level==1) {
		//     $xml .= "<array>\n";
		// }
		foreach ($array as $key=>$value) {
		$key = strtolower($key);
		if (is_object($value)) {$value=get_object_vars($value);}// convert object to array
		
		if (is_array($value)) {
			$multi_tags = false;
			foreach($value as $key2=>$value2) {
			 if (is_object($value2)) {$value2=get_object_vars($value2);} // convert object to array
				if (is_array($value2)) {
					$xml .= str_repeat("\t",$level)."<$key>\n";
					$xml .= array2xml($value2, $level+1);
					$xml .= str_repeat("\t",$level)."</$key>\n";
					$multi_tags = true;
				} else {
					if (trim($value2)!='') {
						if (htmlspecialchars($value2)!=$value2) {
							$xml .= str_repeat("\t",$level).
									"<$key2><![CDATA[$value2]]>". // changed $key to $key2... didn't work otherwise.
									"</$key2>\n";
						} else {
							$xml .= str_repeat("\t",$level).
									"<$key2>$value2</$key2>\n"; // changed $key to $key2
						}
					}
					$multi_tags = true;
				}
			}
			if (!$multi_tags and count($value)>0) {
				$xml .= str_repeat("\t",$level)."<$key>\n";
				$xml .= array2xml($value, $level+1);
				$xml .= str_repeat("\t",$level)."</$key>\n";
			}
		
		 } else {
			if (trim($value)!='') {
			 echo "value=$value<br>";
				if (htmlspecialchars($value)!=$value) {
					$xml .= str_repeat("\t",$level)."<$key>".
							"<![CDATA[$value]]></$key>\n";
				} else {
					$xml .= str_repeat("\t",$level).
							"<$key>$value</$key>\n";
				}
			}
		}
		}
		//if ($level==1) {
		//    $xml .= "</array>\n";
		// }
		
		return $xml;
	}		
			


    function get_server_protocol()
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
        {
            return 'https://';
        }
        else
        {
            $protocol = preg_replace('/^([a-z]+)\/.*$/', '\\1', strtolower($_SERVER['SERVER_PROTOCOL']));
            $protocol .= '://';
            return $protocol;
        }
    }
	
    /*
        extract the file extension from any given path or url.
        source: http://www.php.net/manual/en/function.basename.php#89127
    */
    function fetch_file_extension($filepath)
    {
        preg_match('/[^?]*/', $filepath, $matches);
        $string = $matches[0];

        $pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

        # check if there is any extension
        if(count($pattern) == 1)
        {
            // no file extension found
            return;
        }

        if(count($pattern) > 1)
        {
            $filenamepart = $pattern[count($pattern)-1][0];
            preg_match('/[^?]*/', $filenamepart, $matches);
            return $matches[0];
        }
    }

    /*
        extract the file filename from any given path or url.
        source: http://www.php.net/manual/en/function.basename.php#89127
    */
    function fetch_filename($filepath)
    {
        preg_match('/[^?]*/', $filepath, $matches);
        $string = $matches[0];
        #split the string by the literal dot in the filename
        $pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);
        #get the last dot position
        $lastdot = $pattern[count($pattern)-1][1];
        #now extract the filename using the basename function
        $filename = basename(substr($string, 0, $lastdot-1));

        #return the filename part
        return $filename;
    }    
	
	/**
	 * Function used to generate
	 * embed code of embedded video
	 */
	function embeded_code($vdetails)
	{
		$code = '';
		$code .= '<object width="'.EMBED_VDO_WIDTH.'" height="'.EMBED_VDO_HEIGHT.'">';
		$code .= '<param name="allowFullScreen" value="true">';
		$code .= '</param><param name="allowscriptaccess" value="always"></param>';
		//Replacing Height And Width
		$h_w_p = array("{Width}","{Height}");
		$h_w_r = array(EMBED_VDO_WIDTH,EMBED_VDO_HEIGHT);	
		$embed_code = str_replace($h_w_p,$h_w_r,$vdetails['embed_code']);
		$code .= unhtmlentities($embed_code);
		$code .= '</object>';
		return $code;
	}
		
	/**
	 * function used to convert input to proper date created formate
	 */
	function datecreated($in)
	{
		
		$date_els = explode('-',$in);
		
		//checking date format
		$df = config("date_format");
		$df_els  = explode('-',$df);
		
		foreach($df_els as $key => $el)
			${strtolower($el).'id'} = $key;
		
		$month = $date_els[$mid];
		$day = $date_els[$did];
		$year = $date_els[$yid];

		if($in)
			return date("Y-m-d",strtotime($year.'-'.$month.'-'.$day));
		else
			return '0000-00-00';
	}
	
	
	/**
	 * After struggling alot with baseurl problem
	 * i finally able to found its nice and working solkution..
	 * its not my original but its a genuine working copy
	 * its still in beta mode 
	 */
	function baseurl()
	{
		$protocol = is_ssl() ? 'https://' : 'http://';
		if(!$sub_dir)
		return $base = $protocol.$_SERVER['HTTP_HOST'].untrailingslashit(stripslashes(dirname(($_SERVER['SCRIPT_NAME']))));
		else
		return $base = $protocol.$_SERVER['HTTP_HOST'].untrailingslashit(stripslashes(dirname(dirname($_SERVER['SCRIPT_NAME']))));

	}function base_url(){ return baseurl();}
	
	/**
	 * SRC (WORD PRESS)
	 * Appends a trailing slash.
	 *
	 * Will remove trailing slash if it exists already before adding a trailing
	 * slash. This prevents double slashing a string or path.
	 *
	 * The primary use of this is for paths and thus should be used for paths. It is
	 * not restricted to paths and offers no specific path support.
	 *
	 * @since 1.2.0
	 * @uses untrailingslashit() Unslashes string if it was slashed already.
	 *
	 * @param string $string What to add the trailing slash to.
	 * @return string String with trailing slash added.
	 */
	function trailingslashit($string) {
		return untrailingslashit($string) . '/';
	}

	/**
	 * SRC (WORD PRESS)
	 * Removes trailing slash if it exists.
	 *
	 * The primary use of this is for paths and thus should be used for paths. It is
	 * not restricted to paths and offers no specific path support.
	 *
	 * @since 2.2.0
	 *
	 * @param string $string What to remove the trailing slash from.
	 * @return string String without the trailing slash.
	 */
	function untrailingslashit($string) {
		return rtrim($string, '/');
	}
	
	
	/**
	 * Determine if SSL is used.
	 *
	 * @since 2.6.0
	 *
	 * @return bool True if SSL, false if not used.
	 */
	function is_ssl() {
		if ( isset($_SERVER['HTTPS']) ) {
			if ( 'on' == strtolower($_SERVER['HTTPS']) )
				return true;
			if ( '1' == $_SERVER['HTTPS'] )
				return true;
		} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}
		return false;
	}	

	function array_depth($array) {
		$ini_depth = 0;
		
		foreach($array as $arr)
		{
			if(is_array($arr))
			{
				$depth = array_depth($arr) + 1;	
				
				if($depth > $ini_depth)
					$ini_depth = $depth;
			}
		}
		
		return $ini_depth;
	}
					
	/**
	 * function used to get user agent details
	 * Thanks to ruudrp at live dot nl 28-Nov-2010 11:31 PHP.NET
	 */
	function get_browser_details($in=NULL,$assign=false)
	{
		//Checking if browser is firefox
		if(!$in)
			$in = $_SERVER['HTTP_USER_AGENT'];
		
		$u_agent = $in;
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/iPhone/i', $u_agent)) {
			$platform = 'iphone';
		}
		elseif (preg_match('/iPad/i', $u_agent)) {
			$platform = 'ipad';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
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
		elseif(preg_match('/Googlebot/i',$u_agent))
		{
			$bname = 'Googlebot';
			$ub = "bot";
		}elseif(preg_match('/msnbot/i',$u_agent))
		{
			$bname = 'MSNBot';
			$ub = "bot";
		}elseif(preg_match('/Yahoo\! Slurp/i',$u_agent))
		{
			$bname = 'Yahoo Slurp';
			$ub = "bot";
		}

	   
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!@preg_match_all($pattern, $u_agent, $matches)) {
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
	   
		$array= array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'bname'		=> strtolower($ub),
			'pattern'    => $pattern
		);
		
		if($assign)	assign($assign,$array); else return $array;
	}
		
	/**
	 * function used to check
	 * remote link is valid or not
	 */
	
	function checkRemoteFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if($result!==FALSE)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>