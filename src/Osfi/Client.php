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

    public function matchExactName($name) {
        $transliterated = preg_replace("/[^A-Za-z0-9 ]/", '', transliterator_transliterate("Any-Latin; Latin-ASCII; Upper()", $name));
        $separated_by_lines = ltrim(join("-", array_filter(explode(" ", $transliterated))));
        return $this->__request($separated_by_lines, "osfi/exactname/");
    }
    public function matchOfacExactName($name) {
        $transliterated = preg_replace("/[^A-Za-z0-9 ]/", '', transliterator_transliterate("Any-Latin; Latin-ASCII; Upper()", $name));
        $separated_by_lines = ltrim(join("-", array_filter(explode(" ", $transliterated))));
        return $this->__request($separated_by_lines, "ofac/exactname/");
    }

    private function __request($name, $route = "exactname/") {
        curl_setopt($this->ch, CURLOPT_URL, $this->endpoint . $route . urlencode($name));
        $result = curl_exec($this->ch);
        if($result === FALSE) {
            if($errno = curl_errno($this->ch)) {
                $error_message = curl_error($this->ch);
                return new Stub("cURL error ({$errno}): {$error_message}");
            }
            return new Stub("Failed cURL call with no error code");
        }
        return json_decode($result);
    }
}