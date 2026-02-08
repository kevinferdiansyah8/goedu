@extends('layouts.admin')

@section('title', 'Input Nilai Rapor')

@section('content')

{{-- HEADER --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Rapor - Enhanced</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-soft {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .slide-in {
            animation: slideInUp 0.5s ease-out forwards;
        }

        .row-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .pulse-soft {
            animation: pulse-soft 2s ease-in-out infinite;
        }

        .shake {
            animation: shake 0.3s ease-in-out;
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .grade-badge {
            transition: all 0.3s ease;
        }

        .grade-badge:hover {
            transform: scale(1.1);
        }

        .button-hover {
            transition: all 0.3s ease;
        }

        .button-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .button-hover:active {
            transform: translateY(0);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        .progress-bar {
            transition: width 0.5s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen p-8">
    
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="slide-in" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Input Nilai Rapor
                    </h1>
                    <p class="text-gray-500 mt-1">Masukkan nilai akhir rapor siswa semester ini</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="addStudent()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-yellow font-medium button-hover shadow-lg">
                        + Tambah Siswa
                    </button>
                    <button onclick="exportData()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 text-yellow font-medium button-hover shadow-lg">
                        📊 Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 slide-in" style="animation-delay: 0.2s;">
            <div class="stats-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Siswa</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1" id="totalStudents">2</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <span class="text-2xl">👥</span>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Rata-rata Kelas</p>
                        <p class="text-3xl font-bold text-green-600 mt-1" id="classAverage">80.0</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <span class="text-2xl">📈</span>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Nilai Tertinggi</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1" id="highestScore">88</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-xl">
                        <span class="text-2xl">🏆</span>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Nilai Terendah</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1" id="lowestScore">72</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-xl">
                        <span class="text-2xl">📉</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="slide-in" style="animation-delay: 0.3s;">
            <div class="bg-white rounded-2xl shadow-lg p-4 flex gap-4 items-center">
                <div class="flex-1 relative">
                    <input type="text" id="searchInput" onkeyup="searchStudents()" 
                           placeholder="🔍 Cari nama atau NIS siswa..." 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition">
                </div>
                <select id="filterGrade" onchange="filterByGrade()" 
                        class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition">
                    <option value="">Semua Predikat</option>
                    <option value="A">A (90-100)</option>
                    <option value="B">B (80-89)</option>
                    <option value="C">C (70-79)</option>
                    <option value="D">D (60-69)</option>
                    <option value="E">E (<60)</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="slide-in" style="animation-delay: 0.4s;">
            <div class="bg-white rounded-2xl shadow-xl border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="studentTable">
                        <thead class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">No</th>
                                <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                                <th class="px-6 py-4 text-left font-semibold">NIS</th>
                                <th class="px-6 py-4 text-left font-semibold">Nilai Akhir</th>
                                <th class="px-6 py-4 text-left font-semibold">Predikat</th>
                                <th class="px-6 py-4 text-left font-semibold">Progress</th>
                                <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="tableBody">
                            <!-- Rows will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center slide-in" style="animation-delay: 0.5s;">
            <div class="flex gap-3">
                <button onclick="resetAll()" class="px-6 py-3 rounded-xl bg-gray-500 text-white font-medium button-hover shadow-lg">
                    🔄 Reset Semua
                </button>
            </div>
            <div class="flex gap-3">
                <button onclick="saveDraft()" class="px-6 py-3 rounded-xl bg-yellow-500 text-white font-medium button-hover shadow-lg">
                    💾 Simpan Draft
                </button>
                <button onclick="saveData()" class="px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold button-hover shadow-lg text-lg">
                    ✅ Simpan Nilai Rapor
                </button>
            </div>
        </div>

    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-8 right-8 px-6 py-4 rounded-xl shadow-2xl transform translate-y-32 transition-transform duration-300 z-50">
    </div>

    <script>
        // Initial student data
        let students = [
            { id: 1, name: 'Ahmad Fauzi', nis: '20230101', score: 88 },
            { id: 2, name: 'Budi Santoso', nis: '20230103', score: 72 },
            { id: 3, name: 'Citra Dewi', nis: '20230105', score: 95 },
            { id: 4, name: 'Dimas Pratama', nis: '20230107', score: 78 },
            { id: 5, name: 'Eka Putri', nis: '20230109', score: 85 }
        ];

        let nextId = 6;

        // Calculate grade based on score
        function calculateGrade(score) {
            if (score >= 90) return 'A';
            if (score >= 80) return 'B';
            if (score >= 70) return 'C';
            if (score >= 60) return 'D';
            return 'E';
        }

        // Get grade color
        function getGradeColor(grade) {
            const colors = {
                'A': 'bg-green-100 text-green-700 border-green-300',
                'B': 'bg-blue-100 text-blue-700 border-blue-300',
                'C': 'bg-yellow-100 text-yellow-700 border-yellow-300',
                'D': 'bg-orange-100 text-orange-700 border-orange-300',
                'E': 'bg-red-100 text-red-700 border-red-300'
            };
            return colors[grade] || colors['E'];
        }

        // Render table
        function renderTable(data = students) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            data.forEach((student, index) => {
                const grade = calculateGrade(student.score);
                const row = document.createElement('tr');
                row.className = 'hover:bg-blue-50 transition-colors row-enter';
                row.style.animationDelay = `${index * 0.05}s`;
                
                row.innerHTML = `
                    <td class="px-6 py-4 font-semibold text-gray-600">${index + 1}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">${student.name}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${student.nis}</td>
                    <td class="px-6 py-4">
                        <input type="number" 
                               value="${student.score}" 
                               min="0" 
                               max="100"
                               onchange="updateScore(${student.id}, this.value)"
                               oninput="validateScore(this)"
                               class="w-24 px-3 py-2 border-2 border-gray-300 rounded-xl font-bold text-center input-focus focus:border-blue-500 focus:outline-none">
                    </td>
                    <td class="px-6 py-4">
                        <span class="grade-badge px-4 py-2 rounded-full ${getGradeColor(grade)} text-sm font-bold border-2 inline-block">
                            ${grade}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="progress-bar h-full rounded-full bg-gradient-to-r from-blue-500 to-purple-500" 
                                 style="width: ${student.score}%"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-1 block">${student.score}%</span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="deleteStudent(${student.id})" 
                                class="px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition text-xs font-semibold">
                            🗑️ Hapus
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
                
                // Trigger animation
                setTimeout(() => {
                    row.classList.remove('row-enter');
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50);
            });

            updateStatistics();
        }

        // Validate score input
        function validateScore(input) {
            let value = parseInt(input.value);
            
            if (value > 100) {
                input.value = 100;
                input.classList.add('shake');
                setTimeout(() => input.classList.remove('shake'), 300);
            } else if (value < 0) {
                input.value = 0;
                input.classList.add('shake');
                setTimeout(() => input.classList.remove('shake'), 300);
            }
        }

        // Update score
        function updateScore(id, newScore) {
            const score = Math.max(0, Math.min(100, parseInt(newScore) || 0));
            const student = students.find(s => s.id === id);
            if (student) {
                student.score = score;
                renderTable();
                showToast(`Nilai ${student.name} diperbarui menjadi ${score}`, 'success');
            }
        }

        // Update statistics
        function updateStatistics() {
            const total = students.length;
            const average = students.reduce((sum, s) => sum + s.score, 0) / total;
            const highest = Math.max(...students.map(s => s.score));
            const lowest = Math.min(...students.map(s => s.score));

            document.getElementById('totalStudents').textContent = total;
            document.getElementById('classAverage').textContent = average.toFixed(1);
            document.getElementById('highestScore').textContent = highest;
            document.getElementById('lowestScore').textContent = lowest;
        }

        // Add new student
        function addStudent() {
            const name = prompt('Nama siswa:');
            if (!name) return;
            
            const nis = prompt('NIS:');
            if (!nis) return;
            
            const score = parseInt(prompt('Nilai (0-100):', '75'));
            if (isNaN(score)) return;

            students.push({
                id: nextId++,
                name: name,
                nis: nis,
                score: Math.max(0, Math.min(100, score))
            });

            renderTable();
            showToast(`Siswa ${name} berhasil ditambahkan!`, 'success');
        }

        // Delete student
        function deleteStudent(id) {
            const student = students.find(s => s.id === id);
            if (confirm(`Hapus data ${student.name}?`)) {
                students = students.filter(s => s.id !== id);
                renderTable();
                showToast(`Data ${student.name} dihapus`, 'warning');
            }
        }

        // Search students
        function searchStudents() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const filtered = students.filter(s => 
                s.name.toLowerCase().includes(query) || 
                s.nis.includes(query)
            );
            renderTable(filtered);
        }

        // Filter by grade
        function filterByGrade() {
            const grade = document.getElementById('filterGrade').value;
            if (!grade) {
                renderTable();
                return;
            }
            const filtered = students.filter(s => calculateGrade(s.score) === grade);
            renderTable(filtered);
        }

        // Save data
        function saveData() {
            const button = event.target;
            button.disabled = true;
            button.innerHTML = '⏳ Menyimpan...';
            
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = '✅ Simpan Nilai Rapor';
                showToast('Data berhasil disimpan! 🎉', 'success');
            }, 1500);
        }

        // Save draft
        function saveDraft() {
            localStorage.setItem('studentDraft', JSON.stringify(students));
            showToast('Draft tersimpan', 'info');
        }

        // Reset all
        function resetAll() {
            if (confirm('Reset semua data?')) {
                students.forEach(s => s.score = 0);
                renderTable();
                showToast('Semua nilai direset', 'warning');
            }
        }

        // Export data
        function exportData() {
            const csv = 'Nama,NIS,Nilai,Predikat\n' + 
                students.map(s => `${s.name},${s.nis},${s.score},${calculateGrade(s.score)}`).join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'nilai-rapor.csv';
            a.click();
            showToast('Data berhasil diexport! 📊', 'success');
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            const colors = {
                success: 'bg-green-500',
                warning: 'bg-yellow-500',
                error: 'bg-red-500',
                info: 'bg-blue-500'
            };
            
            toast.className = `fixed bottom-8 right-8 px-6 py-4 rounded-xl shadow-2xl transform transition-transform duration-300 z-50 ${colors[type]} text-white font-semibold`;
            toast.textContent = message;
            toast.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                toast.style.transform = 'translateY(200px)';
            }, 3000);
        }

        // Initialize
        renderTable();

        // Load draft if exists
        const draft = localStorage.getItem('studentDraft');
        if (draft) {
            students = JSON.parse(draft);
            renderTable();
        }
    </script>

</body>
</html>
@endsection
