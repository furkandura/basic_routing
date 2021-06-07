<?php

use Main\BasicRoute;

// Subfolder var ise config içine veriliyor.
$route = new BasicRoute([
    "SUB_FOLDER" => "test"
]);

// Dosya yolu laraveldeki view gibi / yerine . ile verilir.

// GET Kullanımı 
$route->get("example-get", "testing.index_get");

// POST Kullanımı
$route->post("dashboard", "testing.index_post");

// Error mesajlarını varsa array şeklinde getirir yoksa null döndürür.
print_r($route->getErrorMessage());
