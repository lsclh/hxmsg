<?php
// +----------------------------------------------------------------------
// | Created by PhpStorm.©️
// +----------------------------------------------------------------------
// | User: 程立弘
// +----------------------------------------------------------------------
// | Date: 2018/9/29 14:44
// +----------------------------------------------------------------------
// | Author: 程立弘 <1019759208@qq.com>
// +----------------------------------------------------------------------
namespace Lsclh\Hxmsg;

/**
 * 华信科技短信发送接口封装
 * Class Postmsg
 * @package think
 */
class Postmsg
{
    private $postUrl = 'https://dx.ipyy.net/smsJson.aspx';
    private $config = [];
    public function __set($p,$v){
        if(property_exists($this,$p)){
            $this->$p = $v;
        }
    }
    public function __get($p){
        if (property_exists($this,$p)) {
            return $this->$p;
        }
    }

    /**
     * Postmsg constructor.
     * @param $config
     * [
     *  'userid'=>'1', 企业ID
     *  'account'=>'1', 发送用户帐号
     *  'password'=>'1', 发送接口密码
     * ]
     */
    public function __construct($config){
        $this->config = $config;
    }

    /**
     * 发送接口
     * @param $phone 发送手机号 多个用,隔开
     * @param $con 内容 需要在后台报备再去发送 例如: '【守农庄园】您的验证码为'.$param['code'].'，请在5分钟之内完成！'
     */
    public function send($phone,$con){
        $data['userid'] = $this->config['userid']; //企业ID
        $data['account'] = $this->config['account'];//发送用户帐号
        $data['password'] = strtolower(md5($this->config['password']));//发送接口密码
        $data['mobile'] = $phone;//全部被叫号码
        $data['content'] = $con;//内容
        $data['sendTime'] = '';//定时发送时间
        $data['action'] = 'send';//发送任务命令
        $Res = $this->fCurl($data);
        $Res = json_decode($Res,true);
        return $Res;
    }












    /**
     * 用于传输get或post
     * @param array $data 当post时填写 传输数据格式为array（'name'=> 值）;
     */
    private function fCurl($data=array()){
        //初始化
        $curl = curl_init();
        //不让验证证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //提交地址
        curl_setopt($curl, CURLOPT_URL, $this->postUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        //判断是get还是post post所有步骤就比get多两步
        if (!empty($data)) {
            //说明是post
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $res = curl_exec($curl);
        if($res === FALSE) return "CURL Error:".curl_error($curl);
        curl_close($curl);
        return $res;
    }



}