<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            width: 100% !important;
        }
        .wrapper {
            background-color: #f8fafc;
            margin: 0;
            padding: 20px 0;
            width: 100%;
        }
        .content {
            margin: 0 auto;
            max-width: 600px;
            padding: 0;
            width: 100%;
        }
        .header {
            padding: 25px 0;
            text-align: center;
        }
        .header a {
            color: #d13b59; /* Brand primary color */
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        .body {
            background-color: #ffffff;
            border-radius: 8px;
            border-top: 4px solid #d13b59;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin: 0 auto;
            padding: 32px;
            width: 100%;
            box-sizing: border-box;
        }
        .footer {
            margin: 0 auto;
            padding: 32px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
        .footer p {
            color: #64748b;
            font-size: 14px;
            text-align: center;
        }
        
        /* Internal Typography */
        h1 {
            color: #0f172a;
            font-size: 20px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }
        p {
            font-size: 16px;
            line-height: 1.6em;
            margin-top: 0;
            text-align: left;
        }
        
        /* Buttons inside body */
        .btn {
            background-color: #d13b59;
            border-radius: 6px;
            color: #ffffff;
            display: inline-block;
            font-weight: bold;
            text-decoration: none;
            padding: 12px 24px;
            margin: 16px 0;
        }
        
        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 20px 0;
        }

        @media only screen and (max-width: 600px) {
            .content {
                width: 100% !important;
            }
            .body {
                padding: 20px !important;
            }
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <a href="{{ config('app.frontend_url') }}">
                                {{ config('app.name') }}
                            </a>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td class="body">
                            {!! $body !!}
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table class="footer" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td>
                                        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
