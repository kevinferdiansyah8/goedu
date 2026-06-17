<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$classes = \App\Models\Student::pluck('kelas')->unique()->filter();

foreach($classes as $c) {
    $parts = explode('-', $c);
    if(count($parts) == 2) {
        $sc = \App\Models\SchoolClass::firstOrCreate([
            'tingkat' => $parts[0],
            'nama_kelas' => $parts[1]
        ]);
        echo "Created Class: " . $sc->tingkat . " " . $sc->nama_kelas . "\n";
        
        // Update students
        \App\Models\Student::where('kelas', $c)->update(['school_class_id' => $sc->id]);
        
        // Update schedules
        \App\Models\Schedule::where('kelas', $c)->update(['school_class_id' => $sc->id]);
        
        // Assignments and Learning Materials were null, we'll assign them to X-A just to fix the seeder
        if($c == 'X-A') {
            \App\Models\Assignment::whereNull('school_class_id')->update(['school_class_id' => $sc->id]);
            \App\Models\LearningMaterial::whereNull('school_class_id')->update(['school_class_id' => $sc->id]);
        }
    }
}
echo "Migration Complete.\n";
