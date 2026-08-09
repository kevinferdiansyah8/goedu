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

    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });

    const loginAndCapture = async (email, password, pagesToCapture) => {
        console.log(`Logging in as ${email}...`);
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
        await page.type('input[name="email"]', email);
        await page.type('input[name="password"]', password);
        
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' })
        ]);

        for (const item of pagesToCapture) {
            console.log(`Navigating to ${item.url}...`);
            await page.goto(`${BASE_URL}${item.url}`, { waitUntil: 'networkidle0' });
            await new Promise(r => setTimeout(r, 1000)); // allow animations
            const imgPath = path.join(OUT_DIR, item.filename);
            await page.screenshot({ path: imgPath, fullPage: false });
            console.log(`Saved screenshot: ${item.filename}`);
        }

        // Logout
        await page.goto(`${BASE_URL}/logout`, { waitUntil: 'networkidle0' }).catch(() => {});
        // Alternatively submit logout form if POST
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
    };

    try {
        // 1. Landing Page & PPDB (Public)
        console.log('Capturing Landing Page & PPDB...');
        await page.goto(`${BASE_URL}/`, { waitUntil: 'networkidle0' });
        await page.screenshot({ path: path.join(OUT_DIR, '01_landing_page.png') });

        await page.goto(`${BASE_URL}/ppdb`, { waitUntil: 'networkidle0' });
        await page.screenshot({ path: path.join(OUT_DIR, '02_ppdb_portal.png') });

        await page.goto(`${BASE_URL}/ppdb/sma/step1`, { waitUntil: 'networkidle0' });
        await page.screenshot({ path: path.join(OUT_DIR, '03_ppdb_form.png') });

        // 2. Admin Role
        await loginAndCapture('admin@goedu.sch.id', 'admin123', [
            { url: '/admin/dashboard', filename: '04_admin_dashboard.png' },
            { url: '/admin/users', filename: '05_admin_users.png' },
            { url: '/admin/akademik/mata-pelajaran', filename: '06_admin_mapel.png' },
            { url: '/admin/akademik/jadwal-pelajaran', filename: '07_admin_jadwal.png' },
            { url: '/admin/absensi/absensi-siswa', filename: '08_admin_absensi.png' }
        ]);

        // 3. Guru Role
        await loginAndCapture('budi@goedu.sch.id', 'guru123', [
            { url: '/guru/dashboard', filename: '09_guru_dashboard.png' },
            { url: '/guru/elearning', filename: '10_guru_elearning.png' },
            { url: '/guru/materi-tugas/materi', filename: '11_guru_materi.png' },
            { url: '/guru/absensi', filename: '12_guru_absensi.png' },
            { url: '/guru/akademik/rekap-nilai', filename: '13_guru_nilai.png' }
        ]);

        // 4. Siswa Role
        await loginAndCapture('ahmad@goedu.sch.id', 'siswa123', [
            { url: '/siswa/dashboard', filename: '14_siswa_dashboard.png' },
            { url: '/siswa/elearning', filename: '15_siswa_elearning.png' },
            { url: '/siswa/akademik/nilai', filename: '16_siswa_nilai.png' }
        ]);

        // 5. Orang Tua Role
        await loginAndCapture('orangtua@goedu.sch.id', 'orangtua123', [
            { url: '/orangtua/dashboard', filename: '17_ortu_dashboard.png' },
            { url: '/orangtua/presensi', filename: '18_ortu_presensi.png' },
            { url: '/orangtua/nilai', filename: '19_ortu_nilai.png' }
        ]);

        // 6. Keuangan Role
        await loginAndCapture('keuangan@goedu.sch.id', 'keuangan123', [
            { url: '/keuangan/dashboard', filename: '20_keuangan_dashboard.png' },
            { url: '/keuangan/pembayaran-siswa/tagihan', filename: '21_keuangan_tagihan.png' }
        ]);

        console.log('All screenshots captured successfully!');
    } catch (err) {
        console.error('Error capturing screenshots:', err);
    } finally {
        await browser.close();
    }
}

capture();
