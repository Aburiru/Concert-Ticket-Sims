# PRD - Concert Ticket Booking System

## 1. Project Overview

**Nama:** Concert Ticket Booking System

**Tujuan**  
Membangun aplikasi web untuk pemesanan tiket konser secara online dengan pembayaran otomatis menggunakan Midtrans serta penerbitan e-ticket berbasis QR Code.

---

# 2. Objectives

- Memudahkan pembelian tiket secara online.
- Mengintegrasikan pembayaran Midtrans.
- Menghasilkan e-ticket otomatis setelah pembayaran berhasil.
- Membantu admin mengelola tiket dan transaksi secara real-time.

---

# 3. Target Users

### User

- Melihat informasi konser
- Membeli tiket
- Melakukan pembayaran
- Mengunduh e-ticket

### Admin

- Mengelola tiket
- Memantau transaksi
- Melihat laporan penjualan

---

# 4. User Flow

Landing Page  
→ Pilih Tiket  
→ Isi Data Pembeli  
→ Checkout  
→ Pembayaran (Midtrans)  
→ Pembayaran Berhasil  
→ Generate QR Ticket  
→ Download E-Ticket

---

# 5. Core Features

## User

- Informasi konser
- Pemilihan jenis tiket
- Form pembelian
- Checkout
- Pembayaran Midtrans
- E-ticket dengan QR Code
- Halaman status pembayaran

## Admin

- CRUD jenis tiket
- Pengaturan kuota
- Manajemen transaksi
- Dashboard statistik
- Data pembeli

---

# 6. Functional Requirements

### Ticket Booking

- Memilih jenis tiket
- Mengisi data pembeli
- Validasi form
- Mengecek ketersediaan tiket

### Payment

- Integrasi Midtrans Snap
- Status transaksi:
    - Pending
    - Success
    - Failed
    - Expired
    - Cancelled

### E-Ticket

Setelah pembayaran berhasil:

- Generate Ticket ID
- Generate QR Code
- Status tiket aktif
- Download e-ticket

---

# 7. Non-Functional Requirements

### Performance

- Waktu muat <2 detik
- Mendukung banyak pengguna

### Security

- HTTPS
- CSRF Protection
- SQL Injection Protection
- XSS Protection
- Server-side Validation

### Reliability

- Error Logging
- Database Backup
- Transaction Rollback

---

# 8. Database (Core)

**Users**

- id
- name
- email
- role

**Ticket Types**

- id
- name
- price
- quota

**Orders**

- id
- ticket_id
- ticket_type_id
- quantity
- total_price
- payment_status

**Payments**

- id
- order_id
- transaction_id
- payment_type
- transaction_status

---

# 9. Technology Stack

**Backend**

- Laravel 12
- PHP 8.3

**Frontend**

- Blade
- Tailwind CSS
- Alpine.js

**Database**

- MySQL

**Payment**

- Midtrans Snap API

**QR Code**

- Simple QrCode

---

# 10. UI/UX Guidelines

**Design Style:** Neobrutalism

Prinsip utama:

- Bold typography
- Warna kontras tinggi
- Border hitam tebal
- Flat design
- Shadow khas Neobrutalism
- Rounded corners
- Responsif (Desktop First)

---

# 11. Future Development

- Login pengguna
- Riwayat pembelian
- Seat Selection
- Voucher & Promo
- QR Check-in
- Multi Event Management
- Email & WhatsApp Notification
- Refund Management
- Export laporan (Excel/PDF)

---

# 12. Success Metrics

- Pembelian tiket berjalan tanpa kendala.
- Pembayaran Midtrans berhasil diproses.
- E-ticket diterbitkan otomatis.
- Admin dapat memantau transaksi secara real-time.
- Sistem stabil dan aman.