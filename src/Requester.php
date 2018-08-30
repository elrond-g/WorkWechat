<?php

namespace Elrond\WorkWechat;

use GuzzleHttp\Client;
use Elrond\WorkWechat\CacheManager;
use Elrond\WorkWechat\Exceptions\ResultException;

class Requester
{

    public $appId = '';
    public $agentId = '';
    public $secret = '';

    public function __construct($appId, $agentId, $secret)
    {
        $this->appId = $appId;
        $this->agentId = $agentId;
        $this->secret = $secret;
        $this->client = new Client();
    }

    public function rpcCall($method = "post", $url = "", $params = [], $useAccessToken = false)
    {
        if($useAccessToken)
        {
            $params['access_token'] = $this->getAccessToken();
        }

        return $this->request($method, $url, $params);
    }

    public function request($method = "post", $url = "", $params = [])
    {
        $method = strtoupper($method);
        if($method == "GET")
        {
            $url = $url . "?" . http_build_query($params);
   //       if(strstr($url , "?"))
   //       {
   //           $url = $url . "?" . http_build_query($params);
   //       }else{
   //           $url = $url . "&" . http_build_query($params);
   //       }
        }
        $res= $this->client->request($method, $url, [
            'form_params' => $params
        ]);
        $body = $res->getBody();
        $responseParams = json_decode($body, true);
//      echo "<pre>";
//      var_dump($method);
//      var_dump($url);
//      var_dump($params);
//      exit;
        if($responseParams['errcode'] !=0)
            throw new ResultException($responseParams['errmsg'], $responseParams['errcode']);
        return json_decode($body, true);
    }

    public function getAccessToken()
    {
        $accessToken = CacheManager::get('access_token');
        if(!$accessToken)
        {
            $accessToken = $this->getAccessTokenByRpc();
            CacheManager::set('access_token', $accessToken, 7200);
        }
        return $accessToken;
    }

    public function getAccessTokenByRpc()
    {
        $params = $this->request('GET', Links::GetToken, ['corpid'=>$this->appId, 'corpsecret'=>$this->secret]);
        return $params['access_token'];

    }

}

