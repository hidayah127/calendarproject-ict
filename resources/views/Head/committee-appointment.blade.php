<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Jawatankuasa Program</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            font-size: 14px;
            line-height: 1.7;
        }

        .wrapper {
            max-width: 640px;
            margin: 30px auto;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 28px rgba(15, 45, 110, 0.12);
        }

        /* Top Accent */
        .top-bar {
            height: 5px;
            background: linear-gradient(90deg, #0f2d6e, #1a56db, #3b82f6);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #0a1f52, #0f2d6e, #1e40af);
            padding: 28px 40px;
            text-align: center;
        }

        .header-sys {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #fbbf24;
            margin-bottom: 6px;
        }

        .header-title {
            font-size: 19px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
        }

        .header-program {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
            font-style: italic;
        }

        /* Body */
        .email-body {
            padding: 30px 40px;
        }

        /* Greeting */
        .greeting {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .greeting-sub {
            font-size: 13.5px;
            color: #475569;
            margin-bottom: 22px;
        }

        /* Role Card */
        .role-card {
            background: #f8faff;
            border: 1.5px solid #dbeafe;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 22px;
        }

        .role-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 3px;
        }

        .role-value {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }

        .role-lead-badge {
            background: #fef9c3;
            color: #b45309;
            border: 1px solid #fde68a;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            margin-left: 8px;
        }

        /* Section Title */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        /* Details */
        .detail-list {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .detail-row {
            display: flex;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 150px;
            font-size: 12.5px;
            color: #64748b;
            font-weight: 600;
        }

        .detail-value {
            flex: 1;
            font-size: 13px;
            color: #0f172a;
            font-weight: 600;
        }

        /* Responsibility */
        .resp-box {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 22px;
        }

        .resp-box-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #b45309;
            margin-bottom: 6px;
        }

        /* Notice */
        .notice-banner {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 22px;
        }

        .notice-banner p {
            font-size: 13px;
            color: #166534;
        }

        /* Button */
        .cta-wrap {
            text-align: center;
            margin-bottom: 24px;
        }

        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #0f2d6e, #1a56db);
            color: #fff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 30px;
            border-radius: 10px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 22px 0;
        }

        /* Closing */
        .closing {
            font-size: 13.5px;
            color: #475569;
        }

        /* Footer */
        .email-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 40px;
            text-align: center;
        }

        .footer-sys {
            font-size: 12px;
            font-weight: 700;
            color: #1a56db;
            margin-bottom: 4px;
        }

        .footer-note {
            font-size: 11px;
            color: #94a3b8;
        }

        .bottom-bar {
            height: 4px;
            background: linear-gradient(90deg, #0f2d6e, #1a56db, #3b82f6);
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div class="top-bar"></div>

    <!-- Header -->
    <div class="email-header">

        <div class="header-sys">
            AmazingTrack System
        </div>

        <div class="header-title">
            Pelantikan Ahli Jawatankuasa Program
        </div>

        <div class="header-program">
            {{ $program->title }}
        </div>

    </div>

    <!-- Body -->
    <div class="email-body">

        <div class="greeting">
            Assalamualaikum & Salam Sejahtera,
            {{ $staff->name }},
        </div>

        <div class="greeting-sub">
            Anda telah dilantik sebagai ahli jawatankuasa bagi program berikut.
            Sila semak maklumat pelantikan anda di bawah.
        </div>

        <!-- Role -->
        <div class="role-card">

            <div class="role-label">
                Peranan Anda
            </div>

            <div class="role-value">

                {{ $role }}

                @if($isLead)
                    <span class="role-lead-badge">
                        Ketua
                    </span>
                @endif

            </div>

        </div>

        <!-- Program Details -->
        <div class="section-title">
            Maklumat Program
        </div>

        <div class="detail-list">

            <div class="detail-row">
                <span class="detail-label">
                    Nama Program
                </span>
                <span class="detail-value">
                    {{ $program->title }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    Tarikh
                </span>
                <span class="detail-value">

                    {{ $program->start_date->translatedFormat('d F Y') }}

                    @if($program->start_date->ne($program->end_date))
                        — {{ $program->end_date->translatedFormat('d F Y') }}
                    @endif

                </span>
            </div>

            @if($program->venue)
            <div class="detail-row">
                <span class="detail-label">
                    Tempat
                </span>
                <span class="detail-value">
                    {{ $program->venue }}
                </span>
            </div>
            @endif

            <div class="detail-row">
                <span class="detail-label">
                    Anjuran
                </span>
                <span class="detail-value">
                    {{ $program->department->name ?? '—' }}
                </span>
            </div>

            {{-- <div class="detail-row">
                <span class="detail-label">
                    Status
                </span>
                <span class="detail-value">
                    {{ ucfirst($program->status ?? 'Upcoming') }}
                </span>
            </div> --}}

            <div class="detail-row">

                <span class="detail-label">
                    Pegawai Bertanggungjawab
                </span>

                <span class="detail-value">

                    {{ $program->staffInCharge->name ?? '—' }}

                    @if($program->staffInCharge?->position)
                        ({{ $program->staffInCharge->position }})
                    @endif

                </span>

            </div>

        </div>

        <!-- Responsibility -->
        @if($responsibility)

        <div class="resp-box">

            <div class="resp-box-title">
                Tanggungjawab Anda
            </div>

            <p>
                {{ $responsibility }}
            </p>

        </div>

        @endif

        <!-- Notice -->
       <div class="notice-banner">

            <p>
                Surat lantikan rasmi akan menyusul dalam masa terdekat.
                Sekiranya terdapat sebarang perubahan berkaitan program
                atau pelantikan ini, pihak kami akan memaklumkan kepada
                tuan/puan dari semasa ke semasa.
            </p>

        </div>

        <!-- Button -->
        {{-- <div class="cta-wrap">

            <a href="{{ url('/') }}" class="cta-btn">
                Lihat Program
            </a>

        </div> --}}

        <hr class="divider">

        <!-- Closing -->
        <div class="closing">

            Sebarang pertanyaan boleh dirujuk kepada pihak pengurus program.

            <br><br>

            Terima kasih.

            <br><br>

            <strong>Pasukan AmazingTrack</strong>

            <br>

            <span style="font-size:12px;color:#94a3b8;">
                Notifikasi dihantar pada
                {{ now()->translatedFormat('d F Y, H:i') }}
            </span>

        </div>

    </div>

    <!-- Footer -->
    <div class="email-footer">

        <div class="footer-sys">
            AmazingTrack
        </div>

        <div class="footer-note">
            Emel ini dijana secara automatik.
            Sila jangan balas emel ini.
            <br>
            © {{ now()->format('Y') }} AmazingTrack
        </div>

    </div>

    <div class="bottom-bar"></div>

</div>

</body>

</html>