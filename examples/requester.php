<?php

$appId = "hereisappid";
$agentId = "hereisagentid";
$secret = "hereissecretforcorp";

require_once("../vendor/autoload.php");
$workWechatFacorty = new Elrond\WorkWechat\WorkWechat($appId, $agentId, $secret);
$requester = $workWechatFacorty->makeRequest();
$params = [
    'code' => "afeiohfnvuirohu"
];
$userInfo = $requester->rpcCall("GET", Elrond\WorkWechat\Links::GetUserInfoByCode, $params, true);
return $userInfo;

