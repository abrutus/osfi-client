<?php

namespace Osfi;

/**
 * Simple client for making a OSFI request
 */
class Client {
    const TIMEOUT = 5;
    private $endpoint;
    private $ch;
    // The sample endpoint is not guaranteed to have valid data,
    public function __construct($endpoint = "http://osfi.azurewebsites.net/") {
        $this->endpoint = $endpoint;
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, self::TIMEOUT);
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
        if($result === FALSE) {
            if($errno = curl_errno($this->ch)) {
                $error_message = curl_strerror($errno);
                        return new Stub("cURL error ({$errno}): {$error_message}");
            }
            return new Stub("Failed CURL call with no error code");
        }
        return json_decode($result);
    }
}