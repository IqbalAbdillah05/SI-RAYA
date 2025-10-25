const fs = require('fs');
const path = require('path');

console.log('🔄 Mengkonversi SVG ke PNG...\n');

// Baca file SVG
const svgPath = path.join(__dirname, 'public', 'images', 'arabic-header.svg');
const pngPath = path.join(__dirname, 'public', 'images', 'arabic-header.png');

if (!fs.existsSync(svgPath)) {
    console.error('❌ File SVG tidak ditemukan:', svgPath);
    process.exit(1);
}

console.log('📂 File SVG ditemukan:', svgPath);
console.log('');
console.log('⚠️  Node.js tidak bisa langsung convert SVG ke PNG tanpa library tambahan.');
console.log('');
console.log('📋 SOLUSI TERCEPAT:');
console.log('');
console.log('OPSI 1 - Manual Screenshot (RECOMMENDED):');
console.log('  1. Buka file di browser: file:///' + svgPath.replace(/\\/g, '/'));
console.log('  2. Gunakan Snipping Tool (Win + Shift + S)');
console.log('  3. Screenshot SVG tersebut');
console.log('  4. Save sebagai: ' + pngPath);
console.log('');
console.log('OPSI 2 - Gunakan Online Converter:');
console.log('  1. Buka: https://cloudconvert.com/svg-to-png');
console.log('  2. Upload file: ' + svgPath);
console.log('  3. Convert ke PNG');
console.log('  4. Download dan save ke: ' + pngPath);
console.log('');
console.log('OPSI 3 - Install Puppeteer (otomatis):');
console.log('  Jalankan: npm install puppeteer');
console.log('  Lalu jalankan: node convert-svg-puppeteer.js');
console.log('');

// Buka browser dengan SVG
const { exec } = require('child_process');
const svgUrl = 'file:///' + svgPath.replace(/\\/g, '/');
console.log('🌐 Membuka SVG di browser default...\n');
exec(`start ${svgUrl}`, (error) => {
    if (error) {
        console.log('⚠️  Tidak bisa buka browser otomatis.');
        console.log('   Buka manual: ' + svgUrl);
    } else {
        console.log('✅ Browser terbuka! Silakan screenshot SVG dan save sebagai PNG.');
    }
});
