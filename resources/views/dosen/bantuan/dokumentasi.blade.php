@extends('layouts.dosen')

@section('title', 'Dokumentasi Sistem')

@section('content')
<div class="page-header">
    <h1>📚 Dokumentasi Sistem</h1>
    <p>Panduan lengkap penggunaan Sistem Informasi Akademik STAI RAYA</p>
</div>

<div class="documentation-container">
    <!-- Quick Navigation -->
    <div class="doc-navigation">
        <h3>Navigasi Cepat</h3>
        <ul>
            <li><a href="#getting-started">Memulai</a></li>
            <li><a href="#presensi-dosen">Presensi Dosen</a></li>
            <li><a href="#presensi-mahasiswa">Presensi Mahasiswa</a></li>
            <li><a href="#input-nilai">Input Nilai</a></li>
            <li><a href="#jadwal">Jadwal Mengajar</a></li>
        </ul>
    </div>

    <!-- Getting Started -->
    <div class="doc-section" id="getting-started">
        <h2>🚀 Memulai</h2>
        
        <div class="doc-content">
            <h3>Login ke Sistem</h3>
            <ol>
                <li>Buka browser dan akses URL sistem (diberikan oleh admin)</li>
                <li>Masukkan username dan password yang telah diberikan</li>
                <li>Klik tombol "Login"</li>
                <li>Anda akan diarahkan ke Dashboard dosen</li>
            </ol>

            <div class="doc-note">
                <strong>💡 Tips:</strong> Gunakan browser modern seperti Chrome, Firefox, atau Edge untuk pengalaman terbaik.
            </div>
        </div>

        <div class="doc-content">
            <h3>Navigasi Dashboard</h3>
            <p>Dashboard menampilkan:</p>
            <ul>
                <li><strong>Statistik Cepat:</strong> Total presensi dan nilai yang telah diinput</li>
                <li><strong>Jadwal Hari Ini:</strong> Jadwal mengajar hari ini</li>
                <li><strong>Aktivitas Terbaru:</strong> Riwayat presensi dan nilai terbaru</li>
                <li><strong>Profil Dosen:</strong> Informasi data diri Anda</li>
            </ul>
        </div>
    </div>

    <!-- Presensi Dosen -->
    <div class="doc-section" id="presensi-dosen">
        <h2>📍 Presensi Dosen</h2>
        
        <div class="doc-content">
            <h3>Memulai Presensi</h3>
            <ol>
                <li>Buka menu <strong>"Presensi Dosen"</strong></li>
                <li>Klik tombol <strong>"Mulai Presensi"</strong></li>
                <li>Pilih mata kuliah yang akan diajar</li>
                <li>Pastikan Anda berada di lokasi kampus</li>
                <li>Izinkan browser mengakses lokasi Anda</li>
                <li>Sistem akan memverifikasi lokasi dan jadwal</li>
                <li>Jika valid, presensi akan tersimpan dengan status "Hadir"</li>
            </ol>

            <div class="doc-warning">
                <strong>⚠️ Penting:</strong> Presensi hanya dapat dilakukan jika:
                <ul>
                    <li>Anda berada dalam radius yang ditentukan dari lokasi kampus</li>
                    <li>Waktu sesuai dengan jadwal mengajar</li>
                    <li>Browser memiliki akses lokasi</li>
                </ul>
            </div>
        </div>

        <div class="doc-content">
            <h3>Mengakhiri Presensi</h3>
            <ol>
                <li>Setelah kelas selesai, buka menu <strong>"Presensi Dosen"</strong></li>
                <li>Cari presensi dengan status "Hadir" (sedang berlangsung)</li>
                <li>Klik tombol <strong>"Selesai"</strong></li>
                <li>Isi materi yang telah diajarkan (opsional)</li>
                <li>Tambahkan catatan jika diperlukan</li>
                <li>Klik <strong>"Simpan"</strong></li>
            </ol>
        </div>

        <div class="doc-content">
            <h3>Melihat Riwayat Presensi</h3>
            <p>Anda dapat melihat riwayat presensi dengan fitur filter:</p>
            <ul>
                <li><strong>Filter Mata Kuliah:</strong> Pilih mata kuliah tertentu</li>
                <li><strong>Filter Tanggal:</strong> Pilih rentang tanggal</li>
                <li><strong>Status:</strong> Hadir, Izin, Sakit, Alpha</li>
            </ul>
        </div>
    </div>

    <!-- Presensi Mahasiswa -->
    <div class="doc-section" id="presensi-mahasiswa">
        <h2>👥 Presensi Mahasiswa</h2>
        
        <div class="doc-content">
            <p><strong>Penting:</strong> Presensi mahasiswa dilakukan oleh <strong>dosen yang mengajar</strong>, bukan mahasiswa yang presensi sendiri. Dosen bertanggung jawab untuk mencatat kehadiran setiap mahasiswa di kelasnya.</p>
        </div>
        
        <div class="doc-content">
            <h3>Melihat Kehadiran Mahasiswa</h3>
            <ol>
                <li>Buka menu <strong>"Presensi Mahasiswa"</strong></li>
                <li>Pilih <strong>"Riwayat Presensi"</strong></li>
                <li>Gunakan filter untuk mencari presensi tertentu:
                    <ul>
                        <li>Cari berdasarkan nama atau NIM mahasiswa</li>
                        <li>Filter berdasarkan mata kuliah</li>
                        <li>Filter berdasarkan program studi</li>
                    </ul>
                </li>
            </ol>

            <div class="doc-note">
                <strong>💡 Tips:</strong> Filter bekerja secara real-time, Anda tidak perlu klik tombol cari.
            </div>
        </div>

        <div class="doc-content">
            <h3>Mengedit Presensi Mahasiswa</h3>
            <ol>
                <li>Pada daftar riwayat presensi, klik tombol <strong>"Edit"</strong></li>
                <li>Ubah status kehadiran (Hadir/Izin/Sakit/Alpha)</li>
                <li>Tambahkan keterangan jika diperlukan</li>
                <li>Klik <strong>"Simpan"</strong></li>
            </ol>
        </div>

        <div class="doc-content">
            <h3>Mempresensi Mahasiswa (Presensi Baru)</h3>
            <p>Sebagai dosen, Anda bertanggung jawab untuk mencatat kehadiran mahasiswa di setiap pertemuan. Gunakan fitur "Presensi Baru" untuk mempresensi mahasiswa.</p>
            <ol>
                <li>Buka menu <strong>"Presensi Mahasiswa"</strong></li>
                <li>Klik tombol <strong>"Presensi Baru"</strong></li>
                <li>Pilih <strong>Program Studi</strong> dan <strong>Semester</strong></li>
                <li>Pilih <strong>Mata Kuliah</strong> yang Anda ajar (otomatis muncul setelah pilih prodi & semester)</li>
                <li>Pilih <strong>Tanggal Presensi</strong> (bisa hari ini atau tanggal sebelumnya jika lupa)</li>
                <li>Sistem akan menampilkan daftar mahasiswa sesuai filter</li>
                <li>Centang mahasiswa yang ingin dipresensi</li>
                <li>Pilih status untuk setiap mahasiswa:
                    <ul>
                        <li><strong>Hadir:</strong> Mahasiswa hadir mengikuti kelas</li>
                        <li><strong>Izin:</strong> Mahasiswa tidak hadir dengan izin (wajib upload foto bukti surat izin)</li>
                        <li><strong>Sakit:</strong> Mahasiswa tidak hadir karena sakit (wajib upload foto bukti surat dokter)</li>
                        <li><strong>Alpha:</strong> Mahasiswa tidak hadir tanpa keterangan</li>
                    </ul>
                </li>
                <li>Tambahkan keterangan jika diperlukan (opsional)</li>
                <li>Klik <strong>"Simpan Presensi"</strong></li>
            </ol>

            <div class="doc-warning">
                <strong>⚠️ Penting:</strong>
                <ul>
                    <li><strong>Dosen yang mempresensi mahasiswa</strong>, bukan mahasiswa yang presensi sendiri</li>
                    <li>Foto bukti WAJIB untuk status Izin dan Sakit</li>
                    <li>Sistem akan otomatis melewati mahasiswa yang sudah dipresensi di tanggal yang sama</li>
                    <li>Waktu presensi otomatis menggunakan waktu server saat data disimpan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Input Nilai -->
    <div class="doc-section" id="input-nilai">
        <h2>📝 Input Nilai Mahasiswa</h2>
        
        <div class="doc-content">
            <p><strong>Penting:</strong> Dosen hanya perlu menginput <strong>nilai angka (0-100)</strong>. Sistem akan otomatis mengkonversi nilai angka menjadi nilai huruf (grade) dan nilai indeks.</p>
        </div>
        
        <div class="doc-content">
            <h3>Menginput Nilai</h3>
            <ol>
                <li>Buka menu <strong>"Input Nilai"</strong></li>
                <li>Gunakan filter untuk mencari mahasiswa:
                    <ul>
                        <li>Cari berdasarkan nama atau NIM</li>
                        <li>Filter berdasarkan mata kuliah</li>
                        <li>Filter berdasarkan program studi</li>
                    </ul>
                </li>
                <li>Klik tombol <strong>"Input Nilai"</strong> atau <strong>"Edit"</strong> pada mahasiswa</li>
                <li>Masukkan <strong>nilai angka (0-100)</strong></li>
                <li>Klik <strong>"Simpan"</strong></li>
            </ol>

            <div class="doc-note">
                <strong>💡 Otomatis Konversi:</strong>
                <p>Setelah Anda menyimpan nilai angka, sistem akan otomatis mengkonversi menjadi:</p>
                <ul>
                    <li><strong>Nilai Huruf</strong> (A+, A, A-, B+, B, B-, C+, C, D, E)</li>
                    <li><strong>Nilai Indeks</strong> (0.00 - 4.00)</li>
                </ul>
                <p>Anda tidak perlu menghitung atau memasukkan grade secara manual.</p>
            </div>
        </div>

        <div class="doc-content">
            <h3>Tabel Konversi Nilai</h3>
            <p>Sistem menggunakan tabel konversi berikut:</p>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="background: #f3f4f6;">
                        <th style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: left;">Nilai Angka</th>
                        <th style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">Nilai Huruf</th>
                        <th style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">Nilai Indeks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">96 - 100</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #059669;">A+</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">4.00</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">86 - 95</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #059669;">A</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">3.50</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">81 - 85</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #059669;">A-</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">3.25</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">76 - 80</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #2563eb;">B+</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">3.00</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">71 - 75</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #2563eb;">B</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">2.75</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">66 - 70</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #2563eb;">B-</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">2.50</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">61 - 65</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #d97706;">C+</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">2.25</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">56 - 60</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #d97706;">C</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">2.00</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">41 - 55</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #dc2626;">D</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">1.00</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem;">0 - 40</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center; font-weight: 600; color: #dc2626;">E</td>
                        <td style="border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="doc-content">
            <h3>Mengedit Nilai</h3>
            <ol>
                <li>Pada daftar mahasiswa, klik tombol <strong>"Edit"</strong></li>
                <li>Ubah nilai angka yang diperlukan</li>
                <li>Sistem akan otomatis menghitung ulang grade dan indeks</li>
                <li>Klik <strong>"Simpan"</strong></li>
            </ol>

            <div class="doc-warning">
                <strong>⚠️ Perhatian:</strong> Pastikan nilai angka yang diinput sudah benar. Setelah periode input ditutup oleh admin, nilai tidak dapat diubah lagi.
            </div>
        </div>

        <div class="doc-content">
            <h3>Filter & Pencarian</h3>
            <p>Gunakan fitur filter untuk memudahkan pencarian:</p>
            <ul>
                <li><strong>Cari Mahasiswa:</strong> Ketik nama atau NIM (real-time search)</li>
                <li><strong>Filter Mata Kuliah:</strong> Pilih mata kuliah tertentu</li>
                <li><strong>Filter Prodi:</strong> Pilih program studi</li>
            </ul>
            
            <div class="doc-note">
                <strong>💡 Tips:</strong> Filter bekerja secara real-time, Anda tidak perlu klik tombol cari.
            </div>
        </div>
    </div>

    <!-- Jadwal Mengajar -->
    <div class="doc-section" id="jadwal">
        <h2>📅 Jadwal Mengajar</h2>
        
        <div class="doc-content">
            <h3>Melihat Jadwal</h3>
            <ol>
                <li>Buka menu <strong>"Jadwal Mengajar"</strong></li>
                <li>Sistem akan menampilkan semua jadwal mengajar Anda</li>
                <li>Jadwal ditampilkan berurutan dari Senin sampai Minggu</li>
                <li>Informasi yang ditampilkan:
                    <ul>
                        <li>Hari dan tanggal</li>
                        <li>Jam mulai - jam selesai</li>
                        <li>Nama mata kuliah</li>
                        <li>Ruangan</li>
                        <li>Program studi</li>
                    </ul>
                </li>
            </ol>
        </div>

        <div class="doc-content">
            <h3>Filter Jadwal</h3>
            <p>Gunakan filter untuk mencari jadwal tertentu:</p>
            <ul>
                <li><strong>Cari Mata Kuliah:</strong> Ketik nama mata kuliah</li>
                <li><strong>Filter Prodi:</strong> Pilih program studi</li>
                <li><strong>Filter Hari:</strong> Pilih hari tertentu</li>
            </ul>

            <div class="doc-note">
                <strong>💡 Tips:</strong> Lihat jadwal hari ini di Dashboard untuk akses cepat.
            </div>
        </div>
    </div>

    <!-- Tips & Best Practices -->
    <div class="doc-section">
        <h2>💡 Tips & Best Practices</h2>
        
        <div class="doc-content">
            <h3>Keamanan</h3>
            <ul>
                <li>Jangan bagikan password Anda kepada siapapun</li>
                <li>Logout setelah selesai menggunakan sistem</li>
                <li>Ubah password secara berkala</li>
                <li>Jangan gunakan komputer publik untuk mengakses sistem</li>
            </ul>
        </div>

        <div class="doc-content">
            <h3>Efisiensi Penggunaan</h3>
            <ul>
                <li>Gunakan fitur filter untuk mencari data lebih cepat</li>
                <li>Cek dashboard setiap hari untuk update terbaru</li>
                <li>Input nilai segera setelah ujian untuk menghindari menumpuk</li>
                <li>Bookmark halaman sistem untuk akses cepat</li>
            </ul>
        </div>

        <div class="doc-content">
            <h3>Troubleshooting</h3>
            <ul>
                <li>Jika sistem lambat, coba refresh halaman</li>
                <li>Jika error, screenshot pesan error dan hubungi admin</li>
                <li>Pastikan koneksi internet stabil</li>
                <li>Clear cache browser jika mengalami masalah tampilan</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="doc-footer">
        <div class="help-section">
            <h3>Butuh Bantuan?</h3>
            <p>Jika ada yang kurang jelas, silakan:</p>
            <div class="help-links">
                <a href="{{ route('dosen.bantuan.index') }}" class="help-link">
                    ❓ Lihat FAQ
                </a>
                <a href="{{ route('dosen.bantuan.kontak') }}" class="help-link">
                    📞 Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
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

    .documentation-container {
        max-width: 1000px;
    }

    .doc-navigation {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
    }

    .doc-navigation h3 {
        font-size: 1.1rem;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .doc-navigation ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .doc-navigation li {
        margin-bottom: 0.5rem;
    }

    .doc-navigation a {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.2s;
    }

    .doc-navigation a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .doc-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .doc-section h2 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .doc-content {
        margin-bottom: 2rem;
    }

    .doc-content:last-child {
        margin-bottom: 0;
    }

    .doc-content h3 {
        font-size: 1.15rem;
        color: #374151;
        margin-bottom: 1rem;
    }

    .doc-content ol,
    .doc-content ul {
        line-height: 1.8;
        color: #4b5563;
    }

    .doc-content ol li,
    .doc-content ul li {
        margin-bottom: 0.5rem;
    }

    .doc-content p {
        color: #4b5563;
        line-height: 1.7;
        margin-bottom: 1rem;
    }

    .doc-note,
    .doc-warning,
    .doc-info {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .doc-note {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
    }

    .doc-note strong {
        color: #1e40af;
    }

    .doc-warning {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
    }

    .doc-warning strong {
        color: #92400e;
    }

    .doc-info {
        background: #f0fdf4;
        border-left: 4px solid #10b981;
    }

    .doc-info strong {
        color: #065f46;
    }

    .doc-info ul {
        margin-bottom: 0;
    }

    .doc-footer {
        margin-top: 3rem;
    }

    .help-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .help-section h3 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .help-section p {
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }

    .help-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .help-link {
        background: white;
        color: #667eea;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .help-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #764ba2;
    }

    @media (max-width: 768px) {
        .doc-navigation {
            position: static;
        }

        .doc-section {
            padding: 1.25rem;
        }

        .doc-section h2 {
            font-size: 1.25rem;
        }

        .help-section {
            padding: 1.5rem;
        }

        .help-links {
            flex-direction: column;
        }

        .help-link {
            width: 100%;
        }
    }
</style>
@endpush
@endsection
