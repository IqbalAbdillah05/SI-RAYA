@extends('layouts.mahasiswa')

@section('title', 'Kontak & Dukungan')

@section('content')
<div class="kontak-mahasiswa">
    <!-- Welcome Header -->
    <div class="page-header-banner">
        <div class="header-content">
            <div class="header-text">
                <h1>📞 Kontak & Dukungan</h1>
                <p>Hubungi kami untuk bantuan dan dukungan teknis</p>
            </div>
            <div class="header-illustration">
                <div class="illustration-circle">
                    <i class="fas fa-headset"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-container">
        <!-- Quick Contact Cards -->
        <div class="contact-grid">
            <!-- IT Support -->
            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>IT Support</h3>
                <p>Bantuan teknis dan masalah sistem</p>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <span class="contact-label">Telepon</span>
                            <a href="tel:+628123456789">+62 812-3456-789</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span class="contact-label">Email</span>
                            <a href="mailto:it@stairaya.ac.id">it@stairaya.ac.id</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <span class="contact-label">WhatsApp</span>
                            <a href="https://wa.me/628123456789" target="_blank">Chat WhatsApp</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Akademik -->
            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Bagian Akademik</h3>
                <p>Informasi KRS, KHS, dan administrasi</p>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <span class="contact-label">Telepon</span>
                            <a href="tel:+628123456790">+62 812-3456-790</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span class="contact-label">Email</span>
                            <a href="mailto:akademik@stairaya.ac.id">akademik@stairaya.ac.id</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <span class="contact-label">Jam Kerja</span>
                            <span>Senin - Jumat, 08:00 - 16:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kemahasiswaan -->
            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Kemahasiswaan</h3>
                <p>Kegiatan mahasiswa dan konseling</p>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <span class="contact-label">Telepon</span>
                            <a href="tel:+628123456791">+62 812-3456-791</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span class="contact-label">Email</span>
                            <a href="mailto:kemahasiswaan@stairaya.ac.id">kemahasiswaan@stairaya.ac.id</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-instagram"></i>
                        <div>
                            <span class="contact-label">Instagram</span>
                            <a href="https://instagram.com/stairaya" target="_blank">@stairaya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Quick Links -->
        <div class="faq-section-card">
            <h2><i class="fas fa-question-circle"></i> Pertanyaan Umum</h2>
            <div class="faq-grid">
                <div class="faq-card">
                    <div class="faq-icon">🔐</div>
                    <h4>Lupa Password</h4>
                    <p>Hubungi IT Support untuk reset password. Siapkan NIM dan identitas diri untuk verifikasi.</p>
                </div>
                <div class="faq-card">
                    <div class="faq-icon">📝</div>
                    <h4>Masalah KRS</h4>
                    <p>Untuk kendala pengisian KRS, hubungi Bagian Akademik atau dosen wali Anda.</p>
                </div>
                <div class="faq-card">
                    <div class="faq-icon">📊</div>
                    <h4>Cek Nilai KHS</h4>
                    <p>KHS tersedia setelah nilai diinput dosen. Hubungi Akademik jika ada ketidaksesuaian nilai.</p>
                </div>
                <div class="faq-card">
                    <div class="faq-icon">🎓</div>
                    <h4>Beasiswa</h4>
                    <p>Informasi beasiswa dan bantuan keuangan dapat ditanyakan ke bagian Kemahasiswaan.</p>
                </div>
                <div class="faq-card">
                    <div class="faq-icon">📅</div>
                    <h4>Perubahan Jadwal</h4>
                    <p>Perubahan jadwal akan diumumkan melalui sistem dan grup kelas. Selalu cek jadwal sebelum kuliah.</p>
                </div>
                <div class="faq-card">
                    <div class="faq-icon">💳</div>
                    <h4>Pembayaran UKT</h4>
                    <p>Informasi pembayaran dan tagihan dapat ditanyakan ke bagian Keuangan kampus.</p>
                </div>
            </div>
        </div>

        <!-- Response Time -->
        <div class="response-info-card">
            <h2><i class="fas fa-clock"></i> Waktu Respons</h2>
            <div class="response-grid">
                <div class="response-item">
                    <div class="response-icon urgent">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="response-content">
                        <h4>Urgent (Prioritas Tinggi)</h4>
                        <p>Maksimal 1 jam saat jam kerja</p>
                        <small>Error sistem, tidak bisa login, masalah teknis kritis</small>
                    </div>
                </div>
                <div class="response-item">
                    <div class="response-icon high">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="response-content">
                        <h4>Penting (Prioritas Sedang)</h4>
                        <p>Maksimal 4 jam saat jam kerja</p>
                        <small>Masalah KRS, update data, pertanyaan akademik</small>
                    </div>
                </div>
                <div class="response-item">
                    <div class="response-icon normal">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="response-content">
                        <h4>Normal (Prioritas Rendah)</h4>
                        <p>Maksimal 1 hari kerja</p>
                        <small>Informasi umum, pertanyaan biasa</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visit Us -->
        <div class="visit-section-card">
            <div class="visit-header">
                <h2><i class="fas fa-map-marker-alt"></i> Kunjungi Kami</h2>
            </div>
            <div class="visit-content">
                <div class="address-box">
                    <h3>STAI Raden Abdullah Yaqin</h3>
                    <p class="address">
                        <i class="fas fa-map-marker-alt"></i>
                        Jl. KH. Abdullah Yaqien No.1, Krajan Timur, Mlokorejo, Kec. Puger, Kabupaten Jember, Jawa Timur 68164
                    </p>
                    
                    <div class="office-hours">
                        <h4><i class="fas fa-clock"></i> Jam Layanan</h4>
                        <div class="hours-grid">
                            <div class="hours-item">
                                <strong>Senin - Kamis</strong>
                                <span>08:00 - 16:00 WIB</span>
                            </div>
                            <div class="hours-item">
                                <strong>Jumat</strong>
                                <span>08:00 - 15:30 WIB</span>
                            </div>
                            <div class="hours-item">
                                <strong>Sabtu</strong>
                                <span>08:00 - 13:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="https://maps.google.com/?q=STAI+Raden+Abdullah+Yaqin+Mlokorejo+Jember" target="_blank" class="map-card">
                    <div class="map-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h4>Lihat Peta Lokasi</h4>
                    <p>Klik untuk membuka Google Maps</p>
                    <span class="map-btn">Buka Maps <i class="fas fa-external-link-alt"></i></span>
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="additional-help-card">
            <div class="help-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3>Masih Butuh Bantuan?</h3>
            <p>Lihat panduan lengkap dan FAQ untuk solusi cepat masalah Anda</p>
            <div class="help-buttons">
                <a href="{{ route('mahasiswa.bantuan.index') }}" class="help-btn primary">
                    <i class="fas fa-book"></i> Lihat FAQ
                </a>
                <a href="{{ route('mahasiswa.bantuan.dokumentasi') }}" class="help-btn secondary">
                    <i class="fas fa-file-alt"></i> Baca Dokumentasi
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .kontak-mahasiswa {
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

    /* Contact Container */
    .contact-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Contact Grid */
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .contact-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        text-align: center;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .contact-icon-circle {
        width: 80px;
        height: 80px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.25rem;
        transition: all 0.3s ease;
    }

    .contact-card:hover .contact-icon-circle {
        transform: scale(1.1);
        background: var(--primary);
        color: white;
    }

    .contact-card h3 {
        font-size: 1.3rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .contact-card > p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.75rem;
    }

    .contact-details {
        text-align: left;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid var(--border);
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item i {
        width: 20px;
        color: var(--primary);
        font-size: 1.1rem;
        margin-top: 0.25rem;
    }

    .contact-item > div {
        flex: 1;
    }

    .contact-label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .contact-item a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .contact-item a:hover {
        text-decoration: underline;
        color: var(--hover);
    }

    .contact-item span:not(.contact-label) {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* FAQ Section Card */
    .faq-section-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }

    .faq-section-card h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .faq-section-card h2 i {
        color: var(--primary);
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .faq-card {
        background: var(--background);
        border-radius: 10px;
        padding: 1.5rem;
        border-left: 4px solid var(--primary);
        transition: all 0.3s ease;
    }

    .faq-card:hover {
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.15);
        transform: translateX(4px);
    }

    .faq-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .faq-card h4 {
        font-size: 1rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .faq-card p {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0;
    }

    /* Response Info Card */
    .response-info-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }

    .response-info-card h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .response-info-card h2 i {
        color: var(--primary);
    }

    .response-grid {
        display: grid;
        gap: 1.25rem;
    }

    .response-item {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1.25rem;
        background: var(--background);
        border-radius: 10px;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .response-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .response-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .response-icon.urgent {
        background: #fee2e2;
        color: #dc2626;
    }

    .response-icon.high {
        background: #fef3c7;
        color: #f59e0b;
    }

    .response-icon.normal {
        background: #dcfce7;
        color: #16a34a;
    }

    .response-content h4 {
        font-size: 1rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .response-content p {
        font-size: 0.95rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .response-content small {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Visit Section Card */
    .visit-section-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }

    .visit-header h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .visit-header h2 i {
        color: var(--primary);
    }

    .visit-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .address-box h3 {
        font-size: 1.3rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .address-box .address {
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.75rem;
    }

    .address-box .address i {
        color: var(--primary);
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    .office-hours h4 {
        font-size: 1rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
    }

    .office-hours h4 i {
        color: var(--primary);
    }

    .hours-grid {
        display: grid;
        gap: 0.75rem;
    }

    .hours-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--background);
        border-radius: 8px;
        border-left: 3px solid var(--primary);
    }

    .hours-item strong {
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .hours-item span {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .map-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: 12px;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .map-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    .map-card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 24px rgba(11, 102, 35, 0.3);
    }

    .map-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .map-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .map-card p {
        margin-bottom: 1.25rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .map-btn {
        background: white;
        color: var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    /* Additional Help Card */
    .additional-help-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .additional-help-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    .additional-help-card .help-icon {
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

    .additional-help-card h3 {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }

    .additional-help-card p {
        margin-bottom: 2rem;
        opacity: 0.95;
        font-size: 1.05rem;
        position: relative;
        z-index: 1;
    }

    .help-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .help-btn {
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

    .help-btn.primary {
        background: white;
        color: var(--primary);
    }

    .help-btn.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        background: var(--accent);
        color: white;
    }

    .help-btn.secondary {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 2px solid white;
        backdrop-filter: blur(10px);
    }

    .help-btn.secondary:hover {
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
            justify-content: center;
        }

        .additional-help-card {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush
@endsection
