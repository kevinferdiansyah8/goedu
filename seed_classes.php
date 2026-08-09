<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$classes = [
    ['10', '10'],
    ['11', '11'],
    ['12', '12']
];

foreach ($classes as $c) {
    \App\Models\SchoolClass::firstOrCreate([
        'tingkat' => $c[0],
        'nama_kelas' => $c[1]
    ]);
}
echo "Classes seeded successfully.\n";
