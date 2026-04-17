<!DOCTYPE html>
<html>
<body style="font-family:'Segoe UI',sans-serif; background:#f1f5f9; padding:40px 0;">
<div style="max-width:480px; margin:0 auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
    <div style="height:5px; background:linear-gradient(90deg,#f59e0b,#f97316);"></div>
    <div style="padding:36px 40px;">
        <h2 style="color:#0f2d6e; margin-bottom:6px;">Password Reset Request</h2>
        <p style="color:#64748b; margin-bottom:24px;">Hi {{ $name }},</p>
        <p style="color:#374151; line-height:1.6; margin-bottom:24px;">
            We received a request to reset your UniManage password. Click the button below to set a new password. This link will expire in <strong>30 minutes</strong>.
        </p>
        <a href="{{ $resetLink }}"
           style="display:inline-block; background:linear-gradient(135deg,#0f2d6e,#1a56db); color:#fff; padding:13px 28px; border-radius:10px; text-decoration:none; font-weight:600; font-size:15px;">
            Reset My Password
        </a>
        <p style="color:#94a3b8; font-size:13px; margin-top:28px; line-height:1.6;">
            If you didn't request this, you can safely ignore this email. Your password will remain unchanged.
        </p>
        <hr style="border:none; border-top:1px solid #e2e8f0; margin:24px 0;">
        <p style="color:#94a3b8; font-size:12px; text-align:center;">
            © {{ date('Y') }} UniManage — Bahagian Teknologi Maklumat UPTM
        </p>
    </div>
</div>
</body>
</html>