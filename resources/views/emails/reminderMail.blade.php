<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reminder Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin: 0 auto;
        }
        .user-details {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="logo" src="{{asset('assets/images/starbuck-logo-black.png')}}" alt="logo" style="width: 25%" />
        <h2>Reminder For Document Expiration</h2>
        <p>Hello {{ $user->name }},</p>
        <p>This is a friendly reminder for your document expiration:</p>
        <p><strong>Document Name:</strong> {{ $user->document->title }}</p>
        <p><strong>Expiration Date:</strong> {{ $user->document->reminder }}</p>
        <p>Contact Admin for Details!</p>
        <p>Thank you for choosing our service.</p>
        <p>Best Regards,<br>
        <p class="str"><strong>Starbuck Excavation Pty Ltd</strong></p>
        <p><strong>15/882-900 Cooper Street, Somerton VIC 3062</strong></p>
        <strong>www.starbuckexcavations.com.au</strong>
        <p>ABN 51 253 288 279</p>
        <p>ACN 169 208 780</p></p>
    </div>
</body>
</html>
