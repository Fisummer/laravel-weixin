<?php
    namespace App\Http\Controllers;
    class WxController extends Controller
    {

	    /*public function api()
	    {
		    $echostr = $_GET['echostr'];
	        if(self::verifySignature()){
			echo $echostr;
			exit;
		
		}
	    
	    
	    }*/
        public static  function verifySignature()
        {
		//define data send from weixin server 
		$timestamp = $_GET['timestamp'];
	        $nonce     = $_GET['nonce'];
	        $signature = $_GET['signature'];
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
		if($tmpStr == $signature){
			return true;
		}else{
		return false;
		}
        }

        public function api(){

            //the template data struct send from wechat
         $receiveTemplate =  "<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
</xml>";

         //the template data struct to be send
         $sendTemplate = "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[%s]]></MsgType>
 <Content><![CDATA[%s]]></Content>
 </xml>";

         //get the detail data

            $xmlStr = file_get_contents('php://input');
            $xmlObj = simplexml_load_string($xmlStr);

            //define the data to be send

            $touser = $xmlObj->FromUserName;
            $fromuser = $xmlObj->ToUserName;
            $time = time();
            $msgType = 'text';
            $content = 'thanks for your subscribtion !';

           $senddata =  sprintf($sendTemplate,$touser,$fromuser,$time,$msgType,$content);

           echo $senddata;



        }

    }
