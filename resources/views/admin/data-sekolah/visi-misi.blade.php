@extends('layouts.admin')

@section('title', 'Visi, Misi & Struktur Organisasi Sekolah')

@section('content')
<div class="flex-1 overflow-y-auto p-5 md:p-8">

  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-foreground text-2xl md:text-3xl font-bold mb-1">
      Visi, Misi & Struktur Organisasi
    </h1>
    <p class="text-secondary text-sm md:text-base">
      Kelola visi, misi, dan struktur organisasi sekolah
    </p>
  </div>

  <!-- Visi & Misi -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Visi -->
    <div class="rounded-2xl border border-border bg-white p-6 space-y-4">
      <h3 class="text-lg font-bold text-foreground">Visi Sekolah</h3>

      <textarea
        rows="4"
        placeholder="Masukkan visi sekolah..."
        class="w-full px-4 py-3 border border-border rounded-2xl
               focus:outline-none focus:border-primary
               focus:ring-2 focus:ring-primary/20"></textarea>
    </div>

    <!-- Misi -->
    <div class="rounded-2xl border border-border bg-white p-6 space-y-4">
      <h3 class="text-lg font-bold text-foreground">Misi Sekolah</h3>

      <textarea
        rows="6"
        placeholder="Masukkan misi sekolah (pisahkan per baris)..."
        class="w-full px-4 py-3 border border-border rounded-2xl
               focus:outline-none focus:border-primary
               focus:ring-2 focus:ring-primary/20"></textarea>
    </div>

  </div>

  <!-- Struktur Organisasi -->
  <div class="rounded-2xl border border-border bg-white p-6 mb-8">
    <h3 class="text-lg font-bold text-foreground mb-4">Struktur Organisasi</h3>

    <label
      class="flex flex-col items-center justify-center border-2 border-dashed
             border-border rounded-2xl p-8 text-center cursor-pointer
             hover:border-primary transition">
      <span class="text-secondary mb-2">
        Upload gambar struktur organisasi sekolah
      </span>
      <span class="text-sm text-muted">
        (PNG / JPG, maksimal 2MB)
      </span>
      <input type="file" class="hidden">
    </label>
  </div>

  <!-- Action -->
  <div class="flex justify-end">
    <button
      class="px-8 py-3 bg-primary text-white rounded-full font-semibold
             hover:bg-primary-hover transition">
      Simpan Perubahan
    </button>
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