<!DOCTYPE html>
<html>
<head>
    <title>Leave History PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Leave History</h2>
    <table>
        <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days Taken</th>
                <th>Leave Type</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRequests as $leave)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>
                    <td>{{ $leave->days_taken ?? '-' }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>{{ ucfirst($leave->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
