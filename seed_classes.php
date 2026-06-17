<?php
$classes = [
    ['X', 'RPL 1'], ['X', 'RPL 2'], ['X', 'TKJ 1'],
    ['XI', 'RPL 1'], ['XI', 'RPL 2'],
    ['XII', 'RPL 1']
];

foreach ($classes as $c) {
    \App\Models\SchoolClass::firstOrCreate([
        'tingkat' => $c[0],
        'nama_kelas' => $c[1]
    ]);
}
echo "Classes seeded successfully.\n";
