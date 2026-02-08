@extends('layouts.admin')

@section('title', 'Jurusan, Kelas & Ruang')

@section('content')
<div class="flex-1 overflow-y-auto p-5 md:p-8">

<div class="flex-1 overflow-y-auto p-5 md:p-8">

<div class="space-y-8">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold text-foreground">Jurusan, Kelas & Ruang</h1>
        <p class="text-secondary text-sm">
            Kelola data jurusan, kelas, dan ruang sekolah
        </p>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl bg-white border border-border p-6">
            <p class="text-sm text-secondary">Total Jurusan</p>
            <h2 class="text-3xl font-bold text-primary mt-2">5</h2>
        </div>

        <div class="rounded-2xl bg-white border border-border p-6">
            <p class="text-sm text-secondary">Total Kelas</p>
            <h2 class="text-3xl font-bold text-primary mt-2">18</h2>
        </div>

        <div class="rounded-2xl bg-white border border-border p-6">
            <p class="text-sm text-secondary">Total Ruang</p>
            <h2 class="text-3xl font-bold text-primary mt-2">12</h2>
        </div>
    </div>

    <!-- FORM SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- JURUSAN -->
        <div class="rounded-2xl bg-white border border-border p-6 space-y-4">
            <h3 class="font-bold text-lg">Jurusan</h3>

            <input type="text"
                placeholder="Contoh: Teknik Informatika"
                class="w-full px-4 py-3 border border-border rounded-xl
                       focus:ring-2 focus:ring-primary/20 focus:border-primary">

            <button
                class="w-full bg-primary text-white py-3 rounded-xl font-semibold
                       hover:bg-primary-hover transition">
                Tambah Jurusan
            </button>

            <div class="pt-4 space-y-2">
                <p class="text-sm font-semibold text-secondary">Daftar Jurusan</p>
                <div class="text-sm bg-muted rounded-xl p-3">Teknik Informatika</div>
                <div class="text-sm bg-muted rounded-xl p-3">Multimedia</div>
                <div class="text-sm bg-muted rounded-xl p-3">Akuntansi</div>
            </div>
        </div>

        <!-- KELAS -->
        <div class="rounded-2xl bg-white border border-border p-6 space-y-4">
            <h3 class="font-bold text-lg">Kelas</h3>

            <select
                class="w-full px-4 py-3 border border-border rounded-xl
                       focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option>Pilih Jurusan</option>
                <option>Teknik Informatika</option>
                <option>Multimedia</option>
            </select>

            <input type="text"
                placeholder="Contoh: X RPL 1"
                class="w-full px-4 py-3 border border-border rounded-xl
                       focus:ring-2 focus:ring-primary/20 focus:border-primary">

            <button
                class="w-full bg-primary text-white py-3 rounded-xl font-semibold
                       hover:bg-primary-hover transition">
                Tambah Kelas
            </button>

            <div class="pt-4 space-y-2">
                <p class="text-sm font-semibold text-secondary">Daftar Kelas</p>
                <div class="text-sm bg-muted rounded-xl p-3">X RPL 1</div>
                <div class="text-sm bg-muted rounded-xl p-3">XI RPL 2</div>
            </div>
        </div>

        <!-- RUANG -->
        <div class="rounded-2xl bg-white border border-border p-6 space-y-4">
            <h3 class="font-bold text-lg">Ruang</h3>

            <input type="text"
                placeholder="Contoh: Lab Komputer 1"
                class="w-full px-4 py-3 border border-border rounded-xl
                       focus:ring-2 focus:ring-primary/20 focus:border-primary">

            <select
                class="w-full px-4 py-3 border border-border rounded-xl
                       focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option>Tipe Ruang</option>
                <option>Kelas</option>
                <option>Lab</option>
            </select>

            <button
                class="w-full bg-primary text-white py-3 rounded-xl font-semibold
                       hover:bg-primary-hover transition">
                Tambah Ruang
            </button>

            <div class="pt-4 space-y-2">
                <p class="text-sm font-semibold text-secondary">Daftar Ruang</p>
                <div class="text-sm bg-muted rounded-xl p-3">Ruang A1</div>
                <div class="text-sm bg-muted rounded-xl p-3">Lab Komputer</div>
            </div>
        </div>
    </div>

    <!-- INFO -->
    <div class="rounded-2xl bg-muted p-4 text-sm text-secondary">
        Data jurusan, kelas, dan ruang digunakan untuk pengelompokan siswa,
        penjadwalan pelajaran, serta absensi.
    </div>

</div>
<script>
let selectedLecturerId = null;

