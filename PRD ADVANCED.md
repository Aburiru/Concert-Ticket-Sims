Ini adalah modifikasi improvisasi dari [Pemesanan Tiket Konser](Pemesanan%20Tiket%20Konser.md) 
# PRD - Sistem Pemesanan Tiket Konser

## 1. Project Overview

### Nama Project

Concert Ticket Booking System

### Tujuan

Membangun aplikasi berbasis web yang memungkinkan pengguna melakukan pembelian tiket konser secara online dengan proses yang cepat, aman, dan mudah. Sistem terintegrasi dengan Midtrans sebagai payment gateway sehingga pembayaran dapat dilakukan secara otomatis dan tiket digital diterbitkan setelah transaksi berhasil.

---

# 2. Background

Proses pembelian tiket konser masih sering dilakukan secara manual atau menggunakan formulir sederhana sehingga berpotensi menyebabkan:

- Kesalahan pencatatan data pembeli
    
- Kesalahan jumlah tiket yang tersedia
    
- Proses pembayaran yang lambat
    
- Sulit melakukan validasi tiket
    
- Tidak adanya laporan penjualan secara real-time
    

Sistem ini dirancang untuk mengatasi permasalahan tersebut dengan menyediakan proses pemesanan tiket yang terintegrasi dari registrasi hingga penerbitan e-ticket.

---

# 3. Objectives

- Mempermudah pembelian tiket secara online.
    
- Mengintegrasikan pembayaran otomatis menggunakan Midtrans.
    
- Menghasilkan E-Ticket secara otomatis.
    
- Mengurangi kesalahan pencatatan data.
    
- Mempermudah panitia memonitor penjualan tiket.
    

---

# 4. Target User

### Pembeli

Pengguna yang ingin membeli tiket konser.

### Admin

Panitia atau penyelenggara konser yang mengelola tiket dan transaksi.

---

# 5. User Flow

Landing Page

↓

Isi Data Pembeli

↓

Memilih Jenis Tiket

↓

Review Pesanan

↓

Pembayaran Midtrans

↓

Pembayaran Berhasil

↓

Generate E-Ticket

↓

Download / Tampilkan QR Ticket

---

# 6. Functional Requirements

## Landing Page

### Tujuan

Menampilkan informasi konser dan mengarahkan pengguna melakukan pembelian.

### Komponen

- Banner konser
    
- Informasi lokasi
    
- Tanggal konser
    
- Jam konser
    
- Harga tiket
    
- Tombol "Pesan Tiket"
    

---

## Form Registrasi

Data yang harus diisi pengguna:

|Field|Keterangan|
|---|---|
|Ticket ID|Generate otomatis|
|Nama Lengkap|Wajib|
|Nomor Telepon|Wajib|
|Email|Wajib|
|Jumlah Tiket|Minimal 1|
|Jenis Tiket|Dipilih pengguna|

Validasi:

- Email harus valid
    
- Nomor telepon hanya angka
    
- Nama tidak boleh kosong
    
- Tiket tidak boleh melebihi stok
    

---

## Jenis Tiket

|Jenis|Harga|
|---|---|
|VIP|Rp500.000|
|Reguler Kiri|Rp150.000|
|Reguler Kanan|Rp150.000|
|Tengah|Rp200.000|
|Bawah Panggung|Rp350.000|

Masing-masing jenis tiket memiliki:

- Kuota
    
- Harga
    
- Status tersedia/habis
    

---

## Checkout

Menampilkan:

- Ringkasan pesanan
    
- Jenis tiket
    
- Jumlah tiket
    
- Total pembayaran
    
- Biaya admin (jika ada)
    
- Tombol Bayar
    

---

## Pembayaran

Menggunakan Midtrans Snap.

Status transaksi:

- Pending
    
- Success
    
- Failed
    
- Expired
    
- Cancelled
    

Webhook Midtrans akan memperbarui status pembayaran secara otomatis.

---

## E-Ticket

Setelah pembayaran berhasil:

Sistem akan:

- Membuat Ticket ID unik
    
- Menghasilkan QR Code
    
- Mengubah status tiket menjadi Active
    
- Mengirim e-ticket ke email pengguna (opsional)
    
- Menampilkan halaman tiket yang dapat diunduh
    

Informasi tiket:

- Ticket ID
    
- Nama pembeli
    
- Jenis tiket
    
- Tanggal konser
    
