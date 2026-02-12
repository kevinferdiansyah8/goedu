<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1) Stats cards (dummy)
        $stats = [
            'students' => 2847,
            'teachers' => 142,
            'classes'  => 38,
            'users'    => 3200,
        ];

        // 2) Attendance - last 7 days (Mon..Sun)
        $attendance_labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $attendance = [
            'hadir' => [85,92,78,95,88,82,90],
            'izin'  => [5,3,8,2,4,6,3],
            'sakit' => [2,1,3,1,2,1,2],
            'alpha' => [8,4,11,2,6,11,5],
        ];

        // 3) PPDB doughnut
        $ppdb_labels = ['Pendaftar','Diterima','Cadangan','Ditolak'];
        $ppdb = [1200, 800, 150, 250];

        // 4) Activities per month (Jan..Dec)
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $activities = [
            'event' => [2,3,1,4,2,3,5,2,3,4,1,2],
            'extracurricular' => [5,4,6,3,4,5,6,7,5,4,3,4],
            'exam' => [0,0,2,0,6,0,0,1,0,3,2,0],
            'meeting' => [1,2,1,1,2,1,2,1,2,1,1,1],
        ];

        // 5) Summary metrics for today
        $summary = [
            'attendance_today_pct' => 89, // percent
            'absent_today' => round($stats['students'] * (100 - 89) / 100),
            'ppdb_today' => 24,
            'active_events_today' => 3,
        ];

        return view('admin.dashboard', compact(
            'stats', 'attendance_labels', 'attendance', 'ppdb_labels', 'ppdb', 'months', 'activities', 'summary'
        ));
    }

    public function orangtua()
    {
        return view('orangtua.dashboard');
    }
}
