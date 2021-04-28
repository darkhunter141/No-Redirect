<?php
function stripFile($in){
    $pieces = explode("/", $in); 
    if(count($pieces) < 4) return $in . "/";
    if(strpos(end($pieces), ".") !== false){ 
        array_pop($pieces);
    }elseif(end($pieces) !== ""){ 
        $pieces[] = ""; 
    }
    return implode("/", $pieces). "/";
}


 function url_get_contents ($url) {
    if (function_exists('curl_exec')){ 
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $url_get_contents_data = (curl_exec($conn));
        curl_close($conn);
    }elseif(function_exists('file_get_contents')){
        $url_get_contents_data = file_get_contents($url);
    }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
        $handle = fopen ($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
    }else{
        $url_get_contents_data = false;
    }
$data = str_replace('<a href="','<a href="'.'http://' . $_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"].'?url='.stripFile($url),$url_get_contents_data);
$data = str_replace('<head>','<head><base href="'.stripFile($url).'">',$data);
return $data;
}
if(!isset($_GET['url'])){ ?>
<body style="background-color:black"><center><h1 style="color:red;font-size:70px;">Web Hunter</h1> <br> <br> <br> <br><br><form><span style="color:cyan;
        font-weight:bolder;
        font-size:50px;">URL: </span><input name="url" value="" type="text" style="font-size:50px;
        font-weight:bolder;"><input value="GO" type="submit" style="font-size:50px;"></form> <br> <br> <br> <br> <br> <br>  <br> <br> <br> <br><br> <br><marquee style=" color:cyan;
        font-weight:bold;font-size:50px;">Website For No Redirect</marquee> <br>  <br>  <br>    <br>  <br> <br>  <br> <br> 
         <p style="color:red;font-size:50px;">© Team Dark Hunter 141<p></center>
       </body>
<?php	
}
else{ 

	if(substr($_GET['url'], 0, 4) == 'http'){
	echo '<center><form><span>URL: </span><input name="url" value="'.htmlspecialchars($_GET['url']).'" type="text"><input value="GO" type="submit"></form></center>';
	echo url_get_contents (htmlspecialchars($_GET['url']));
	}
	else{
		?>
<?php
		echo '<form><span>URL: </span><input name="url" value="'.htmlspecialchars($_GET['url']).'" type="text"><input value="GO" type="submit"></form>';
		echo "Sorry Bro.<br> Check your URL<br>Only http or https protocols are allowed<br> NO SSRF Here :)</center>"; 
	}
}