- Lokasi
    
- QR Code
    
- Status tiket
    

---

## Dashboard Admin

Admin dapat:

### Kelola Tiket

- Tambah jenis tiket
    
- Edit harga
    
- Atur kuota
    
- Tutup penjualan
    

### Kelola Transaksi

- Melihat seluruh transaksi
    
- Filter berdasarkan status
    
- Detail pembeli
    

### Kelola Pembeli

- Daftar pembeli
    
- Detail tiket
    
- Riwayat transaksi
    

### Dashboard Statistik

Menampilkan:

- Total tiket terjual
    
- Pendapatan
    
- Tiket tersisa
    
- Jumlah transaksi berhasil
    
- Jumlah transaksi pending
    
- Grafik penjualan
    

---

# 7. Non Functional Requirements

## Performance

- Loading halaman < 2 detik
    
- Respons API cepat
    
- Mendukung banyak pengguna secara bersamaan
    

## Security

- CSRF Protection
    
- SQL Injection Protection
    
- XSS Protection
    
- Validasi Server Side
    
- HTTPS
    

## Reliability

- Database backup
    
- Error logging
    
- Transaction rollback
    

---

# 8. Database (Draft)

## Users

- id
    
- name
    
- email
    
- password
    
- role
    

## Ticket Types

- id
    
- name
    
- price
    
- quota
    
- remaining_stock
    

## Orders

- id
    
- ticket_id
    
- user_name
    
- email
    
- phone
    
- ticket_type_id
    
- quantity
    
- total_price
    
- payment_status
    
- payment_method
    
- midtrans_order_id
    
- created_at
    

## Payments

- id
    
- order_id
    
- transaction_id
    
- payment_type
    
- gross_amount
    
- transaction_status
    
- fraud_status
    

---

# 9. API Integration

## Midtrans

Digunakan untuk:

- Membuat transaksi
    
- Menerima callback pembayaran
    
- Memperbarui status pembayaran
    
- Verifikasi transaksi
    

---

# 10. Future Features

Versi berikutnya dapat menambahkan:

- Login pengguna
    
- Riwayat pembelian
    
- Download ulang e-ticket
    
- Scan QR Code saat masuk venue
    
- Check-in Gate System
    
- Kursi bernomor (Seat Selection)
    
- Voucher dan Promo
    
- Referral Code
    
- Email & WhatsApp Notification
    
- Refund Management
    
- Multi Event Management
    
- Export laporan Excel/PDF
    

---

# 11. Technology Stack

Backend

- Laravel 12
    
- PHP 8.3
    

Frontend

- Blade
    
- Tailwind CSS
    
- Alpine.js
    

Database

- MySQL
    

Payment

- Midtrans Snap API
    

Storage

- Laravel Storage
    

QR Code

- Simple QrCode
    

Deployment

- VPS / Shared Hosting
    

---

# 12. Success Metrics

Proyek dianggap berhasil apabila:

- Pengguna dapat membeli tiket tanpa kendala.
    
- Pembayaran berhasil diproses melalui Midtrans.
    
- E-Ticket diterbitkan secara otomatis setelah pembayaran sukses.
    
- Admin dapat memantau seluruh transaksi secara real-time.
    
- Sistem mampu menangani proses pembelian dengan aman dan stabil.

# 13. UI / UX Design Guidelines

## Design Philosophy

Aplikasi menggunakan pendekatan **Neobrutalism UI** sebagai identitas visual utama. Seluruh halaman harus mempertahankan karakter desain yang berani, kontras tinggi, mudah dikenali, dan memiliki kesan modern tanpa mengorbankan keterbacaan.

Prinsip utama:

- Bold dan tegas
    
- Flat design tanpa glassmorphism
    
- Warna kontras tinggi
    
- Shadow tebal sebagai elemen visual utama
    
- Border hitam konsisten
    
- Sudut membulat (Rounded XL)
    
- Interaksi sederhana dengan feedback yang jelas
    

---

## Visual Identity

### Primary Style

Neobrutalism

### Design Goal

Memberikan pengalaman membeli tiket yang terasa:

- Fun
    
- Modern
    
- Friendly
    
- Cepat dipahami
    
- Berbeda dari aplikasi tiket pada umumnya
    

---

## Color Palette

### Primary

- Yellow #FFD43B
    

### Secondary

- Cyan #4CC9F0
    

### Accent

- Pink #FF4D8D
    

