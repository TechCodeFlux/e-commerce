<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome - Club Member</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f6f8; padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    
    <!-- Header -->
    <tr style="background:#0d6efd; color:#ffffff;">
        <td style="padding:20px; text-align:center;">
            <h2 style="margin:0;">Welcome to the Club</h2>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:20px;">
            
            <p>Dear <strong>{{ $memberData['name'] }}</strong>,</p>

            <p>
                Your club member account has been successfully created. Below are your details:
            </p>

            <h4>🔐 Login Details</h4>
            <table width="100%" cellpadding="8">
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $memberData['email'] }}</td>
                </tr>
            </table>

            <h4 style="margin-top:20px;">👤 Personal Details</h4>
            <table width="100%" cellpadding="8">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{ $memberData['name'] }}</td>
                </tr>
                <tr>
                    <td><strong>Contact:</strong></td>
                    <td>{{ $memberData['contact'] }}</td>
                </tr>
            </table>

            <h4 style="margin-top:20px;">📍 Address Details</h4>
            <table width="100%" cellpadding="8">
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>{{ $memberData['address'] }}</td>
                </tr>
                <tr>
                    <td><strong>City:</strong></td>
                    <td>{{ $memberData['city'] }}</td>
                </tr>
                <tr>
                    <td><strong>State:</strong></td>
                    <td>{{ $memberData['state'] }}</td>
                </tr>
                <tr>
                    <td><strong>Zip Code:</strong></td>
                    <td>{{ $memberData['zip_code'] }}</td>
                </tr>
            </table>

            <p style="margin-top:20px;">
                You can now log in using your registered email address.
            </p>

            <p>
                Regards,<br>
                <strong>Club Management Team</strong>
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr style="background:#f1f1f1;">
        <td style="padding:15px; text-align:center; font-size:12px; color:#777;">
            © {{ date('Y') }} Club. All rights reserved.
        </td>
    </tr>

</table>

</body>
</html>