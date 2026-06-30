<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$classes = [
    ['7', 'A'], ['7', 'B'],
    ['8', 'A'], ['8', 'B'],
    ['9', 'A'], ['9', 'B']
];

foreach ($classes as $c) {
    \App\Models\SchoolClass::firstOrCreate([
        'tingkat' => $c[0],
        'nama_kelas' => $c[1]
    ]);
}
echo "Classes seeded successfully.\n";
