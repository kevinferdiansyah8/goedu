<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\Student::find(1);
echo "Class ID: " . $student->school_class_id . "\n";
echo "Schedules: " . App\Models\Schedule::where('school_class_id', $student->school_class_id)->count() . "\n";
