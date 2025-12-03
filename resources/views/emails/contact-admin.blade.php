<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Baru dari Form Kontak – hotringo.tech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            -webkit-text-size-adjust: 100%;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        img {
            border: 0;
            display: block;
            line-height: 100%;
        }
        a {
            text-decoration: none;
        }

        /* Mobile tweaks */
        @media only screen and (max-width: 480px) {
            .wrapper {
                padding: 16px 8px !important;
            }
            .card {
                border-radius: 16px !important;
            }
            .section-padding {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .title-text {
                font-size: 18px !important;
            }
            .intro-text,
            .body-text {
                font-size: 13px !important;
            }
            .summary-card,
            .message-card {
                border-radius: 12px !important;
            }
            .cta-button {
                width: 100% !important;
                text-align: center !important;
                display: block !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#ffffff;">

<!-- Outer wrapper -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
    <tr>
        <td align="center" class="wrapper" style="padding:24px 8px;">
            <!-- Main card -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                   class="card"
                   style="max-width:640px;background-color:#ffffff;border-radius:20px;overflow:hidden;
                          border:1px solid #e5e7eb;box-shadow:0 10px 30px rgba(15,23,42,.08);">

                <tr>
                    <td style="padding:16px 24px 10px 24px;border-bottom:1px solid #e5e7eb;">
                        <table align="center" cellpadding="0" cellspacing="0" border="0" role="presentation">
                            <tr>
                                <td valign="middle" style="padding-right:8px;">
                                    <img
                                        src="https://hotringo.blob.core.windows.net/logohotringo/logo_hjs.png"
                                        alt="Logo hotringo.tech"
                                        width="30"
                                        height="30"
                                        style="width:30px;height:30px;margin:0;border-radius:999px;"
                                    >
                                </td>
                                <td valign="middle">
                                    <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                font-size:18px;font-weight:700;color:#111827;letter-spacing:-0.04em;
                                                white-space:nowrap;">
                                        hotringo.tech
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:16px 24px 4px 24px;">
                        <img
                            src="https://hotringo.blob.core.windows.net/hotringolandingemail/hotringo.tech.png"
                            alt="hotringo.tech – Contact Form"
                            width="592"
                            style="width:100%;max-width:592px;border-radius:18px;margin:0 auto;"
                        >
                    </td>
                </tr>

                <tr>
                    <td class="section-padding" style="padding:8px 28px 4px 28px;">
                        <div class="title-text"
                             style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:22px;font-weight:700;color:#111827;text-align:left;letter-spacing:-0.04em;">
                            Pesan baru dari form kontak
                        </div>
                        <div class="intro-text"
                             style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:13px;color:#4b5563;text-align:left;margin-top:6px;line-height:1.6;">
                            Seseorang menghubungi melalui formulir kontak di website
                            <strong>hotringo.tech</strong>. Detail ringkasnya dapat Anda lihat di bawah ini.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="section-padding" style="padding:12px 28px 4px 28px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                               class="summary-card"
                               style="background-color:#f9fafb;border-radius:16px;border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:14px 18px 4px 18px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                        <tr>
                                            <td colspan="2"
                                                style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                       font-size:11px;color:#6b7280;text-transform:uppercase;
                                                       letter-spacing:.16em;padding-bottom:6px;">
                                                Ringkasan permintaan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%" style="padding-right:10px;">
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:12px;color:#6b7280;margin-bottom:2px;">
                                                    Nama pengirim
                                                </div>
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:15px;font-weight:600;color:#111827;">
                                                    {{ $data['name'] ?? '-' }}
                                                </div>
                                            </td>
                                            <td width="50%">
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:12px;color:#6b7280;margin-bottom:2px;">
                                                    Alamat email
                                                </div>
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:14px;color:#111827;word-break:break-all;">
                                                    {{ $data['email'] ?? '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan="2" style="height:10px;font-size:0;line-height:0;">&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:12px;color:#6b7280;margin-bottom:2px;">
                                                    Subjek pesan
                                                </div>
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:14px;font-weight:500;color:#111827;">
                                                    {{ $data['subject'] ?? '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan="2" style="height:8px;font-size:0;line-height:0;">&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                            font-size:11px;color:#9ca3af;">
                                                    Diterima pada {{ now()->format('d M Y, H:i') }} (waktu server)
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td class="section-padding" style="padding:10px 28px 18px 28px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                               class="message-card"
                               style="background-color:#ffffff;border-radius:16px;border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:14px 18px 18px 18px;">
                                    <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:.16em;
                                                margin-bottom:6px;">
                                        Detail pesan
                                    </div>
                                    <div class="body-text"
                                         style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                                font-size:14px;color:#111827;line-height:1.8;">
                                        {!! nl2br(e($data['message'] ?? '')) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:0 28px 22px 28px;">
                        @if (!empty($data['email']))
                            <a href="mailto:{{ $data['email'] }}"
                               class="cta-button"
                               style="display:inline-block;padding:11px 34px;border-radius:999px;
                                      background:linear-gradient(135deg,#22c55e,#4ade80);color:#022c22;
                                      font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                      font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;">
                                Balas pengirim
                            </a>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:18px 24px 20px 24px;">
                        <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:14px;font-weight:600;color:#111827;margin-bottom:4px;">
                            Butuh bantuan menindaklanjuti pesan ini?
                        </div>
                        <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:12px;color:#4b5563;line-height:1.7;margin-bottom:10px;">
                            Balas email ini secara langsung kepada pengirim untuk melanjutkan komunikasi, kemudian
                            arsipkan detailnya di sistem internal <strong>hotringo.tech</strong> agar setiap prospek,
                            konsultasi, dan proyek baru tercatat dengan rapi.
                        </div>
                        <div style="font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
                                    font-size:11px;color:#6b7280;line-height:1.6;">
                            Email ini dikirim otomatis sebagai notifikasi dari formulir kontak di website
                            <strong>hotringo.tech</strong>. Jika pesan ini tidak relevan, Anda dapat mengabaikan email ini.<br><br>
                            © {{ date('Y') }} hotringo.tech – Studio arsitektur &amp; manajemen proyek. All rights reserved.
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
