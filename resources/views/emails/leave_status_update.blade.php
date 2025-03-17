<!DOCTYPE html>
<html>
<head>
    <title>Your Leave Request {{ ucfirst($leaveRequest->status) }}</title>
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
                            <h2 style="color: #dc3545; margin-top: 0;">Your Leave Request Has Been {{ ucfirst($leaveRequest->status) }}</h2>
                            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                                Below are the details of your leave request:
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" border="0" style="background-color: #f8f9fa; border-left: 5px solid #dc3545; margin: 20px 0; padding: 15px;">
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
                                    <td><strong>Status:</strong> {{ ucfirst($leaveRequest->status) }}</td>
                                </tr>
                            </table>

                            @if($leaveRequest->status == 'approved')
                            <p style="color: #28a745; font-size: 16px;">
                                Congratulations! Your leave request has been approved. Please ensure your responsibilities are managed accordingly.
                            </p>
                            @elseif($leaveRequest->status == 'rejected')
                            <p style="color: #dc3545; font-size: 16px;">
                                Unfortunately, your leave request has been rejected. Please contact HR if you need more information.
                            </p>
                            @endif

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
