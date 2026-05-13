<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Assignment;
use App\Models\StudentAssignment;

// Student Ahmad Fauzi: id=1, school_class_id=1
$classId = 1;
$studentId = 1;

$all = Assignment::where('school_class_id', $classId)->get();
echo "Total assignments for class 1: " . $all->count() . "\n";

foreach ($all as $a) {
    $submitted = StudentAssignment::where('student_id', $studentId)->where('assignment_id', $a->id)->exists();
    echo "  - [{$a->id}] {$a->judul} => " . ($submitted ? "SUDAH DIKUMPULKAN" : "BELUM (harus muncul)") . "\n";
}

$pending = Assignment::where('school_class_id', $classId)
    ->whereDoesntHave('studentAssignments', function($q) use ($studentId) {
        $q->where('student_id', $studentId);
    })->get();

echo "\nPending (should show in view): " . $pending->count() . "\n";
foreach ($pending as $p) {
    echo "  - [{$p->id}] {$p->judul}\n";
}
