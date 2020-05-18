<?php

namespace Salesfly;

require "vendor/autoload.php";

class Client
{
    // APIs
    public $usage;
    public $geolocation;
    public $mail;
    public $pdf;

    public function __construct($apiKey, $timeout = 30.0)
    {
        $restClient = new RestClient($apiKey, $timeout);
        $this->usage = new UsageAPI($restClient);
        $this->geolocation = new GeolocationAPI($restClient);
        $this->mail = new MailAPI($restClient);
        $this->pdf = new PDFAPI($restClient);
    }

    public function getVersion()
    {
        return VERSION;
    }
}
