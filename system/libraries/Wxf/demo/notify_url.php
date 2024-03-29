<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/
	include_once("./log_.php");
	include_once("../WxPayPubHelper/WxPayPubHelper.php");

    //使用通用通知接口
	$notify = new Notify_pub();

	//存储微信的回调
	$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
	$notify->saveData($xml);
	
	//验证签名，并回应微信。
	//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	//尽可能提高通知的成功率，但微信不保证通知最终能成功。
	if($notify->checkSign() == FALSE){
		$notify->setReturnParameter("return_code","FAIL");//返回状态码
		$notify->setReturnParameter("return_msg","签名失败");//返回信息
	}else{
		$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	}
	$returnXml = $notify->returnXml();
	echo $returnXml;
	
	//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
	
	//以log文件形式记录回调信息
	$log_ = new Log_();
	$log_name="./notify_url.log";//log文件路径
	$log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

	if($notify->checkSign() == TRUE)
	{
		if ($notify->data["return_code"] == "FAIL") {
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
		}
		elseif($notify->data["result_code"] == "FAIL"){
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
		}
		else{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【支付成功】:\n".$notify->data['attach']."\n");
			$data_array=explode('-', $notify->data['attach']);
			$orderid=$data_array[0];
			$trueamount=($notify->data['cash_fee'])/100;
			$paymethodid=$data_array[2];
			$usebalance=$data_array[1];
			$userid=$data_array[3];
			// $log_->log_result("call back:" .$orderid.','.$trueamount.','.$paymethodid.','.$usebalance);
			$log_->log_result('error1: ' . mysql_error());
			$con = mysql_connect("101.132.125.77","sql96211","sql96211");
			if (!$con)
			{ 
				$log_->log_result('error2: ' . mysql_error());
			}
			mysql_select_db("sql96211", $con);
			$sql1="UPDATE db_order SET paymethodid='$paymethodid',trueamount='$trueamount' WHERE id='$orderid'";
			$sql2="UPDATE db_user SET balance=balance-'$usebalance' WHERE id='$userid'";
			if (!mysql_query($sql1,$con))
			  {
			  $log_->log_result('error3: ' . mysql_error());
			  }
			if (!mysql_query($sql2,$con))
			  {
			  $log_->log_result('error4: ' . mysql_error());
			  }
			mysql_close($con);
		}
		
		//商户自行增加处理流程,
		//例如：更新订单状态
		//例如：数据库操作
		//例如：推送支付完成信息
	}
?>