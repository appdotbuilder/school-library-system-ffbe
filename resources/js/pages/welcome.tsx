import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    return (
        <>
            <Head title="Library Management System" />
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
                {/* Header */}
                <header className="px-6 lg:px-8">
                    <nav className="flex items-center justify-between py-6">
                        <div className="flex items-center gap-3">
                            <div className="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-xl">📚</span>
                            </div>
                            <h1 className="text-xl font-bold text-gray-900">LibraryMS</h1>
                        </div>
                        <div className="flex items-center gap-4">
                            <Link
                                href="/login"
                                className="text-gray-600 hover:text-gray-900 font-medium"
                            >
                                Login
                            </Link>
                            <Link href="/register">
                                <Button>Get Started</Button>
                            </Link>
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="px-6 lg:px-8">
                    <div className="mx-auto max-w-3xl py-12 sm:py-20 lg:py-28">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                                📚 <span className="text-blue-600">Sistem Manajemen</span> Perpustakaan Sekolah
                            </h1>
                            <p className="mt-6 text-lg leading-8 text-gray-600 max-w-2xl mx-auto">
                                Platform terpadu untuk mengelola perpustakaan sekolah dengan sistem 
                                role-based yang mendukung 3 peran utama: Admin, Petugas Perpustakaan, 
                                dan Kepala Sekolah.
                            </p>
                            <div className="mt-10 flex items-center justify-center gap-x-6">
                                <Link href="/dashboard">
                                    <Button size="lg" className="px-8">
                                        🚀 Mulai Sekarang
                                    </Button>
                                </Link>
                                <Button variant="outline" size="lg" className="px-8">
                                    📖 Panduan
                                </Button>
                            </div>
                        </div>
                    </div>

                    {/* Features Section */}
                    <div className="mx-auto max-w-7xl px-6 lg:px-8 py-12">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                ✨ Fitur Unggulan
                            </h2>
                            <p className="text-gray-600 max-w-2xl mx-auto">
                                Solusi lengkap untuk digitalisasi perpustakaan sekolah modern
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {/* Feature 1 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">👥</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Manajemen Multi-Role
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Sistem berbasis peran dengan akses khusus untuk Admin, 
                                    Petugas Perpustakaan, dan Kepala Sekolah.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Admin: Akses penuh sistem</li>
                                    <li>• Petugas: Kelola transaksi</li>
                                    <li>• Kepala Sekolah: Lihat laporan</li>
                                </ul>
                            </div>

                            {/* Feature 2 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">📖</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Manajemen Buku Digital
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Kelola koleksi buku dengan barcode otomatis, 
                                    ekspor/impor data, dan pencarian canggih.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Generate barcode otomatis</li>
                                    <li>• Upload sampul buku</li>
                                    <li>• Filter dan pencarian</li>
                                </ul>
                            </div>

                            {/* Feature 3 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">🏫</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Manajemen Anggota
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Kelola data siswa dan guru dengan kartu anggota 
                                    digital dan barcode scanning.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Kartu anggota digital</li>
                                    <li>• Data siswa per kelas/jurusan</li>
                                    <li>• Status keanggotaan</li>
                                </ul>
                            </div>

                            {/* Feature 4 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">🔄</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Transaksi Barcode
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Proses peminjaman dan pengembalian cepat 
                                    menggunakan barcode scanner.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Scan kartu anggota</li>
                                    <li>• Scan barcode buku</li>
                                    <li>• Otomatis hitung denda</li>
                                </ul>
                            </div>

                            {/* Feature 5 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">📊</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Laporan & Statistik
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Dashboard analitik dengan laporan lengkap 
                                    untuk kepala sekolah dan administrator.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Statistik koleksi buku</li>
                                    <li>• Laporan keterlambatan</li>
                                    <li>• Riwayat transaksi</li>
                                </ul>
                            </div>

                            {/* Feature 6 */}
                            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">⚙️</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                    Pengaturan Fleksibel
                                </h3>
                                <p className="text-gray-600 mb-4">
                                    Konfigurasi sistem sesuai kebutuhan sekolah 
                                    dengan logo dan identitas sendiri.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Logo sekolah kustom</li>
                                    <li>• Atur masa peminjaman</li>
                                    <li>• Konfigurasi denda</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {/* Stats Section */}
                    <div className="mx-auto max-w-7xl px-6 lg:px-8 py-16 bg-white rounded-3xl my-16">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                📈 Mengapa Memilih LibraryMS?
                            </h2>
                        </div>
                        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div className="text-center">
                                <div className="text-4xl font-bold text-blue-600 mb-2">100%</div>
                                <div className="text-gray-600">Digital & Paperless</div>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl font-bold text-green-600 mb-2">24/7</div>
                                <div className="text-gray-600">Akses Sistem</div>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl font-bold text-purple-600 mb-2">3</div>
                                <div className="text-gray-600">Level Pengguna</div>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl font-bold text-orange-600 mb-2">∞</div>
                                <div className="text-gray-600">Kapasitas Data</div>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="mx-auto max-w-3xl py-16 text-center">
                        <h2 className="text-3xl font-bold text-gray-900 mb-6">
                            🚀 Siap Modernisasi Perpustakaan Sekolah Anda?
                        </h2>
                        <p className="text-lg text-gray-600 mb-8">
                            Bergabunglah dengan sekolah-sekolah yang sudah menggunakan 
                            LibraryMS untuk mengelola perpustakaan mereka secara digital.
                        </p>
                        <div className="flex items-center justify-center gap-4">
                            <Link href="/dashboard">
                                <Button size="lg" className="px-8">
                                    🎯 Coba Dashboard
                                </Button>
                            </Link>
                            <Link href="/register">
                                <Button variant="outline" size="lg" className="px-8">
                                    📝 Daftar Gratis
                                </Button>
                            </Link>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="bg-gray-900 text-white mt-20">
                    <div className="max-w-7xl mx-auto px-6 lg:px-8 py-12">
                        <div className="text-center">
                            <div className="flex items-center justify-center gap-3 mb-4">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold">📚</span>
                                </div>
                                <span className="text-xl font-bold">LibraryMS</span>
                            </div>
                            <p className="text-gray-400">
                                Sistem Manajemen Perpustakaan Sekolah Modern
                            </p>
                            <div className="mt-8 pt-8 border-t border-gray-800 text-sm text-gray-500">
                                © 2024 LibraryMS. Semua hak dilindungi.
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}