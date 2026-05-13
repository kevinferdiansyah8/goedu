<?php
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$materials = LearningMaterial::all();
foreach ($materials as $m) {
    if ($m->file_path && Storage::disk('public')->exists($m->file_path)) {
        $ext = pathinfo($m->file_path, PATHINFO_EXTENSION);
        $newName = 'kbm/materi/materi_' . $m->id . '.' . $ext;
        if ($m->file_path !== $newName) {
            Storage::disk('public')->move($m->file_path, $newName);
            $m->update(['file_path' => $newName]);
            echo "Renamed: {$m->file_path} to {$newName}\n";
        }
    }
}
echo "Migration Done\n";
