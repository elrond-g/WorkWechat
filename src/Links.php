<?php

namespace Elrond\WorkWechat;


class Links
{
    //获取企业应用的token
    const GetToken ="https://qyapi.weixin.qq.com/cgi-bin/gettoken";

    //在企业微信浏览器中进行授权的地方
    const Oauth2Authorize = "https://open.weixin.qq.com/connect/oauth2/authorize";

    //通过二维码的方式进行扫码登录
    const WwpenSsoQrConnect = "https://open.work.weixin.qq.com/wwopen/sso/qrConnect";

    //获取用户（员工）的access_token， 就是oauth2里面用code换token的地方
    const GetUserInfoByCode = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo";

    static public function getRealUrl($api)
    {
        return "";
    }

}


