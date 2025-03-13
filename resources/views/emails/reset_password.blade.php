<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f6f9;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #343a40; padding: 20px;">
                            <img src="{{ asset('images/aside-mini-leavesync.png') }}" alt="Company Logo" width="120" style="display: block;">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px; text-align: left;">
                            <h2 style="color: #dc3545; margin-top: 0;">Hello, {{ $name }}</h2>
                            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                                Your password has been reset successfully. Below are your new login details:
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" border="0" style="background-color: #f8f9fa; border-left: 5px solid #dc3545; margin: 20px 0; padding: 15px;">
                                <tr>
                                    <td><strong>Email:</strong> {{ $email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>New Password:</strong> {{ $password }}</td>
                                </tr>
                            </table>

                            <p style="color: #333; font-size: 16px;">
                                Please log in using the button below and change your password immediately for security reasons.
                            </p>

                            <p style="color: #777; font-size: 14px;">
                                If you didn't request this password reset, please contact support immediately.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #343a40; color: #ffffff; padding: 15px; font-size: 14px;">
                            &copy; {{ date('Y') }} Enetech Sdn. Bhd. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
