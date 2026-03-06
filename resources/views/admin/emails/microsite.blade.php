<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background-color:#f4f6f8; padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:#f98000; color:#ffffff; padding:20px;">
            <h2 style="margin:0;">{{ $micrositeName }}</h2>

            <p style="margin:8px 0 0;">
                @if($isSaleStarted)
                    🚀 <strong>Sale is now LIVE!</strong>
                @else
                    ⏳ <strong>Sale starts on {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
                @endif
            </p>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:25px; color:#333;">

            @if($type === 'create')

                <p>Your credentials for {{ $micrositeName }}:</p>

                <p><strong>Email:</strong> {{ $email }}</p>

                <p><strong>Password:</strong> {{ $password }}</p>

            @elseif($type === 'update')

                <p>Your microsite details have been updated successfully.</p>
                <p><strong>Email:</strong> {{ $email }}</p>

                <p><strong>Password:</strong> {{ $password }}</p>

            @elseif($type === 'url')

                <p>You have been granted access to a microsite.</p>

            @endif

            <!-- BUTTON -->
            <div style="margin:25px 0; text-align:center;">
                <a href="{{ $url }}"
                   style="background:#f98000; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:6px; display:inline-block;">
                    Access Microsite
                </a>
            </div>

            <!-- FALLBACK LINK -->
            {{-- <p style="font-size:12px; color:#777;">
                If the button doesn’t work, use this link:<br>
                <a href="{{ $url }}">{{ $url }}</a>
            </p> --}}

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
            © {{ date('Y') }} Your Company. All rights reserved.
        </td>
    </tr>

</table>

</body>
</html>