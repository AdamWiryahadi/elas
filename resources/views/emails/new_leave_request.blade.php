<!DOCTYPE html>
<html>
<head>
    <title>New Leave Request Submitted</title>
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
                            <h2 style="color: #dc3545; margin-top: 0;">New Leave Request Submitted</h2>
                            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                                A new leave request has been submitted. Please find the details below:
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" border="0" style="background-color: #f8f9fa; border-left: 5px solid #dc3545; margin: 20px 0; padding: 15px;">
                                <tr>
                                    <td><strong>User:</strong> {{ $leaveRequest->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Leave Type:</strong> {{ $leaveRequest->leave_type }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>End Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Reason:</strong> {{ $leaveRequest->reason }}</td>
                                </tr>
                            </table>

                            <p style="color: #333; font-size: 16px;">
                                Kindly review and take the necessary action in the system.
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