### Success

- Green #6BCB77
    

### Warning

- Orange #FF922B
    

### Danger

- Red #FF6B6B
    

### Background

- White #FFFFFF
    

### Surface

- Light Gray #F8F9FA
    

### Text

- Black #111111
    

### Border

- Black #000000
    

---

## Typography

Heading

- Font: Poppins
    
- Bold (700–800)
    

Body

- Font: Inter
    
- Medium (400–500)
    

Semua heading menggunakan ukuran besar dengan kontras tinggi agar menjadi fokus utama halaman.

---

## Border

Seluruh komponen menggunakan:

- Border 3–4px
    
- Warna hitam
    
- Konsisten di seluruh aplikasi
    

Tidak menggunakan border tipis berwarna abu-abu.

---

## Shadow

Seluruh komponen utama menggunakan shadow khas Neobrutalism.

Contoh:

- Offset 6px
    
- Blur 0px
    
- Color Black
    

Shadow hanya digunakan untuk memberi efek kedalaman, bukan efek lembut seperti Material Design.

---

## Corner Radius

Komponen menggunakan rounded yang konsisten.

Contoh:

- Button: 16px
    
- Card: 20px
    
- Modal: 24px
    
- Input: 16px
    

---

## Button Style

Button memiliki karakter:

- Warna solid
    
- Border hitam tebal
    
- Shadow hitam
    
- Hover: sedikit bergeser ke arah shadow
    
- Active: shadow menghilang sehingga terlihat seperti ditekan
    

Button tidak menggunakan efek blur, transparansi, ataupun gradient.

---

## Card Design

Seluruh card menggunakan:

- Background solid
    
- Border hitam
    
- Shadow hitam
    
- Padding besar
    
- Judul besar
    
- Ikon sederhana
    

Card menjadi komponen utama dalam menampilkan informasi konser maupun tiket.

---

## Input Field

Input memiliki:

- Border hitam 3px
    
- Background putih
    
- Shadow kecil
    
- Placeholder jelas
    
- Focus state menggunakan warna utama
    

---

## Icon Style

Menggunakan icon outline sederhana seperti:

- Lucide
    
- Heroicons
    

Ikon tidak menggunakan efek 3D.

---

## Animation

Animasi dibuat ringan dan cepat.

Durasi:

- 150–250 ms
    

Interaksi:

- Scale kecil saat hover
    
- Shadow bergeser
    
- Button sedikit turun saat ditekan
    

Tidak menggunakan animasi berlebihan.

---

## Layout

Grid menggunakan sistem 12 kolom.

Container maksimum:

- 1280px
    

Spacing mengikuti skala:

- 8px
    
- 16px
    
- 24px
    
- 32px
    
- 48px
    
- 64px
    

---

# 14. Component Guidelines

Komponen yang harus mengikuti desain Neobrutalism:

- Navbar
    
- Hero Banner
    
- Ticket Card
    
- Event Card
    
- Form Input
    
- Select Ticket
    
- Checkout Summary
    
- Payment Status
    
- QR Ticket
    
- Modal
    
- Alert
    
- Toast Notification
    
- Dashboard Card
    
- Table Admin
    
- Statistics Card
    
- Sidebar Admin
    
- Pagination
    
- Search Bar
    
- Filter
    
- Badge Status
    
- Empty State
    
- Loading Skeleton
    

---

# 15. Responsive Design

Desktop menjadi prioritas utama (Desktop First).

Breakpoint:

- Desktop ≥ 1280px
    
- Laptop ≥ 1024px
    
- Tablet ≥ 768px
    
- Mobile ≥ 375px
    

Seluruh elemen Neobrutalism harus tetap mempertahankan:

- Border tebal
    
- Shadow khas
    
- Hierarki visual
    
- Keterbacaan
    
- Konsistensi warna
    

---

# 16. UX Principles

Aplikasi mengikuti prinsip:

- Minimal jumlah langkah untuk membeli tiket.
    
- Seluruh aksi penting terlihat jelas.
    
- Pengguna selalu mengetahui posisi proses pembelian.
    
- Kesalahan input ditampilkan secara informatif.
    
- Konfirmasi pembayaran mudah dipahami.
    
- Tiket dapat diakses kembali tanpa kebingungan.
    

Fokus utama UX adalah mengurangi waktu yang dibutuhkan pengguna dari membuka halaman hingga memperoleh e-ticket.