# Oauth使用说明

```php
require_once("../vendor/autoload.php");
$workWechatFacorty = new Elrond\WorkWechat\WorkWechat($appId, $agentId, $secret);
$Oauth = $workWechatFacorty->makeOauth();
//一行代码中完成了页面跳转、获取code、code转access_token，并获取会员的信息
$user = $Oauth->oauth();
```

```php

////在大型系统中比较推荐这种方法
//$Oauth2 = $workWechatFacorty->makeOauth();
//if($request->has('code'))
//{
//    $code = $request->get('code');
//    $user = $Oauth2->codeToUserinfo($code);
//    return $user;
//}else{
//    $url = $Oauth2->getOauthRedirectUrl($inWorkWechatBrowse, $inWorkWechatBrowser, $callbackUrl, $state, $scope);
//    return $response->redirect($url);
//}

```



