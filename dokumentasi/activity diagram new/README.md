# Activity Diagram - ARDFYA System

## 📋 **Daftar Activity Diagram**

Dokumentasi ini berisi activity diagram untuk sistem ARDFYA yang dibuat dengan pendekatan reverse engineering. Setiap diagram menggunakan model swimlane dengan minimal 2 kolom (Aktor dan Sistem).

### **Guest Activities (Website Publik)**
1. **01-guest-lihat-beranda.puml** - Activity diagram untuk guest melihat halaman beranda
2. **02-guest-lihat-portfolio.puml** - Activity diagram untuk guest melihat portfolio

### **Customer Activities (Website Pelanggan)**
3. **03-customer-registrasi-login.puml** - Activity diagram untuk registrasi dan login customer
4. **04-customer-dashboard.puml** - Activity diagram untuk dashboard customer
5. **05-customer-lacak-proyek.puml** - Activity diagram untuk customer melacak proyek
6. **06-customer-chat.puml** - Activity diagram untuk fitur chat customer
7. **07-customer-ajukan-permintaan.puml** - Activity diagram untuk customer mengajukan inquiry

### **Admin Activities (Panel Admin)**
8. **08-admin-login.puml** - Activity diagram untuk login admin
9. **09-admin-dashboard.puml** - Activity diagram untuk dashboard admin
10. **10-admin-kelola-portfolio.puml** - Activity diagram untuk admin mengelola portfolio
11. **11-admin-kelola-permintaan.puml** - Activity diagram untuk admin mengelola inquiry
12. **12-admin-kelola-proyek-simple.puml** - Activity diagram admin kelola proyek (RECOMMENDED)
13. **12-admin-kelola-proyek.puml** - Activity diagram admin kelola proyek (overview)
14. **12a-admin-update-progress-proyek.puml** - Detail update progress proyek
15. **12b-admin-selesaikan-proyek.puml** - Detail selesaikan proyek
16. **13-admin-buat-kontrak.puml** - Activity diagram untuk admin membuat kontrak

### **Use Case Diagram**
17. **14-use-case-diagram.puml** - Use Case Diagram simplified dengan 4 aktor (User, Guest, Customer, Admin) - 17 use cases dengan kata kerja, generalisasi, include/extend relationships, layout vertikal bersebrangan

## 🎯 **Karakteristik Diagram**

- **Format**: PlantUML Swimlane
- **Kolom**: Minimal 2 kolom (Aktor dan Sistem)
- **Styling**: Konsisten dengan tema biru dan orange
- **Konteks**: Reverse engineering dari sistem yang sudah ada
- **Kompleksitas**: Sederhana dan mudah dipahami

## 📝 **Cara Penggunaan**

1. Buka file `.puml` dengan PlantUML viewer
2. Atau copy kode ke PlantUML online editor
3. Generate diagram untuk melihat visualisasi

## 🔄 **Status**

✅ Semua activity diagram telah dibuat
✅ Format swimlane telah diterapkan dengan benar
✅ Syntax PlantUML telah diperbaiki
✅ Styling konsisten dengan tema biru dan orange
✅ Dokumentasi lengkap dan siap digunakan

## 🛠️ **Update Terakhir**

### **Perbaikan Layout Anti-Overlapping**
✅ Ditambahkan spacing parameters untuk menghindari flow lines menimpa activity box:
```
skinparam nodesep 60        // Jarak antar node
skinparam ranksep 80        // Jarak antar level
skinparam minlen 4          // Panjang minimum garis
skinparam padding 15        // Padding tambahan
```

### **File Tambahan untuk Diagram yang Lebih Bersih**
✅ **10-admin-kelola-portfolio-simple.puml** - Versi sederhana tanpa overlapping
✅ **03b-customer-registrasi.puml** - Registrasi terpisah dari login
✅ **10a-admin-tambah-portfolio.puml** - Detail proses tambah portfolio
✅ **10b-admin-edit-portfolio.puml** - Detail proses edit portfolio
✅ **10c-admin-hapus-portfolio.puml** - Detail proses hapus portfolio
✅ **contoh-clean-flow.puml** - Template untuk diagram yang rapi

### **Rekomendasi Penggunaan**
🎯 **Gunakan file dengan suffix "-simple"** untuk diagram yang lebih bersih:
   - **10-admin-kelola-portfolio-simple.puml** untuk kelola portfolio
   - **12-admin-kelola-proyek-simple.puml** untuk kelola proyek

🎯 **Gunakan file terpisah untuk detail proses:**
   - Portfolio: 10a, 10b, 10c
   - Proyek: 12a, 12b

🎯 **Hindari nested decision** yang menyebabkan overlapping

- **Syntax Error Fixed**: Semua file telah diperbaiki dari format `|Aktor|Sistem|` menjadi format swimlane yang benar
- **Format Swimlane**: Menggunakan deklarasi kolom terpisah dengan `|NamaKolom|`
- **Perpindahan Kolom**: Flow yang jelas antar kolom Aktor dan Sistem
- **Flow Lines Diperbaiki**: Menambahkan `skinparam linetype ortho` untuk garis flow yang rapi dan tidak bersilangan
- **PlantUML Valid**: Semua file dapat di-render tanpa error dengan tampilan yang bersih