document.addEventListener('DOMContentLoaded', function() {
  lucide.createIcons();

  // Show modal only for links explicitly marked as not-yet-implemented
  document.querySelectorAll('a[data-page-not-found]').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('page-not-found-modal').classList.remove('hidden');
    });
  });

  // Bind filter events
  document.getElementById('searchInput').addEventListener('input', applyFilters);
  document.getElementById('departmentFilter').addEventListener('change', applyFilters);
  document.getElementById('statusFilter').addEventListener('change', applyFilters);
});

function closePageNotFoundModal() {
  document.getElementById('page-not-found-modal').classList.add('hidden');
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  sidebar.classList.toggle('-translate-x-full');
  overlay.classList.toggle('hidden');
  document.body.classList.toggle('overflow-hidden');
}

// Filter and Search Functions
function applyFilters() {
  const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
  const departmentValue = document.getElementById('departmentFilter').value;
  const statusValue = document.getElementById('statusFilter').value;

  const rows = document.querySelectorAll('.lecturer-row');
  const cards = document.querySelectorAll('.lecturer-card');
  let visibleCount = 0;

  // Filter table rows
  rows.forEach(row => {
    const searchableText = (row.dataset.searchable || '').toLowerCase();
    const matchesSearch = searchTerm === '' || searchableText.includes(searchTerm);
    const matchesDepartment = departmentValue === 'all' || row.dataset.department === departmentValue;
    const matchesStatus = statusValue === 'all' || row.dataset.status === statusValue;

    const isVisible = matchesSearch && matchesDepartment && matchesStatus;
    row.style.display = isVisible ? '' : 'none';
    if (isVisible) visibleCount++;
  });

  // Filter mobile cards
  cards.forEach(card => {
    const searchableText = (card.dataset.searchable || '').toLowerCase();
    const matchesSearch = searchTerm === '' || searchableText.includes(searchTerm);
    const matchesDepartment = departmentValue === 'all' || card.dataset.department === departmentValue;
    const matchesStatus = statusValue === 'all' || card.dataset.status === statusValue;

    const isVisible = matchesSearch && matchesDepartment && matchesStatus;
    card.style.display = isVisible ? '' : 'none';
  });

  // Update visible count
  document.getElementById('visibleCount').textContent = visibleCount;

  // Show/hide no results message
  const noResults = document.getElementById('noResults');
  noResults.classList.toggle('hidden', visibleCount > 0);
}

function resetFilters() {
  document.getElementById('searchInput').value = '';
  document.getElementById('departmentFilter').value = 'all';
  document.getElementById('statusFilter').value = 'all';
  applyFilters();
}

// Bulk Actions
function toggleSelectAll() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.lecturer-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });
  
  updateBulkActions();
}

function updateBulkActions() {
  const checkboxes = document.querySelectorAll('.lecturer-checkbox:checked');
  const bulkActions = document.getElementById('bulkActions');
  const selectedCount = document.getElementById('selectedCount');
  
  selectedCount.textContent = checkboxes.length;
  bulkActions.classList.toggle('hidden', checkboxes.length === 0);
  
  // Update select all checkbox
  const allCheckboxes = document.querySelectorAll('.lecturer-checkbox');
  const selectAll = document.getElementById('selectAll');
  selectAll.checked = checkboxes.length === allCheckboxes.length;
  selectAll.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
}

function bulkExport() {
  const selected = document.querySelectorAll('.lecturer-checkbox:checked');
  showToast(`Exporting ${selected.length} lecturers...`, 'success');
}

function bulkUpdateStatus() {
  const selected = document.querySelectorAll('.lecturer-checkbox:checked');
  showToast(`Updating status for ${selected.length} lecturers...`, 'success');
}

