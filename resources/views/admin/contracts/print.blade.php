<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kontrak #{{ $contract->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .contract-details {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid black;
            margin-top: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <div class="title">KONTRAK KERJA</div>
        <div>Nomor: {{ $contract->contract_number }}</div>
    </div>

    <div class="contract-details">
        <div class="section">
            <div class="section-title">PIHAK PERTAMA:</div>
            <p>ARDFYA<br>
            Alamat: kebon jeruk jakrta barat<br>
            Telp: 085121017108</p>
        </div>

        <div class="section">
            <div class="section-title">PIHAK KEDUA:</div>
            <p>{{ $contract->user->name }}<br>
            Alamat: {{ $contract->project->inquiry->address }}<br>
            Telp: {{ $contract->user->phone }}</p>
        </div>

        <div class="section">
            <div class="section-title">DETAIL PROYEK:</div>
            <table>
                <tr>
                    <td>Nama Proyek</td>
                    <td>: {{ $contract->project->name }}</td>
                </tr>
                <tr>
                    <td>Layanan</td>
                    <td>: {{ $contract->project->service->name }}</td>
                </tr>
                <tr>
                    <td>Nilai Kontrak</td>
                    <td>: Rp {{ number_format($contract->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>: {{ $contract->start_date->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Selesai</td>
                    <td>: {{ $contract->end_date ? $contract->end_date->format('d F Y') : '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">DESKRIPSI PEKERJAAN:</div>
            <p>{{ $contract->project->description }}</p>
        </div>

        <div class="section">
            <div class="section-title">SYARAT DAN KETENTUAN:</div>
            {!! $contract->terms_and_conditions !!}
        </div>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <p>PIHAK PERTAMA</p>
            <div class="signature-line"></div>
            <p>ARDFYA</p>
        </div>
        <div class="signature-box">
            <p>PIHAK KEDUA</p>
            <div class="signature-line"></div>
            <p>{{ $contract->user->name }}</p>
        </div>
    </div>
</body>
</html>