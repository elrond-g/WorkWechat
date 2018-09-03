# 接口请求使用说明


## 入门

```php
require_once("../vendor/autoload.php");
$workWechatFacorty = new Elrond\WorkWechat\WorkWechat($appId, $agentId, $secret);
$requester = $workWechatFacorty->makeRequest();
$params = [
    'code' => "afeiohfnvuirohu"
];
$userInfo = $requester->rpcCall("GET", Elrond\WorkWechat\Links::GetUserInfoByCode, $params, true);
return $userInfo;

```

## 进阶

因为使用了ACCESS_TOKEN(当第四个参数标识为true的时候)，requester在请求的时候，会自动获取、加入token。
默认情况下，token是缓存在系统tmp目录下，当系统做集群的时候，可能需要缓存用公用缓存的，所以需要重写对应的storage。
更换storage的地方在``src/CacheManager.php``文件下，目前还没有做配置，所以需要改`` function init() ``





