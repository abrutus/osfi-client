OSFI Client
===========

PHP client to consume the [OSFI Rest Api](https://github.com/abrutus/osfi).

Sample usage
------------
```
<?php
require_once "vendor/autoload.php";
$client = new Osfi\Client;
$match_result = $client->matchName("Al Kiaida");
if($match_result->count > 0) {
    // We have a match
    echo "Match on:" . print_r($match_result->entities, 1);
}
```