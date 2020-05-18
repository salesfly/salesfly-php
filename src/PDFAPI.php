<?php

namespace Salesfly;

require "vendor/autoload.php";

class PDFAPI
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    public function create($options)
    {
        $headers = [
            "Accept" => "application/pdf",
        ];
        return $this->restClient->post("/v1/pdf/create", $options, $headers);
    }
}
