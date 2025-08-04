<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Message</title>
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
            background-color: #28a745;
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

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #495057;
        }

        .original-message {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #6c757d;
        }

        .reply-message {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
        }

        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>💬 Thank You for Contacting Us!</h1>
        <p>We've received your message and here's our response</p>
    </div>

    <div class="content">
        <div class="greeting">
            Hello {{ $contact->name }},
        </div>

        <p>Thank you for reaching out to us. We've carefully reviewed your message and are pleased to provide you with
            the following response:</p>

        <div class="reply-message">
            <div class="label">📝 Our Response:</div>
            <div>{{ nl2br(e($adminReply)) }}</div>
        </div>

        <div class="original-message">
            <div class="label">📨 Your Original Message:</div>
            <div><strong>Subject:</strong> Contact from {{ $contact->name }}</div>
            <div><strong>Sent:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
            <div style="margin-top: 10px;">{{ nl2br(e($contact->message)) }}</div>
        </div>

        <p>If you have any additional questions or need further clarification, please don't hesitate to contact us
            again.</p>

        <div class="signature">
            <p>Best regards,<br>
                <strong>The Portfolio Team</strong>
            </p>

            <p style="font-size: 14px; color: #6c757d;">
                📧 You can reply directly to this email<br>
                📞 Phone: {{ $contact->phone ?? 'Available on request' }}<br>
                🌐 Website: {{ config('app.url') }}
            </p>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated response to your contact form submission.</p>
        <p>We appreciate your interest and look forward to connecting with you!</p>
    </div>
</body>

</html>
