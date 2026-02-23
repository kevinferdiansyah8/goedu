@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-xl mx-auto" x-data="{ 
	showOld: false, showNew: false, showConfirm: false,
	oldPass: '', newPass: '', confirmPass: '',
	get strength() {
		let s = 0;
		if (this.newPass.length >= 8) s++;
		if (/[A-Z]/.test(this.newPass)) s++;
		if (/[0-9]/.test(this.newPass)) s++;
		if (/[^A-Za-z0-9]/.test(this.newPass)) s++;
		return s;
	},
	get strengthLabel() {
		const labels = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
		return labels[this.strength];
	},
	get strengthColor() {
		const colors = ['bg-gray-200', 'bg-red-500', 'bg-amber-500', 'bg-blue-500', 'bg-emerald-500'];
		return colors[this.strength];
	},
	get match() {
		return this.newPass && this.confirmPass && this.newPass === this.confirmPass;
	}
}">

	<!-- Header -->
	<div class="flex items-center gap-3 mb-6">
		<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center shadow-lg shadow-rose-200">
			<i data-lucide="lock" class="w-5 h-5 text-white"></i>
		</div>
		<div>
			<h1 class="text-2xl font-extrabold text-gray-900">Ganti Password</h1>
			<p class="text-gray-400 text-xs">Perbarui password akun Anda secara berkala</p>
		</div>
	</div>

	<!-- Info Banner -->
	<div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 mb-6 flex items-start gap-3">
		<div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
			<i data-lucide="shield-alert" class="w-4 h-4 text-amber-600"></i>
		</div>
		<div>
			<p class="text-sm font-bold text-amber-800 mb-1">Tips Keamanan Password</p>
			<ul class="text-xs text-amber-700 space-y-0.5">
				<li>• Gunakan minimal <strong>8 karakter</strong></li>
				<li>• Kombinasikan <strong>huruf besar</strong>, <strong>angka</strong>, dan <strong>simbol</strong></li>
				<li>• Jangan gunakan password yang sama dengan akun lain</li>
			</ul>
		</div>
	</div>

	<!-- Form Card -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
		<div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-4">
			<div class="flex items-center gap-2">
				<i data-lucide="key" class="w-5 h-5 text-rose-200"></i>
				<span class="text-white text-sm font-bold uppercase tracking-wider">Ubah Password</span>
			</div>
		</div>

		<form class="p-6 space-y-5">
			<!-- Old Password -->
			<div>
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password Lama <span class="text-red-400">*</span></label>
				<div class="relative">
					<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
						<i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
					</div>
					<input :type="showOld ? 'text' : 'password'" x-model="oldPass" placeholder="Masukkan password lama" class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-100 focus:border-rose-400 focus:bg-white transition-all">
					<button type="button" @click="showOld = !showOld" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
						<i :data-lucide="showOld ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
					</button>
				</div>
			</div>

			<!-- New Password -->
			<div>
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password Baru <span class="text-red-400">*</span></label>
				<div class="relative">
					<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
						<i data-lucide="key" class="w-4 h-4 text-gray-400"></i>
					</div>
					<input :type="showNew ? 'text' : 'password'" x-model="newPass" placeholder="Masukkan password baru" class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-100 focus:border-rose-400 focus:bg-white transition-all">
					<button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
						<i :data-lucide="showNew ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
					</button>
				</div>
				<!-- Strength Indicator -->
				<div x-show="newPass.length > 0" class="mt-2">
					<div class="flex gap-1 mb-1">
						<div class="h-1.5 flex-1 rounded-full transition-all" :class="strength >= 1 ? strengthColor : 'bg-gray-200'"></div>
						<div class="h-1.5 flex-1 rounded-full transition-all" :class="strength >= 2 ? strengthColor : 'bg-gray-200'"></div>
						<div class="h-1.5 flex-1 rounded-full transition-all" :class="strength >= 3 ? strengthColor : 'bg-gray-200'"></div>
						<div class="h-1.5 flex-1 rounded-full transition-all" :class="strength >= 4 ? strengthColor : 'bg-gray-200'"></div>
					</div>
					<p class="text-[10px] font-bold uppercase tracking-wider" :class="{
						'text-red-500': strength === 1,
						'text-amber-500': strength === 2,
						'text-blue-500': strength === 3,
						'text-emerald-500': strength === 4
					}" x-text="'Kekuatan: ' + strengthLabel"></p>
				</div>
			</div>

			<!-- Confirm Password -->
			<div>
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Konfirmasi Password <span class="text-red-400">*</span></label>
				<div class="relative">
					<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
						<i data-lucide="shield-check" class="w-4 h-4 text-gray-400"></i>
					</div>
					<input :type="showConfirm ? 'text' : 'password'" x-model="confirmPass" placeholder="Ulangi password baru" class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-100 focus:border-rose-400 focus:bg-white transition-all" :class="confirmPass && !match ? 'border-red-300 focus:border-red-400 focus:ring-red-100' : ''">
					<button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
						<i :data-lucide="showConfirm ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
					</button>
				</div>
				<p x-show="confirmPass && !match" class="text-[10px] text-red-500 font-bold mt-1 flex items-center gap-1">
					<i data-lucide="x-circle" class="w-3 h-3"></i> Password tidak sama
				</p>
				<p x-show="match" class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
					<i data-lucide="check-circle-2" class="w-3 h-3"></i> Password cocok
				</p>
			</div>

			<!-- Actions -->
			<div class="flex justify-end gap-2.5 pt-4 border-t border-gray-100">
				<a href="{{ url()->previous() }}" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</a>
				<button type="submit" :disabled="!oldPass || !match || strength < 2" :class="(!oldPass || !match || strength < 2) ? 'opacity-50 cursor-not-allowed' : 'hover:from-rose-600 hover:to-pink-700 active:scale-95'" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-rose-200 transition-all">
					<i data-lucide="save" class="w-4 h-4"></i>
					Simpan Password
				</button>
			</div>
		</form>
	</div>

	<!-- Last Changed Info -->
	<div class="mt-4 text-center">
		<p class="text-[10px] text-gray-400">Password terakhir diubah: <strong class="text-gray-500">15 Januari 2025</strong></p>
	</div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	if (window.lucide) lucide.createIcons();
});
</script>
@endpush
