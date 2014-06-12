<?php

namespace Osfi;

/**
 * Simple client for making a OSFI request
 */
class Client {
    private $endpoint;
    private $ch;
    // The sample endpoint is not guaranteed to have valid data,
    public function __construct($endpoint = "http://osfi.azurewebsites.net/") {
        $this->endpoint = $endpoint;
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }
    public function matchName($name) {
        return $this->__request(metaphone($name));
    }

    public function matchMetaphone($name) {
        return $this->__request($name);
    }
    private function __request($name) {
        curl_setopt($this->ch, CURLOPT_URL, $this->endpoint ."metaphone/" . urlencode($name));
        $result = curl_exec($this->ch);
        return json_decode($result);
    }
}