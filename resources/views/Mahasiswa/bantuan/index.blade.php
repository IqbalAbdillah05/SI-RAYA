@extends('layouts.mahasiswa')

@section('title', 'Bantuan & FAQ')

@section('content')
<div class="bantuan-mahasiswa">
    <!-- Welcome Header -->
    <div class="page-header-banner">
        <div class="header-content">
            <div class="header-text">
                <h1>❓ Bantuan & FAQ</h1>
                <p>Panduan penggunaan sistem dan pertanyaan yang sering diajukan</p>
            </div>
            <div class="header-illustration">
                <div class="illustration-circle">
                    <i class="fas fa-question-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="faq-container">
        <!-- KRS (Kartu Rencana Studi) -->
        <div class="faq-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h2>📝 KRS (Kartu Rencana Studi)</h2>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana cara mengisi KRS?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Berikut langkah-langkah mengisi KRS:
                    <ol>
                        <li>Buka menu <strong>"KRS"</strong> di sidebar</li>
                        <li>Klik tombol <strong>"Isi KRS Baru"</strong></li>
                        <li>Pilih mata kuliah yang ingin diambil</li>
                        <li>Pastikan total SKS tidak melebihi batas maksimal</li>
                        <li>Klik <strong>"Simpan KRS"</strong></li>
                        <li>Tunggu persetujuan dari bagian admin akademik</li>
                    </ol>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Kapan batas waktu pengisian KRS?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Batas waktu pengisian KRS biasanya 2 minggu di awal semester. Pastikan Anda mengisi KRS sebelum batas waktu yang ditentukan. Informasi detail akan diumumkan oleh bagian akademik.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Apakah KRS yang sudah diisi bisa diubah?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Ya, KRS dapat diubah selama:
                    <ul>
                        <li>Masih dalam periode pengisian KRS</li>
                        <li>KRS belum disetujui oleh bagian admin akademik</li>
                        <li>Atau dalam periode revisi KRS (jika ada)</li>
                    </ul>
                    Jika KRS sudah disetujui, Anda perlu menghubungi admin akademik untuk melakukan perubahan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Berapa maksimal SKS yang boleh diambil?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Jumlah maksimal SKS yang dapat diambil tergantung pada IPS semester sebelumnya:
                    <ul>
                        <li><strong>IPS ≥ 3.00:</strong> Maksimal 24 SKS</li>
                        <li><strong>IPS 2.50 - 2.99:</strong> Maksimal 21 SKS</li>
                        <li><strong>IPS 2.00 - 2.49:</strong> Maksimal 18 SKS</li>
                        <li><strong>IPS < 2.00:</strong> Maksimal 15 SKS</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- KHS (Kartu Hasil Studi) -->
        <div class="faq-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h2>📊 KHS (Kartu Hasil Studi)</h2>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana cara melihat KHS?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Cara melihat KHS:
                    <ol>
                        <li>Buka menu <strong>"KHS"</strong> di sidebar</li>
                        <li>Pilih semester yang ingin dilihat</li>
                        <li>KHS akan ditampilkan lengkap dengan nilai dan IPK</li>
                        <li>Anda juga dapat mendownload KHS dalam format PDF</li>
                    </ol>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Kapan KHS dapat dilihat?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> KHS dapat dilihat setelah:
                    <ul>
                        <li>Dosen menginput semua nilai mata kuliah</li>
                        <li>Nilai sudah diverifikasi oleh bagian akademik</li>
                        <li>Biasanya tersedia 2-3 minggu setelah ujian akhir semester</li>
                    </ul>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana sistem penilaian di STAI RAYA?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Sistem penilaian menggunakan konversi berikut:
                    <ul>
                        <li><strong>A+ (4.00):</strong> 96-100</li>
                        <li><strong>A (3.50):</strong> 86-95</li>
                        <li><strong>A- (3.25):</strong> 81-85</li>
                        <li><strong>B+ (3.00):</strong> 76-80</li>
                        <li><strong>B (2.75):</strong> 71-75</li>
                        <li><strong>B- (2.50):</strong> 66-70</li>
                        <li><strong>C+ (2.25):</strong> 61-65</li>
                        <li><strong>C (2.00):</strong> 56-60</li>
                        <li><strong>D (1.00):</strong> 41-55</li>
                        <li><strong>E (0.00):</strong> 0-40</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Jadwal Kuliah -->
        <div class="faq-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h2>📅 Jadwal Kuliah</h2>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana cara melihat jadwal kuliah?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Anda dapat melihat jadwal kuliah dengan cara:
                    <ol>
                        <li>Buka menu <strong>"Jadwal"</strong> di sidebar</li>
                        <li>Jadwal akan ditampilkan per hari atau per minggu</li>
                        <li>Atau lihat di Dashboard pada bagian "Jadwal Kuliah Hari Ini"</li>
                    </ol>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana jika ada perubahan jadwal?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Perubahan jadwal akan:
                    <ul>
                        <li>Otomatis diperbarui di sistem</li>
                        <li>Diumumkan melalui grup kelas atau pengumuman kampus</li>
                        <li>Pastikan selalu cek jadwal sebelum kuliah</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Presensi -->
        <div class="faq-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h2>✅ Presensi Kehadiran</h2>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana cara presensi kuliah?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Presensi mahasiswa dilakukan oleh <strong>dosen yang mengajar</strong>, bukan mahasiswa yang presensi sendiri. Dosen akan mencatat kehadiran setiap mahasiswa di setiap pertemuan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana cara melihat riwayat presensi saya?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Cara melihat riwayat presensi:
                    <ol>
                        <li>Buka menu <strong>"Presensi"</strong></li>
                        <li>Pilih mata kuliah yang ingin dilihat</li>
                        <li>Riwayat presensi akan ditampilkan lengkap dengan status (Hadir/Izin/Sakit/Alpha)</li>
                        <li>Anda dapat melihat persentase kehadiran per mata kuliah</li>
                    </ol>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Berapa minimal kehadiran untuk bisa mengikuti ujian?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Minimal kehadiran untuk dapat mengikuti ujian adalah <strong>75%</strong> dari total pertemuan. Jika kehadiran kurang dari 75%, Anda tidak diperkenankan mengikuti ujian dan akan mendapat nilai E.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Bagaimana jika saya tidak bisa hadir karena sakit?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Jika tidak bisa hadir karena sakit:
                    <ul>
                        <li>Segera beritahu dosen pengampu mata kuliah</li>
                        <li>Siapkan surat keterangan sakit dari dokter</li>
                        <li>Serahkan surat ke dosen atau bagian akademik</li>
                        <li>Status presensi akan diubah dari Alpha menjadi Sakit</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Masalah Teknis -->
        <div class="faq-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h2>⚙️ Masalah Teknis</h2>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Tidak bisa login, apa yang harus dilakukan?</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Jika tidak bisa login, coba langkah berikut:
                    <ul>
                        <li>Pastikan username (NIM) dan password benar</li>
                        <li>Cek capslock keyboard Anda</li>
                        <li>Clear cache dan cookies browser</li>
                        <li>Coba browser lain (Chrome, Firefox, Edge)</li>
                        <li>Jika masih gagal, hubungi admin untuk reset password</li>
                    </ul>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Data tidak tersimpan atau error saat submit</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Solusi yang dapat dicoba:
                    <ul>
                        <li>Refresh halaman dan coba lagi</li>
                        <li>Pastikan koneksi internet stabil</li>
                        <li>Clear cache browser</li>
                        <li>Screenshot pesan error dan kirim ke admin IT</li>
                        <li>Coba akses di waktu yang berbeda (mungkin server sedang maintenance)</li>
                    </ul>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-chevron-right"></i>
                    <strong>Q: Halaman tidak loading atau lambat</strong>
                </div>
                <div class="faq-answer">
                    <strong>A:</strong> Jika halaman lambat atau tidak loading:
                    <ul>
                        <li>Cek koneksi internet Anda</li>
                        <li>Tutup tab browser yang tidak digunakan</li>
                        <li>Clear cache dan cookies</li>
                        <li>Restart browser</li>
                        <li>Coba akses dari jaringan internet lain</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Help Section -->
        <div class="faq-footer">
            <div class="help-box">
                <div class="help-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Masih Butuh Bantuan?</h3>
                <p>Jika pertanyaan Anda tidak terjawab di sini, silakan hubungi tim support kami</p>
                <div class="contact-links">
                    <a href="{{ route('mahasiswa.bantuan.kontak') }}" class="btn-contact primary">
                        <i class="fas fa-phone-alt"></i> Hubungi Admin
                    </a>
                    <a href="{{ route('mahasiswa.bantuan.dokumentasi') }}" class="btn-contact secondary">
                        <i class="fas fa-book-open"></i> Lihat Dokumentasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bantuan-mahasiswa {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Page Header Banner */
    .page-header-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .page-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .header-text h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .header-text p {
        font-size: 1rem;
        color: var(--accent);
        font-weight: 600;
    }

    .header-illustration {
        display: flex;
        align-items: center;
    }

    .illustration-circle {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--accent);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* FAQ Container */
    .faq-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* FAQ Category */
    .faq-category {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .faq-category:hover {
        box-shadow: var(--shadow-lg);
    }

    .category-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }

    .category-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .category-header h2 {
        font-size: 1.4rem;
        color: var(--text-primary);
        margin: 0;
    }

    /* FAQ Item */
    .faq-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .faq-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .faq-question {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .faq-question:hover {
        color: var(--primary);
    }

    .faq-question i {
        color: var(--primary);
        margin-top: 0.25rem;
        transition: transform 0.2s ease;
    }

    .faq-question:hover i {
        transform: translateX(4px);
    }

    .faq-question strong {
        color: var(--text-primary);
        font-size: 1rem;
        line-height: 1.5;
    }

    .faq-answer {
        color: var(--text-secondary);
        line-height: 1.7;
        padding-left: 1.75rem;
    }

    .faq-answer strong {
        color: var(--primary);
        font-weight: 600;
    }

    .faq-answer ol,
    .faq-answer ul {
        margin-top: 0.75rem;
        margin-bottom: 0.5rem;
        padding-left: 1.5rem;
    }

    .faq-answer li {
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
    }

    .faq-answer em {
        display: block;
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: var(--accent-light);
        border-left: 3px solid var(--accent);
        border-radius: 4px;
        font-style: normal;
        font-size: 0.9rem;
        color: var(--accent);
    }

    /* Footer Help Box */
    .faq-footer {
        margin-top: 2rem;
    }

    .help-box {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .help-box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .help-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }

    .help-box h3 {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }

    .help-box p {
        margin-bottom: 2rem;
        opacity: 0.95;
        font-size: 1.05rem;
        position: relative;
        z-index: 1;
    }

    .contact-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .btn-contact {
        padding: 0.875rem 1.75rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }

    .btn-contact.primary {
        background: white;
        color: var(--primary);
    }

    .btn-contact.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        background: var(--accent);
        color: white;
    }

    .btn-contact.secondary {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 2px solid white;
        backdrop-filter: blur(10px);
    }

    .btn-contact.secondary:hover {
        transform: translateY(-3px);
        background: white;
        color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-banner {
            padding: 1.5rem;
        }

        .header-text h1 {
            font-size: 1.5rem;
        }

        .illustration-circle {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }

        .faq-category {
            padding: 1.25rem;
        }

        .category-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .category-header h2 {
            font-size: 1.2rem;
        }

        .faq-answer {
            padding-left: 0;
        }

        .contact-links {
            flex-direction: column;
        }

        .btn-contact {
            width: 100%;
            justify-content: center;
        }

        .help-box {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush
@endsection