// Lecturer Detail Panel Functions
function viewLecturer(id) {
  console.log('viewLecturer called with ID:', id);
  
  selectedLecturerId = id;
  
  // Get lecturer data
  const data = lecturerData[id];
  
  if (!data) {
    console.error('Lecturer data not found for ID:', id);
    showToast('Lecturer data not found', 'error');
    return;
  }
  
  console.log('Found lecturer data:', data);
  
  // Get all required elements
  const detailAvatar = document.getElementById('detailAvatar');
  const detailName = document.getElementById('detailName');
  const detailId = document.getElementById('detailId');
  const detailDepartment = document.getElementById('detailDepartment');
  const detailClasses = document.getElementById('detailClasses');
  const detailWorkload = document.getElementById('detailWorkload');
  const detailExperience = document.getElementById('detailExperience');
  const detailStatus = document.getElementById('detailStatus');
  const detailClassList = document.getElementById('detailClassList');
  const lecturerDetailContent = document.getElementById('lecturerDetailContent');
  const lecturerDetailInfo = document.getElementById('lecturerDetailInfo');
  
  // Check if all elements exist
  if (!detailAvatar || !detailName || !detailId || !detailDepartment || 
      !detailClasses || !detailWorkload || !detailExperience || 
      !detailStatus || !detailClassList || !lecturerDetailContent || !lecturerDetailInfo) {
    console.error('One or more detail panel elements not found');
    showToast('Error loading lecturer details', 'error');
    return;
  }
  
  try {
    // Update all fields
    detailAvatar.src = data.avatar;
    detailAvatar.alt = data.name;
    detailName.textContent = data.name;
    detailId.textContent = data.id;
    detailDepartment.textContent = data.department;
    detailClasses.textContent = data.classes;
    detailWorkload.textContent = data.workload;
    detailExperience.textContent = data.experience;
    
    // Update status badge with proper styling
    detailStatus.textContent = data.status;
    detailStatus.className = 'mt-2 px-3 py-1 rounded-full text-xs font-medium ' + 
      (data.status === 'Active' 
        ? 'bg-success-light text-success-dark'
        : data.status === 'On Leave'
        ? 'bg-warning-light text-warning-dark'
        : 'bg-error-light text-error-dark');
    
    // Update class list
    detailClassList.innerHTML = data.classList.map(cls => 
      `<div class="text-xs text-secondary bg-muted px-2 py-1 rounded-lg">${cls}</div>`
    ).join('');
    
    // Show detail panel and hide placeholder
    lecturerDetailContent.classList.add('hidden');
    lecturerDetailInfo.classList.remove('hidden');
    
    console.log('Lecturer details updated successfully');
    
    // Re-initialize Lucide icons for any new icons
    lucide.createIcons();
    
  } catch (error) {
    console.error('Error updating lecturer details:', error);
    showToast('Error displaying lecturer details', 'error');
  }
}

function closeLecturerDetail() {
  selectedLecturerId = null;
  const lecturerDetailContent = document.getElementById('lecturerDetailContent');
  const lecturerDetailInfo = document.getElementById('lecturerDetailInfo');
  
  if (lecturerDetailContent && lecturerDetailInfo) {
    lecturerDetailContent.classList.remove('hidden');
    lecturerDetailInfo.classList.add('hidden');
  }
}

function editSelectedLecturer() {
  if (selectedLecturerId) {
    editLecturer(selectedLecturerId);
  }
}

function viewSchedule() {
  if (selectedLecturerId) {
    const data = lecturerData[selectedLecturerId];
    showToast(`Opening schedule for ${data ? data.name : 'selected lecturer'}...`, 'info');
  } else {
    showToast('Please select a lecturer first', 'error');
  }
}

// Modal Functions
function openAddLecturerModal() {
  document.getElementById('addLecturerModal').classList.remove('hidden');
}

function closeAddLecturerModal() {
  document.getElementById('addLecturerModal').classList.add('hidden');
  document.getElementById('addLecturerForm').reset();
}

// Form Submission
document.getElementById('addLecturerForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = {
    name: document.getElementById('lecturerName').value,
    id: document.getElementById('lecturerId').value,
    department: document.getElementById('lecturerDepartment').value,
    email: document.getElementById('lecturerEmail').value,
    phone: document.getElementById('lecturerPhone').value,
    status: document.getElementById('lecturerStatus').value
  };
  
  // Simulate adding lecturer
  showToast('Lecturer added successfully!', 'success');
  closeAddLecturerModal();
});

// Action Functions
function editLecturer(id) {
  const data = lecturerData[id];
  showToast(`Opening edit form for ${data ? data.name : 'lecturer ' + id}...`, 'info');
}

function exportLecturers() {
  showToast('Exporting lecturers data...', 'success');
}

// Toast Notification
function showToast(message, type = 'success') {
  const toast = document.createElement('div');
  const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-error' : 'bg-primary';
  toast.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-3 rounded-xl z-50 font-medium shadow-lg`;
  toast.textContent = message;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}
</script>
<script>
function toggleSekolah() {
  const menu = document.getElementById("menuSekolah");
  const arrow = document.getElementById("arrowSekolah");
  // toggle visibility and rotation
  menu.classList.toggle("hidden");
  arrow.classList.toggle("rotate-180");

  // update aria-expanded on the parent button for accessibility
  const btn = arrow.closest('button');
  if (btn) {
    const isOpen = !menu.classList.contains('hidden');
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  }
}
</script>
</div>
@endsection