<?php
$schedules = \App\Models\Schedule::with('subject')->whereHas('subject', function($q) { $q->where('teacher_id', 1); })->get();
echo json_encode($schedules);
