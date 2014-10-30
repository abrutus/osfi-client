<?php
namespace Osfi;

class Stub {
    public $error;
    public $entities;
    public $msg;
    public $status;
    public function __construct($error_msg) {
        $this->error = true;
        $this->msg = $error_msg;
        $this->entities = [];
        $this->status = 500;
    }
}