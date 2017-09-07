<?php
    namespace App\Http\Controllers;
    class WxController extends Controller
    {

	    public function apiback()
	    {
		    $echostr = $_GET['echostr'];
	        if(self::verifySignature()){
			echo $echostr;
			exit;
		
		}
	    
	    
	    }
        public function api()
        {
		//define data send from weixin server 
		$timestamp = $_GET['timestamp'];
	        $nonce     = $_GET['nonce'];
	        $signature = $_GET['signature'];
	        $echostr   = $_GET['echostr'];
	        //define the token had set
		$token     = 'weixin';
	        //combine the needed parameters to an array
		$tmpArr = array($timestamp,$nonce,$token);
	 	//sort the array
		sort($tmpArr);
		//convert the array to string
		$tmpStr = implode($tmpArr); 
		$tmpStr = sha1($tmpStr);
		//compare the send signature with the produce one
		if($tmpStr == $echostr){
			echo $_GET['echostr'];
		}
        }
    }
