<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        {{ $type === 'create' ? 'Account Created' : 'Account Updated' }}
    </title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:500px; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr style="background:#f98000;">
                    <td style="padding:20px; text-align:center; color:#ffffff;">
                        <h2 style="margin:0;">
                            {{ $type === 'create' ? 'Welcome!' : 'Account Updated' }}
                        </h2>
                        <p style="margin:5px 0 0; font-size:14px;">
                            {{ $type === 'create' ? 'Your Club Account is Ready' : 'Your Account Details Were Updated' }}
                        </p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px; color:#333;">

                        <p style="font-size:15px;">
                            @if($type === 'create')
                                Your <strong>Club account</strong> has been successfully created.
                            @else
                                Your <strong>Club account</strong> has been updated successfully.
                            @endif
                        </p>

                        <!-- Info Box -->
                        <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:15px; border:1px solid #e9ecef; border-radius:8px;">

                            <tr style="background:#f8f9fa;">
                                <td style="font-weight:bold; width:120px;">Email</td>
                                <td>{{ $email }}</td>
                            </tr>

                            @if(!empty($password))
                            <tr>
                                <td style="font-weight:bold;">Password</td>
                                <td>{{ $password }}</td>
                            </tr>
                            @endif

                        </table>

                        <p style="margin-top:20px; font-size:14px; color:#555;">
                            You can now log in using your registered email address.
                        </p>

                        <!-- Button -->
                        <div style="text-align:center; margin-top:25px;">
                            <a href="{{ url('/') }}" 
                               style="background:#28a745; color:#ffffff; text-decoration:none; padding:10px 20px; border-radius:5px; font-size:14px; display:inline-block;">
                                Login to Your Account
                            </a>
                        </div>

                        <p style="margin-top:25px; font-size:13px; color:#888;">
                            If you did not request this action, please ignore this email.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr style="background:#f1f1f1;">
                    <td style="padding:15px; text-align:center; font-size:12px; color:#777;">
                        © {{ date('Y') }} Grabit. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>