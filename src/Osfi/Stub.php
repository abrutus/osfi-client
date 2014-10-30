<?php
namespace Osfi;

class Stub {
    public $error;
    public $entities;
    public $count;
    public $msg;
    public $status;
    public function __construct($error_msg) {
        $this->error = true;
        $this->msg = $error_msg;
        $this->entities = [];
        $this->count = 0;
        $this->status = 500;
    }
}