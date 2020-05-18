<?php

namespace Salesfly;

require "vendor/autoload.php";

class UsageAPI
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    public function get()
    {
        return $this->restClient->get("/v1/usage");
    }
}
