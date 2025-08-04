<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }

        .footer {
            background-color: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }

        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }

        .value {
            color: #212529;
        }

        .message-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📧 New Contact Message</h1>
        <p>You have received a new message from your portfolio website</p>
    </div>

    <div class="content">
        <div class="info-row">
            <div class="label">👤 Name:</div>
            <div class="value">{{ $contact->name }}</div>
        </div>

        <div class="info-row">
            <div class="label">✉️ Email:</div>
            <div class="value">
                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
            </div>
        </div>

        @if ($contact->phone)
            <div class="info-row">
                <div class="label">📞 Phone:</div>
                <div class="value">
                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                </div>
            </div>
        @endif

        <div class="message-box">
            <div class="label">💬 Message:</div>
            <div class="value">{{ nl2br(e($contact->message)) }}</div>
        </div>

        <div class="info-row">
            <div class="label">⏰ Received At:</div>
            <div class="value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>You can reply to this message directly from your admin panel.</p>
        <p>This email was sent automatically from your portfolio contact form.</p>
    </div>
</body>

</html>
