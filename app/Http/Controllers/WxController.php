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

        public function api()
        {

            //get post data, May be due to the different environments
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//php:input
            //写入日志  在同级目录下建立php_log.txt
//chmod 777php_log.txt(赋权) chown wwwphp_log.txt(修改主)
            error_log(var_export($postStr,1),3,'php_log.txt');
//日志图片
            //extract post data
            if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";
                //订阅事件
                if($postObj->Event=="subscribe")
                {
                    $msgType = "text";
                    $contentStr = "欢迎关注安子尘，微信babyanzichen";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }


        }}}
