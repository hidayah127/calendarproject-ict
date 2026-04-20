<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>Surat Lantikan</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DejaVu Serif', 'Times New Roman', serif;
    font-size: 12pt;
    color: #000;
    line-height: 1.7;
  }

  /* ── Top colour bar ── */
  .top-bar {
    width: 100%;
    height: 10px;
    background: #003087;
    margin-bottom: 0;
  }
  .top-bar-red {
    width: 100%;
    height: 4px;
    background: #c8102e;
    margin-bottom: 0;
  }

  /* ── Letterhead ── */
  .letterhead {
    padding: 16px 48px 12px;
    border-bottom: 2.5pt solid #003087;
  }
  .lh-table {
    width: 100%;
    border-collapse: collapse;
  }
  .lh-logo-cell {
    width: 80px;
    vertical-align: middle;
  }
  .lh-logo-box {
    width: 64px;
    height: 64px;
    background: #003087;
    border-radius: 32px;
    text-align: center;
    padding-top: 14px;
  }
  .lh-logo-text {
    color: #fff;
    font-size: 18pt;
    font-weight: bold;
  }
  .lh-name-cell {
    vertical-align: middle;
    padding-left: 12px;
  }
  .lh-org {
    font-size: 16pt;
    font-weight: bold;
    color: #003087;
    text-transform: uppercase;
    letter-spacing: 0.5pt;
  }
  .lh-tagline {
    font-size: 9pt;
    color: #555;
    font-style: italic;
    margin-top: 2px;
  }
  .lh-right-cell {
    text-align: right;
    vertical-align: middle;
    font-size: 9pt;
    color: #444;
  }

  /* ── Sub-header band ── */
  .sub-header {
    background: #003087;
    padding: 6px 48px;
    color: #fff;
    font-size: 9pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1pt;
  }
  .sub-header-inner {
    width: 100%;
  }

  /* ── Letter body ── */
  .letter-body {
    padding: 24px 48px 20px;
  }

  /* Reference block */
  .ref-table {
    border-collapse: collapse;
    margin-bottom: 18px;
    font-size: 11pt;
  }
  .ref-table td {
    padding: 1px 0;
    vertical-align: top;
  }
  .ref-label { width: 110px; color: #333; }
  .ref-colon { width: 16px; text-align: center; }

  /* Recipient */
  .recipient {
    margin-bottom: 16px;
  }
  .rec-name {
    font-weight: bold;
    font-size: 12pt;
    text-transform: uppercase;
  }

  /* Salutation */
  .salutation { margin-bottom: 14px; }

  /* Subject */
  .subject {
    font-weight: bold;
    text-decoration: underline;
    text-transform: uppercase;
    font-size: 12pt;
    margin-bottom: 16px;
  }

  /* Paragraphs */
  .para-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
  }
  .para-num-cell {
    width: 32px;
    vertical-align: top;
    font-size: 11pt;
  }
  .para-txt-cell {
    vertical-align: top;
    font-size: 11pt;
    text-align: justify;
    line-height: 1.7;
  }

  /* Details table */
  .details-table {
    border-collapse: collapse;
    margin: 12px 0 14px 32px;
    font-size: 11pt;
    width: calc(100% - 32px);
  }
  .details-table td {
    padding: 3px 4px 3px 0;
    vertical-align: top;
  }
  .dt-label { width: 160px; color: #333; }
  .dt-colon { width: 14px; }
  .dt-val   { font-weight: bold; }
  .dt-role  { font-weight: bold; color: #003087; }

  /* Responsibility */
  .resp-block {
    margin: 6px 0 12px 32px;
    font-size: 11pt;
  }

  /* Mottos */
  .mottos { margin: 16px 0 6px; }
  .mottos p { font-weight: bold; font-size: 12pt; line-height: 1.6; }

  /* Signature */
  .sig-intro { font-size: 11pt; margin-bottom: 50px; margin-top: 16px; }
  .sig-line  { font-weight: bold; font-size: 12pt; text-transform: uppercase; border-top: 1.5pt solid #000; padding-top: 5px; display: inline-block; }
  .sig-sub   { font-size: 11pt; color: #000; }

  /* sk */
  .sk { margin-top: 18px; font-size: 10.5pt; }
  .sk-table { border-collapse: collapse; }
  .sk-table td { padding: 0 3px 0 0; vertical-align: top; }

  /* Footer */
  .letter-footer {
    border-top: 2.5pt solid #003087;
    padding: 8px 48px;
    font-size: 9pt;
  }
  .footer-inner {
    width: 100%;
  }
  .footer-left  { font-style: italic; font-weight: bold; color: #003087; }
  .footer-right { text-align: right; color: #888; }

  .bottom-bar {
    width: 100%;
    height: 6px;
    background: #003087;
  }
</style>
</head>
<body>

{{-- Top bar --}}
<div class="top-bar"></div>
<div class="top-bar-red"></div>

{{-- Letterhead --}}
<div class="letterhead">
  <table class="lh-table">
    <tr>
      <td class="lh-logo-cell">
        <div class="lh-logo-box">
          <span class="lh-logo-text">AT</span>
        </div>
      </td>
      <td class="lh-name-cell">
        <div class="lh-org">AmazingTrack</div>
        <div class="lh-tagline">"Innovative &bull; Inclusive &bull; Integrity"</div>
      </td>
      <td class="lh-right-cell">
        {{ $program->department->name ?? 'Jabatan' }}<br>
        <span style="color:#003087;font-weight:bold;">AmazingTrack System</span>
      </td>
    </tr>
  </table>
</div>

{{-- Sub-header --}}
<div class="sub-header">
  <table class="sub-header-inner">
    <tr>
      <td>AmazingTrack — Sistem Pengurusan Program</td>
      <td style="text-align:right;color:#fbbf24;">&#9733; Surat Lantikan Jawatankuasa</td>
    </tr>
  </table>
</div>

{{-- Letter body --}}
<div class="letter-body">

  {{-- Reference --}}
  <table class="ref-table">
    <tr>
      <td class="ref-label">Rujukan Kami</td>
      <td class="ref-colon">:</td>
      <td>{{ strtoupper(Str::slug($program->title, '/')) }}/{{ now()->format('Y') }}/{{ $staff->staff_id }}</td>
    </tr>
    <tr>
      <td class="ref-label">Tarikh</td>
      <td class="ref-colon">:</td>
      <td>{{ now()->translatedFormat('d F Y') }}</td>
    </tr>
  </table>

  {{-- Recipient --}}
  <div class="recipient">
    <div class="rec-name">{{ $staff->name }}</div>
    @if($staff->position)
    <div>{{ strtoupper($staff->position) }}</div>
    @endif
    <div>{{ strtoupper($program->department->name ?? '') }}</div>
  </div>

  {{-- Salutation --}}
  <div class="salutation">Tuan/Puan,</div>

  {{-- Subject --}}
  <div class="subject">LANTIKAN JAWATANKUASA — {{ strtoupper($program->title) }}</div>

  {{-- Para 1 --}}
  <table class="para-table">
    <tr>
      <td class="para-num-cell"></td>
      <td class="para-txt-cell">Dengan hormatnya perkara di atas adalah dirujuk.</td>
    </tr>
  </table>

  {{-- Para 2 --}}
  <table class="para-table">
    <tr>
      <td class="para-num-cell">2.</td>
      <td class="para-txt-cell">
        Sukacita dimaklumkan bahawa tuan/puan telah dilantik sebagai
        <strong>{{ $role }}</strong>{{ $isLead ? ' <strong>(Ketua)</strong>' : '' }}
        dalam Jawatankuasa bagi program yang dinyatakan di bawah, berkuat kuasa
        <strong>{{ $program->start_date->translatedFormat('d F Y') }}</strong>
        @if($program->start_date->ne($program->end_date))
          sehingga <strong>{{ $program->end_date->translatedFormat('d F Y') }}</strong>
        @endif.
      </td>
    </tr>
  </table>

  {{-- Details --}}
  <table class="details-table">
    <tr>
      <td class="dt-label">Nama Program</td>
      <td class="dt-colon">:</td>
      <td class="dt-val">{{ $program->title }}</td>
    </tr>
    <tr>
      <td class="dt-label">Tarikh Program</td>
      <td class="dt-colon">:</td>
      <td class="dt-val">
        {{ $program->start_date->translatedFormat('d F Y') }}
        @if($program->start_date->ne($program->end_date))
          – {{ $program->end_date->translatedFormat('d F Y') }}
        @endif
      </td>
    </tr>
    @if($program->venue)
    <tr>
      <td class="dt-label">Tempat</td>
      <td class="dt-colon">:</td>
      <td class="dt-val">{{ $program->venue }}</td>
    </tr>
    @endif
    <tr>
      <td class="dt-label">Jawatan / Peranan</td>
      <td class="dt-colon">:</td>
      <td class="dt-role">{{ $role }}{{ $isLead ? ' (Ketua)' : '' }}</td>
    </tr>
    <tr>
      <td class="dt-label">Jabatan</td>
      <td class="dt-colon">:</td>
      <td class="dt-val">{{ $program->department->name ?? '—' }}</td>
    </tr>
  </table>

  {{-- Para 3 — responsibility --}}
  @if($responsibility)
  <table class="para-table">
    <tr>
      <td class="para-num-cell">3.</td>
      <td class="para-txt-cell">
        Bersama-sama ini dimaklumkan bahawa <strong><u>tanggungjawab khusus</u></strong>
        tuan/puan bagi pelantikan ini adalah seperti berikut:
      </td>
    </tr>
  </table>
  <div class="resp-block">{{ $responsibility }}</div>
  @endif

  {{-- Para closing --}}
  <table class="para-table">
    <tr>
      <td class="para-num-cell">{{ $responsibility ? '4.' : '3.' }}</td>
      <td class="para-txt-cell">
        Tuan/puan dimohon agar menjalankan tugas dengan penuh amanah, dedikasi, dan
        profesionalisme sepanjang tempoh program berlangsung. Saya bagi pihak AmazingTrack
        mengucapkan tahniah di atas pelantikan ini dan diharapkan tuan/puan dapat menjalankan
        tugas yang diamanahkan dengan penuh dedikasi. Segala kerjasama serta komitmen
        pihak tuan/puan amatlah kami hargai.
      </td>
    </tr>
  </table>

  <p style="margin:14px 0;font-size:11pt;">Sekian, terima kasih.</p>

  {{-- Mottos --}}
  <div class="mottos">
    <p>"MALAYSIA MADANI"</p>
    <p>"BERKHIDMAT UNTUK NEGARA"</p>
  </div>

  {{-- Signature --}}
  <div class="sig-intro">Saya yang menjalankan amanah,</div>
  <div>
    <span class="sig-line">( __________________________________________ )</span><br>
    <span class="sig-sub">Pengurus Program / Ketua Jabatan</span><br>
    <span class="sig-sub">AmazingTrack</span><br>
    <span class="sig-sub">{{ now()->translatedFormat('d F Y') }}</span>
  </div>

  {{-- s.k. --}}
  <div class="sk">
    <table class="sk-table">
      <tr>
        <td>s.k :</td>
        <td>i. Fail Peribadi</td>
      </tr>
    </table>
  </div>

</div>

{{-- Footer --}}
<div class="letter-footer">
  <table class="footer-inner">
    <tr>
      <td class="footer-left">"Innovative. Inclusive. Integrity"</td>
      <td class="footer-right">Surat dijana oleh AmazingTrack &bull; {{ now()->format('Y') }}</td>
    </tr>
  </table>
</div>

<div class="bottom-bar"></div>

</body>
</html>