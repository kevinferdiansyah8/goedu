const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://127.0.0.1:8000';
const OUT_DIR = path.join(__dirname, 'docs_screenshots');

if (!fs.existsSync(OUT_DIR)) {
    fs.mkdirSync(OUT_DIR, { recursive: true });
}

async function capture() {
    console.log('Starting browser...');
    const browser = await puppeteer.launch({
        executablePath: CHROME_PATH,
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1440,900']
    });

    const runRole = async (roleKey, pagesToCapture) => {
        console.log(`\n=== Starting session for role: ${roleKey || 'Public'} ===`);
        const context = await browser.createBrowserContext();
        const page = await context.newPage();
        await page.setViewport({ width: 1440, height: 900 });

        if (roleKey) {
            console.log(`Performing dev-login for role ${roleKey}...`);
            await page.goto(`${BASE_URL}/dev-login/${roleKey}`, { waitUntil: 'domcontentloaded', timeout: 30000 });
            await new Promise(r => setTimeout(r, 500));
            console.log(`Logged in URL: ${page.url()}`);
        }

        for (const item of pagesToCapture) {
            console.log(`Navigating to ${item.url}...`);
            try {
                await page.goto(`${BASE_URL}${item.url}`, { waitUntil: 'domcontentloaded', timeout: 30000 });
                await new Promise(r => setTimeout(r, 1200)); // allow rendering
                const imgPath = path.join(OUT_DIR, item.filename);
                await page.screenshot({ path: imgPath, fullPage: false });
                console.log(`Saved screenshot: ${item.filename} (Final URL: ${page.url()})`);
            } catch (e) {
                console.error(`Failed to capture ${item.url}:`, e.message);
            }
        }

        await context.close();
    };

    try {
        // 1. Landing & PPDB (Public)
        await runRole(null, [
            { url: '/', filename: '01_landing_page.png' },
            { url: '/ppdb', filename: '02_ppdb_portal.png' },
            { url: '/ppdb/register/sma/step1', filename: '03_ppdb_form.png' },
            { url: '/ppdb/cek-status', filename: '03b_ppdb_status.png' }
        ]);

        // 2. Admin Role
        await runRole('admin', [
            { url: '/admin/dashboard', filename: '04_admin_dashboard.png' },
            { url: '/admin/users', filename: '05_admin_users.png' },
            { url: '/admin/kepegawaian/data-guru', filename: '05b_admin_data_guru.png' },
            { url: '/admin/kepegawaian/arsip-kepegawaian', filename: '05c_admin_arsip.png' },
            { url: '/admin/akademik/mata-pelajaran', filename: '06_admin_mapel.png' },
            { url: '/admin/akademik/kelas-wali-kelas', filename: '06b_admin_kelas.png' },
            { url: '/admin/akademik/jadwal-pelajaran', filename: '07_admin_jadwal.png' },
            { url: '/admin/absensi/siswa', filename: '08_admin_absensi.png' },
            { url: '/admin/ppdb/data-pendaftar', filename: '08b_admin_ppdb_pendaftar.png' }
        ]);

        // 3. Guru Role
        await runRole('guru', [
            { url: '/guru/dashboard', filename: '09_guru_dashboard.png' },
            { url: '/guru/elearning', filename: '10_guru_elearning.png' },
            { url: '/guru/akademik/kelas-siswa', filename: '10b_guru_kelas_siswa.png' },
            { url: '/guru/materi/materi', filename: '11_guru_materi.png' },
            { url: '/guru/materi/tugas', filename: '11b_guru_tugas.png' },
            { url: '/guru/absensi', filename: '12_guru_absensi.png' },
            { url: '/guru/absensi/absensi-pertemuan', filename: '12b_guru_absensi_pertemuan.png' },
            { url: '/guru/akademik/rekap-nilai', filename: '13_guru_nilai.png' },
            { url: '/guru/akademik/nilai-tugas', filename: '13b_guru_input_nilai.png' }
        ]);

        // 4. Siswa Role
        await runRole('siswa', [
            { url: '/siswa/dashboard', filename: '14_siswa_dashboard.png' },
            { url: '/siswa/elearning', filename: '15_siswa_elearning.png' },
            { url: '/siswa/pembelajaran/materi', filename: '15b_siswa_materi.png' },
            { url: '/siswa/akademik/tugas', filename: '15c_siswa_tugas.png' },
            { url: '/siswa/akademik/nilai', filename: '16_siswa_nilai.png' },
            { url: '/siswa/kehadiran/riwayat', filename: '16b_siswa_absensi.png' }
        ]);

        // 5. Orang Tua Role
        await runRole('orangtua', [
            { url: '/orangtua/dashboard', filename: '17_ortu_dashboard.png' },
            { url: '/orangtua/monitoring/presensi', filename: '18_ortu_presensi.png' },
            { url: '/orangtua/absensi/izin', filename: '18b_ortu_form_izin.png' },
            { url: '/orangtua/monitoring/nilai', filename: '19_ortu_nilai.png' },
            { url: '/orangtua/keuangan/tagihan', filename: '19b_ortu_spp.png' }
        ]);

        // 6. Keuangan Role
        await runRole('keuangan', [
            { url: '/keuangan/dashboard', filename: '20_keuangan_dashboard.png' },
            { url: '/keuangan/pembayaran-siswa/tagihan', filename: '21_keuangan_tagihan.png' },
            { url: '/keuangan/pembayaran-siswa/riwayat', filename: '21b_keuangan_riwayat.png' },
            { url: '/keuangan/laporan', filename: '21c_keuangan_laporan.png' }
        ]);

        console.log('\nAll screenshots captured successfully!');
    } catch (err) {
        console.error('Error capturing screenshots:', err);
    } finally {
        await browser.close();
    }
}

capture();
