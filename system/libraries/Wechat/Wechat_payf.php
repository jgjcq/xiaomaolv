<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(BASEPATH.'libraries/Wechat/lib/Wechat_basic.php');
class CI_Wechat_payf extends CI_Wechat_basic {
    //=======【基本信息设置】=====================================
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    const APPID = 'wxce27b563db618734';//服务商的
    //受理商ID，身份标识
    const MCHID = '1554057081';//服务商的
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    const KEY = '5f69626a8f79e1838b979461ac1b5eea';//服务商的

    const SUB_APPID = 'wxc84e8ca6616a9106';//子商户的
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    const SUB_APPSECRET = '30ffa25273e6d864cbf840bf3a55d638';//子商户的

    //=======【JSAPI路径设置】===================================
    //获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
    const JS_API_CALL_URL = 'http://testbuy.96211.net/wx/demo/js_api_call.php';

    //=======【证书路径设置】=====================================
    //证书路径,注意应该填写绝对路径
    const SSLCERT_PATH = 'http://testbuy.96211.net/wx/WxPayPubHelper/cacert/apiclient_cert.pem';
    const SSLKEY_PATH = 'http://testbuy.96211.net/wx/WxPayPubHelper/cacert/apiclient_key.pem';

    //=======【异步通知url设置】===================================
    //异步通知url，商户根据实际开发过程设定
    const NOTIFY_URL = 'http://testbuy.96211.net/wx/demo/notify_url.php';

    //=======【curl超时设置】===================================
    //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
    const CURL_TIMEOUT = 30;
}