@extends('layouts.dosen')

@section('title', 'Kontak & Dukungan')

@section('content')
<div class="page-header">
    <h1>📞 Kontak & Dukungan</h1>
    <p>Hubungi kami untuk bantuan dan dukungan teknis</p>
</div>

<div class="contact-container">
    <!-- Quick Contact Cards -->
    <div class="contact-grid">
        <!-- IT Support -->
        <div class="contact-card">
            <div class="contact-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 3.5C9 2.67157 9.67157 2 10.5 2H13.5C14.3284 2 15 2.67157 15 3.5V5.5C15 6.32843 14.3284 7 13.5 7H10.5C9.67157 7 9 6.32843 9 5.5V3.5Z" stroke="#667eea" stroke-width="2"/>
                    <path d="M9 7H6C4.89543 7 4 7.89543 4 9V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V9C20 7.89543 19.1046 7 18 7H15" stroke="#667eea" stroke-width="2"/>
                    <path d="M12 11V17M9 14H15" stroke="#667eea" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h3>IT Support</h3>
            <p>Bantuan teknis dan masalah sistem</p>
            <div class="contact-details">
                <div class="contact-item">
                    <span class="contact-label">Telepon:</span>
                    <a href="tel:+6281234567890">+62 812-3456-7890</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Email:</span>
                    <a href="mailto:it.support@stairaya.ac.id">it.support@stairaya.ac.id</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">WhatsApp:</span>
                    <a href="https://wa.me/6281234567890" target="_blank">Chat WhatsApp</a>
                </div>
            </div>
        </div>

        <!-- Bagian Akademik -->
        <div class="contact-card">
            <div class="contact-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 14L21 9L12 4L3 9L12 14Z" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 14L21 9V16C21 16.93 20.5 17.395 18 18.5C15.5 19.605 13.5 20 12 20C10.5 20 8.5 19.605 6 18.5C3.5 17.395 3 16.93 3 16V9L12 14Z" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Bagian Akademik</h3>
            <p>Informasi akademik dan administrasi</p>
            <div class="contact-details">
                <div class="contact-item">
                    <span class="contact-label">Telepon:</span>
                    <a href="tel:+6281234567891">+62 812-3456-7891</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Email:</span>
                    <a href="mailto:akademik@stairaya.ac.id">akademik@stairaya.ac.id</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Jam Kerja:</span>
                    <span>Senin - Jumat, 08:00 - 16:00 WIB</span>
                </div>
            </div>
        </div>

        <!-- Admin Sistem -->
        <div class="contact-card">
            <div class="contact-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="8" r="4" stroke="#f59e0b" stroke-width="2"/>
                    <path d="M5 20C5 16.134 8.13401 13 12 13C15.866 13 19 16.134 19 20" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h3>Admin Sistem</h3>
            <p>Pengelolaan akun dan data dosen</p>
            <div class="contact-details">
                <div class="contact-item">
                    <span class="contact-label">Telepon:</span>
                    <a href="tel:+6281234567892">+62 812-3456-7892</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Email:</span>
                    <a href="mailto:admin@stairaya.ac.id">admin@stairaya.ac.id</a>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Lokasi:</span>
                    <span>Gedung A, Lantai 2, Ruang Admin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Quick Links -->
    <div class="faq-section">
        <h2>Pertanyaan Umum</h2>
        <div class="faq-grid">
            <div class="faq-card">
                <h4>🔐 Lupa Password</h4>
                <p>Hubungi Admin Sistem untuk reset password. Siapkan identitas diri untuk verifikasi.</p>
            </div>
            <div class="faq-card">
                <h4>📍 Masalah Lokasi</h4>
                <p>Pastikan GPS aktif dan browser memiliki izin akses lokasi. Hubungi IT Support jika masih bermasalah.</p>
            </div>
            <div class="faq-card">
                <h4>📊 Error Input Nilai</h4>
                <p>Screenshot pesan error dan kirim ke IT Support melalui WhatsApp atau email.</p>
            </div>
            <div class="faq-card">
                <h4>📅 Perubahan Jadwal</h4>
                <p>Hubungi Bagian Akademik untuk permintaan perubahan atau konfirmasi jadwal mengajar.</p>
            </div>
        </div>
    </div>

    <!-- Response Time -->
    <div class="response-info">
        <h2>⏰ Waktu Respons</h2>
        <div class="response-grid">
            <div class="response-item">
                <div class="response-icon urgent">🔴</div>
                <div class="response-content">
                    <h4>Urgent (Sistem Down)</h4>
                    <p>Respons dalam 1-2 jam</p>
                </div>
            </div>
            <div class="response-item">
                <div class="response-icon high">🟡</div>
                <div class="response-content">
                    <h4>High Priority</h4>
                    <p>Respons dalam 4-6 jam</p>
                </div>
            </div>
            <div class="response-item">
                <div class="response-icon normal">🟢</div>
                <div class="response-content">
                    <h4>Normal</h4>
                    <p>Respons dalam 1-2 hari kerja</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visit Us -->
    <div class="visit-section">
        <h2>📍 Kunjungi Kami</h2>
        <div class="visit-content">
            <div class="address-box">
                <h3>STAI Raden Abdullah Yaqin</h3>
                <p>Jl. KH. Abdullah Yaqien No.1, Krajan Timur, Mlokorejo, Kec. Puger, Kabupaten Jember, Jawa Timur 68164</p>
                
                <div class="office-hours">
                    <h4>Jam Operasional:</h4>
                    <p>Senin - Jumat: 08:00 - 16:00 WIB<br>
                    Sabtu: 08:00 - 12:00 WIB<br>
                    Minggu & Libur: Tutup</p>
                </div>
            </div>
            
            <a href="https://maps.google.com/?q=STAI+Raden+Abdullah+Yaqin+Mlokorejo+Jember" target="_blank" class="map-placeholder">
                <div class="map-icon">🗺️</div>
                <p>Peta Lokasi Kampus</p>
                <small>Klik untuk membuka Google Maps</small>
            </a>
        </div>
    </div>

    <!-- Additional Help -->
    <div class="additional-help">
        <h3>Masih Butuh Bantuan?</h3>
        <p>Lihat panduan lengkap dan FAQ untuk solusi cepat</p>
        <div class="help-buttons">
            <a href="{{ route('dosen.bantuan.index') }}" class="help-btn primary">
                ❓ Lihat FAQ
            </a>
            <a href="{{ route('dosen.bantuan.dokumentasi') }}" class="help-btn secondary">
                📚 Baca Dokumentasi
            </a>
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

    .contact-container {
        max-width: 1100px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .contact-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .contact-icon {
        margin-bottom: 1rem;
    }

    .contact-card h3 {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .contact-card > p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .contact-details {
        text-align: left;
    }

    .contact-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-label {
        font-size: 0.85rem;
        color: #9ca3af;
        font-weight: 500;
    }

    .contact-item a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-item a:hover {
        text-decoration: underline;
    }

    .contact-item span:not(.contact-label) {
        color: #4b5563;
    }

    .faq-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .faq-section h2 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .faq-card {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1.25rem;
        border-left: 4px solid #3b82f6;
    }

    .faq-card h4 {
        font-size: 1rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .faq-card p {
        font-size: 0.9rem;
        color: #6b7280;
        line-height: 1.5;
        margin: 0;
    }

    .response-info {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .response-info h2 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .response-grid {
        display: grid;
        gap: 1rem;
    }

    .response-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
    }

    .response-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: white;
    }

    .response-content h4 {
        font-size: 1rem;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .response-content p {
        font-size: 0.9rem;
        color: #6b7280;
        margin: 0;
    }

    .visit-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .visit-section h2 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .visit-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .address-box h3 {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .address-box p {
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .office-hours h4 {
        font-size: 1rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .office-hours p {
        color: #6b7280;
        line-height: 1.8;
        margin: 0;
    }

    .map-placeholder {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .map-placeholder:hover {
        transform: scale(1.02);
    }

    .map-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .map-placeholder p {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: white;
    }

    .map-placeholder small {
        opacity: 0.9;
        color: white;
    }

    .additional-help {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .additional-help h3 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .additional-help p {
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }

    .help-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .help-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .help-btn.primary {
        background: white;
        color: #667eea;
    }

    .help-btn.secondary {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
    }

    .help-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .faq-grid {
            grid-template-columns: 1fr;
        }

        .visit-content {
            grid-template-columns: 1fr;
        }

        .help-buttons {
            flex-direction: column;
        }

        .help-btn {
            width: 100%;
        }
    }
</style>
@endpush
@endsection
