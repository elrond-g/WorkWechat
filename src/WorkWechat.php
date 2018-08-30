<?php

namespace Elrond\WorkWechat;

use Elrond\WorkWechat\Oauth;
use Elrond\WorkWechat\Requester;

class WorkWechat
{

    private $logger = null;

    private $requester = null;

    public function __construct($appId, $agentId, $secret)
    {
        $this->init($appId, $agentId, $secret);
    }

    private function init($appId, $agentId, $secret)
    {
        $this->requester = new Requester($appId, $agentId, $secret);

    }

    public function makeOauth()
    {
        return new Oauth($this->requester);
    }

}


