<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        {{ $type === 'create' ? 'Welcome - Club Member' : 'Club Member Updated' }}
    </title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
<tr>
<td align="center">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:8px; overflow:hidden;">

    <!-- Header -->
    <tr style="background:#fd8301;">
        <td style="padding:20px; text-align:center; color:#ffffff;">
            <h2 style="margin:0;">
                {{ $type === 'create' ? 'Welcome to the Club' : 'Account Updated' }}
            </h2>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:25px;">

            <p style="margin-top:0;">
                Dear <strong>{{ $memberData['name'] ?? 'Member' }}</strong>,
            </p>

            @if($type === 'create')
                <p>Your club member account has been successfully created. Below are your details:</p>
            @else
                <p>Your club member account details have been successfully updated. Below is your latest information:</p>
            @endif

            <!-- Login Details -->
            <h4 style="margin-bottom:10px;">🔐 Login Details</h4>
            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e0e0e0; border-radius:5px;">
                <tr style="background:#f9fafb;">
                    <td width="35%" style="border-bottom:1px solid #e0e0e0;"><strong>Email</strong></td>
                    <td style="border-bottom:1px solid #e0e0e0;">
                        {{ $memberData['email'] ?? '' }}
                    </td>
                </tr>
            </table>

            <!-- Personal Details -->
            <h4 style="margin:20px 0 10px;">👤 Personal Details</h4>
            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e0e0e0; border-radius:5px;">
                <tr>
                    <td width="35%" style="border-bottom:1px solid #e0e0e0;"><strong>Name</strong></td>
                    <td style="border-bottom:1px solid #e0e0e0;">
                        {{ $memberData['name'] ?? '' }}
                    </td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td><strong>Contact</strong></td>
                    <td>{{ $memberData['contact'] ?? '' }}</td>
                </tr>
            </table>

            <!-- Address Details -->
            <h4 style="margin:20px 0 10px;">📍 Address Details</h4>
            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e0e0e0; border-radius:5px;">
                <tr>
                    <td width="35%" style="border-bottom:1px solid #e0e0e0;"><strong>Address</strong></td>
                    <td style="border-bottom:1px solid #e0e0e0;">
                        {{ $memberData['address'] ?? '' }}
                    </td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td style="border-bottom:1px solid #e0e0e0;"><strong>City</strong></td>
                    <td style="border-bottom:1px solid #e0e0e0;">
                        {{ $memberData['city'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #e0e0e0;"><strong>State</strong></td>
                    <td style="border-bottom:1px solid #e0e0e0;">
                        {{ $memberData['state'] ?? '' }}
                    </td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td><strong>Zip Code</strong></td>
                    <td>{{ $memberData['zip_code'] ?? '' }}</td>
                </tr>
            </table>

            <p style="margin-top:20px;">
                You can log in using your registered email address.
            </p>

            <!-- Button -->
            <div style="text-align:center; margin-top:25px;">
                <a href="{{ url('/') }}" 
                   style="background:#28a745; color:#ffffff; text-decoration:none; padding:10px 20px; border-radius:5px; font-size:14px; display:inline-block;">
                    Login to Your Account
                </a>
            </div>

            <p style="margin-top:25px; margin-bottom:0;">
                Regards,<br>
                <strong>Club Management Team</strong>
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