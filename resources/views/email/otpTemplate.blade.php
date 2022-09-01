<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
    <style>
        .mail-box{
            width: 600px;
            margin: auto;
            font-family: sans-serif;
            text-align: center;
            color: #808080;
        }
        .mail-header h2{
            margin: 0;
            color: white;
            font-size: 38px;
        }
        .mail-body{
            padding: 20px 20px;
            border: 1px solid #c5c5c5;
            border-top: none;
        }
        .mail-body h3{
            color: #F58823;
            margin-bottom: 20px;
        }
        .mail-body table{
            width: 60%;
            margin: auto;
            /* font-size: 18px; */
        }
        .order-details-p{
            padding: 25px 0px;
            margin-top: 20px;
        }
        .order-details-p p{
            margin: 0;
            line-height: 1.5;
            font-size: 15px;
        }
        .footer-p{
            font-size: 18px;
        }
        @media screen and (max-width: 650px) {
            .mail-box{
                width: 100%;
            }
        }
        @media screen and (max-width: 576px) {
            .mail-body table{
                width: 100%;
            }
            .mail-header h2{
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
<section class="mail-sec">
    <div class="mail-box">
        <div class="mail-body">
            <h1>This is private information do not share</h1>
            <div class="order-details-p">
                <p>Your Email ID: {{ $detail['email'] }}</p>
                <p>OTP: {{ $detail['otp'] }}</p>
            </div>
            <p class="footer-p">Thank you!</p>
        </div>
    </div>
</section>
</body>
</html>
