<?php

namespace Elrond\WorkWechat;

use Elrond\WorkWechat\Links;

class Oauth
{

    private $requester = null;

    public function __construct($requester)
    {
        $this->requester = $requester;
    }

    /****
     * 在实用中，这个方法最好重写
     */
    public function oauth($code = null,$isWorkWechat = false)
    {
        if($code || $this->getCode())
        {
            $code = $code ? : $this->getCode();
            return $this->codeToUserinfo($code);
        }

        if($isWorkWechat || $this->isWorkWechatBrowser())
        {
            $redirectUrl = $this->getOauthRedirectUrl(true);
        }else{
            $redirectUrl = $this->getOauthRedirectUrl();
        }
        return $this->redirect($redirectUrl);
    }

    public function getOauthRedirectUrl($inWorkWechatBrowser = false, $redirectUrl = "", $state = "", $scope = "snsapi_privateinfo")
    {
        if($inWorkWechatBrowser)
        {
            $url = Links::Oauth2Authorize;
            $redirectParams = [
                'appid' => $this->requester->appId,
                'redirect_uri' => $redirectUrl ? :$this->getUri(),
                'response_type' => 'code',
                'scope' => $scope,
                'agentid' => $this->requester->agentId,
                'state' => $state,
            ];
            $url = $url . "?" . http_build_query($redirectParams) . "#wechat_redirect";
        }else{
            $url = Links::WwpenSsoQrConnect;
            $redirectParams = [
                'appid' => $this->requester->appId,
                'agentid' => $this->requester->agentId,
                'redirect_uri' => $redirectUrl ? :$this->getUri(),
                'state' => $state,
            ];
            $url = $url . "?" . http_build_query($redirectParams);
        }
        return $url;
    }

    public function codeToUserinfo($code)
    {
        $params = [
            'code' => $code
        ];
        $userInfo = $this->requester->rpcCall("GET", Links::GetUserInfoByCode, $params, true);
        return $userInfo;
    }

    private function getUri()
    {
        $uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if(strstr($_SERVER['SERVER_PROTOCOL'],"HTTPS"))
            return "https://" . $uri;
        return "http://" . $uri;
    }

    private function getCode()
    {
        return isset($_GET['code']) ? $_GET['code'] : false;
    }

    private function isWorkWechatBrowser()
    {
        $userAgent = $this->getUserAgent();
        return strstr($userAgent, 'wxwork') && strstr($userAgent, 'MicroMessenger');
    }

    private function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }


    private function redirect($url)
    {
        header("location:$url");
        echo "正在获取授权...";
        exit;
    }

}
