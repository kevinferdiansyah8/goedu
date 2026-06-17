<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$classes = App\Models\SchoolClass::all();
foreach($classes as $c) {
    echo "ID: " . $c->id . " | Tingkat: " . $c->tingkat . " | Nama: " . $c->nama_kelas . "\n";
}
