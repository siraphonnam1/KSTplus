<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KST Export Data</title>
    <link rel="icon" href="/img/logoiddrives.png" type="image/icon type">

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 18px;
            /* font-family: 'THSarabunNew', sans-serif; */
        }

        header > #header-agency {
            text-align: center;
            border: 1px solid rgb(172, 172, 172);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div id="header-agency">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logoiddrives.png'))) }}" alt="" width="80">
                <p>สวัสดี adison</p>
            </div>
        </header>
    </div>
</body>
</html>
