<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$f = App\Models\Faculty::where('name', 'Fakultas Pertanian')->first();

echo 'FACULTY_COUNT=' . App\Models\Faculty::count() . PHP_EOL;
echo 'PROGRAM_COUNT=' . App\Models\StudyProgram::count() . PHP_EOL;
echo 'PERTANIAN_FACULTY_ID=' . ($f ? $f->id : 'NO_FACULTY') . PHP_EOL;

if ($f) {
    echo 'PERTANIAN_PROGRAM_COUNT=' . App\Models\StudyProgram::where('faculty_id', $f->id)->count() . PHP_EOL;
    $p = App\Models\StudyProgram::where('faculty_id', $f->id)->first();
    echo 'FIRST_PROGRAM=' . ($p ? $p->name : 'NO_PROGRAM') . PHP_EOL;
}
