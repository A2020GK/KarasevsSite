<?php
namespace System\Http;

class JsonResponse extends Response {
    public function __construct(array $body=[], int $statusCode = 200, array $headers = []) {
        parent::__construct(json_encode($body),$statusCode,$headers);
    }
}