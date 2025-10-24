@component('mail::message')
# Pesan Baru dari Formulir Kontak

**Pengirim:** {{ $contactData['name'] }} ({{ $contactData['email'] }})

**Subjek:** {{ $contactData['subject'] }}

**Nomor Telepon:** {{ $contactData['phone'] ?? 'Tidak disertakan' }}

**Pesan:**

{{ $contactData['message'] }}

---

Pesan ini dikirim melalui formulir kontak di website ARDFYA.

@endcomponent 