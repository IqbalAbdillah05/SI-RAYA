

<?php $__env->startSection('title', 'Bantuan & FAQ'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Bantuan & FAQ</h1>
    <p>Panduan penggunaan sistem dan pertanyaan yang sering diajukan</p>
</div>

<div class="faq-container">
    <!-- Presensi Dosen -->
    <div class="faq-category">
        <h2>📍 Presensi Dosen</h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana cara melakukan presensi?</strong>
            </div>
            <div class="faq-answer">
                A: Buka menu "Presensi Dosen", pilih mata kuliah yang akan diajar, pastikan Anda berada di lokasi yang ditentukan, lalu klik "Mulai Presensi". Sistem akan otomatis mendeteksi lokasi Anda.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Mengapa presensi saya ditolak?</strong>
            </div>
            <div class="faq-answer">
                A: Presensi dapat ditolak jika:
                <ul>
                    <li>Anda berada di luar radius yang ditentukan</li>
                    <li>Browser tidak memiliki akses ke lokasi</li>
                    <li>Jadwal mengajar belum dimulai atau sudah selesai</li>
                </ul>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana cara mengakhiri presensi?</strong>
            </div>
            <div class="faq-answer">
                A: Setelah kelas selesai, buka menu "Presensi Dosen", cari presensi yang masih aktif, lalu klik tombol "Selesai".
            </div>
        </div>
    </div>

    <!-- Presensi Mahasiswa -->
    <div class="faq-category">
        <h2>👥 Presensi Mahasiswa</h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana cara mempresensi mahasiswa?</strong>
            </div>
            <div class="faq-answer">
                A: Presensi mahasiswa dilakukan oleh dosen, bukan mahasiswa yang presensi sendiri. Ada 2 cara:
                <ul>
                    <li><strong>Cara 1 - Presensi Langsung:</strong> Buka menu "Presensi Mahasiswa" → Klik "Presensi Baru" → Pilih Prodi, Semester, Mata Kuliah, dan Tanggal → Centang mahasiswa dan pilih status → Simpan.</li>
                    <li><strong>Cara 2 - Setelah Presensi Dosen:</strong> Setelah Anda memulai presensi dosen, Anda dapat langsung mempresensi mahasiswa melalui menu "Presensi Mahasiswa".</li>
                </ul>
                <em>Ingat: Dosen yang wajib mempresensi mahasiswa, bukan mahasiswa yang presensi sendiri.</em>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bisakah saya mengubah status presensi mahasiswa?</strong>
            </div>
            <div class="faq-answer">
                A: Ya, Anda dapat mengubah status presensi mahasiswa yang sudah tersimpan. Buka menu "Presensi Mahasiswa" → "Riwayat Presensi" → Klik tombol "Edit" pada presensi yang ingin diubah → Ubah status atau keterangan → Simpan.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana jika ada mahasiswa yang tidak hadir atau lupa dipresensi?</strong>
            </div>
            <div class="faq-answer">
                A: Anda dapat menambahkan atau melengkapi presensi mahasiswa kapan saja melalui fitur "Presensi Baru". Caranya:
                <ul>
                    <li>Buka menu "Presensi Mahasiswa"</li>
                    <li>Klik tombol "Presensi Baru"</li>
                    <li>Pilih Prodi, Semester, dan Mata Kuliah</li>
                    <li>Pilih tanggal presensi (bisa hari ini atau tanggal sebelumnya)</li>
                    <li>Centang mahasiswa yang ingin dipresensi dan pilih status (Hadir/Izin/Sakit/Alpha)</li>
                    <li>Klik "Simpan Presensi"</li>
                </ul>
                <em>Catatan: Untuk status Izin/Sakit, wajib upload foto bukti.</em>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Apa perbedaan status Hadir, Izin, Sakit, dan Alpha?</strong>
            </div>
            <div class="faq-answer">
                A: Berikut penjelasan setiap status:
                <ul>
                    <li><strong>Hadir:</strong> Mahasiswa hadir mengikuti kelas</li>
                    <li><strong>Izin:</strong> Mahasiswa tidak hadir dengan izin tertentu (wajib upload foto bukti surat izin)</li>
                    <li><strong>Sakit:</strong> Mahasiswa tidak hadir karena sakit (wajib upload foto bukti surat dokter)</li>
                    <li><strong>Alpha:</strong> Mahasiswa tidak hadir tanpa keterangan/alasan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Input Nilai -->
    <div class="faq-category">
        <h2>📝 Input Nilai Mahasiswa</h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana cara menginput nilai mahasiswa?</strong>
            </div>
            <div class="faq-answer">
                A: Dosen hanya perlu menginput nilai angka (0-100), sistem akan otomatis mengkonversi ke grade. Caranya:
                <ul>
                    <li>Buka menu "Input Nilai"</li>
                    <li>Pilih atau cari mahasiswa yang ingin dinilai</li>
                    <li>Klik tombol "Input Nilai" atau "Edit"</li>
                    <li>Masukkan nilai angka (0-100)</li>
                    <li>Klik "Simpan"</li>
                </ul>
                <em>Catatan: Sistem akan otomatis mengkonversi nilai angka menjadi nilai huruf (A+, A, A-, B+, B, B-, C+, C, D, E) dan nilai indeks (0.00-4.00).</em>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Apakah nilai yang sudah diinput bisa diubah?</strong>
            </div>
            <div class="faq-answer">
                A: Ya, nilai masih dapat diubah selama periode input nilai belum ditutup oleh admin. Buka menu "Input Nilai" → Cari mahasiswa → Klik "Edit" → Ubah nilai angka → Simpan.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana sistem mengkonversi nilai angka ke grade?</strong>
            </div>
            <div class="faq-answer">
                A: Sistem otomatis mengkonversi berdasarkan tabel berikut:
                <ul>
                    <li><strong>A+</strong> = 96-100 (Indeks: 4.00)</li>
                    <li><strong>A</strong> = 86-95 (Indeks: 3.50)</li>
                    <li><strong>A-</strong> = 81-85 (Indeks: 3.25)</li>
                    <li><strong>B+</strong> = 76-80 (Indeks: 3.00)</li>
                    <li><strong>B</strong> = 71-75 (Indeks: 2.75)</li>
                    <li><strong>B-</strong> = 66-70 (Indeks: 2.50)</li>
                    <li><strong>C+</strong> = 61-65 (Indeks: 2.25)</li>
                    <li><strong>C</strong> = 56-60 (Indeks: 2.00)</li>
                    <li><strong>D</strong> = 41-55 (Indeks: 1.00)</li>
                    <li><strong>E</strong> = 0-40 (Indeks: 0.00)</li>
                </ul>
                <em>Anda tidak perlu menghitung manual, cukup input nilai angka saja.</em>
            </div>
        </div>
    </div>

    <!-- Jadwal Mengajar -->
    <div class="faq-category">
        <h2>📅 Jadwal Mengajar</h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana cara melihat jadwal mengajar saya?</strong>
            </div>
            <div class="faq-answer">
                A: Buka menu "Jadwal Mengajar" atau lihat di Dashboard pada bagian "Jadwal Hari Ini". Anda dapat melihat semua jadwal lengkap dengan waktu, ruangan, dan mata kuliah.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Bagaimana jika ada perubahan jadwal?</strong>
            </div>
            <div class="faq-answer">
                A: Perubahan jadwal dilakukan oleh admin/bagian akademik. Jika ada perubahan, jadwal akan otomatis diperbarui di sistem. Pastikan Anda selalu mengecek jadwal sebelum mengajar.
            </div>
        </div>
    </div>

    <!-- Masalah Teknis -->
    <div class="faq-category">
        <h2>⚙️ Masalah Teknis</h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Sistem tidak dapat mengakses lokasi saya</strong>
            </div>
            <div class="faq-answer">
                A: Pastikan:
                <ul>
                    <li>Browser memiliki izin akses lokasi (cek di pengaturan browser)</li>
                    <li>GPS/Location Service di perangkat Anda aktif</li>
                    <li>Anda menggunakan koneksi HTTPS (aman)</li>
                </ul>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Lupa password, bagaimana cara reset?</strong>
            </div>
            <div class="faq-answer">
                A: Silakan hubungi admin sistem atau bagian IT untuk melakukan reset password. Anda perlu memverifikasi identitas terlebih dahulu.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <strong>Q: Data tidak tersimpan atau error saat menyimpan</strong>
            </div>
            <div class="faq-answer">
                A: Coba langkah berikut:
                <ul>
                    <li>Refresh halaman dan coba lagi</li>
                    <li>Clear cache browser Anda</li>
                    <li>Pastikan koneksi internet stabil</li>
                    <li>Jika masih error, hubungi admin dengan screenshot error yang muncul</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Butuh Bantuan Lebih Lanjut -->
    <div class="faq-footer">
        <div class="help-box">
            <h3>Masih Butuh Bantuan?</h3>
            <p>Jika pertanyaan Anda tidak terjawab di sini, silakan hubungi:</p>
            <div class="contact-links">
                <a href="<?php echo e(route('dosen.bantuan.kontak')); ?>" class="btn-contact">
                    📞 Hubungi Admin
                </a>
                <a href="<?php echo e(route('dosen.bantuan.dokumentasi')); ?>" class="btn-contact">
                    📚 Lihat Dokumentasi Lengkap
                </a>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: #666;
        font-size: 0.95rem;
    }

    .faq-container {
        max-width: 900px;
    }

    .faq-category {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .faq-category h2 {
        font-size: 1.3rem;
        color: #2563eb;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .faq-item {
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .faq-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .faq-question {
        margin-bottom: 0.5rem;
    }

    .faq-question strong {
        color: #1f2937;
        font-size: 1rem;
    }

    .faq-answer {
        color: #4b5563;
        line-height: 1.6;
        padding-left: 1rem;
    }

    .faq-answer ul {
        margin-top: 0.5rem;
        margin-bottom: 0;
        padding-left: 1.5rem;
    }

    .faq-answer li {
        margin-bottom: 0.25rem;
    }

    .faq-footer {
        margin-top: 2rem;
    }

    .help-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .help-box h3 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .help-box p {
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }

    .contact-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-contact {
        background: white;
        color: #667eea;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #764ba2;
    }

    @media (max-width: 768px) {
        .faq-category {
            padding: 1rem;
        }

        .faq-category h2 {
            font-size: 1.1rem;
        }

        .help-box {
            padding: 1.5rem;
        }

        .contact-links {
            flex-direction: column;
        }

        .btn-contact {
            width: 100%;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dosen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/dosen/bantuan/index.blade.php ENDPATH**/ ?>