<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{env('APP_NAME')}}</title>
    <link rel="shortcut icon"
        href="https://responsivehtmlemail.com/wp-content/uploads/2021/01/responsive-html-email-icon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: white;
        }

        .landing {
            height: 100%;
            width: 100%;
            background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675);
            opacity: 0.95;
        }

        h5 {
            color: white;
        }

        img {
            max-width: 100%;
            transition: transform 0.6s ease;
        }

        img:hover {
            transform: scale(0.99);
            cursor: pointer;
        }

        p {
            font-size: 13px;
            color: white;
        }

        a {
            color: white;
            text-decoration: underline;
        }

        a:hover {
            cursor: pointer;
            color: #4fa6c9;

        }

        .action a {
            background: linear-gradient(98.41deg, #4fa6c9 -22.46%, #6c41b6 82.65%);
            border-radius: 8px;
            display: block;
            padding: 13px;
            margin-top: 35px;
            color: #fff;
            width: 170px;
            font-size: 14px;
            transition: transform 0.6s ease;
            text-decoration: none;
            margin-left: auto;
            margin-right: auto;
        }

        .logo img{
            width: 90px;
        }

        .action img{
            height: 170px;
        }

        .action a:hover {
            transform: scale(1.1);
            cursor: pointer;
        }

        .for-border {
            border-bottom: 1px solid white;
        }

        .social-icon a {
            text-decoration: none;
            margin-right: 15px;
        }

        .social-icon a img{
            width: 15px;
        }
    </style>
</head>

<body class="p-5">
    <!-- Start Landing Page-->
    <div class="landing p-4">
        <div class="container-fluid">
            <div class="row justify-content-center for-border">
                <div class="col-12 text-center">
                    <div class="logo mb-4">
                        <img src="./email-logo.svg" alt="Logo" />
                    </div>
                    <h5 class="mb-3">Hi Aaron Andrews</h5>
                    <p>To complete email verification, please press the button below</p>
                    <div class="action py-4 text-center">
                        <img src="./Frame.svg" alt="Password" />
                        <a href="">Reset Your Password</a>
                    </div>
                    <div class="or">
                        <p>Or verify using this link:</p>
                        <a href=""></a>
                    </div>
                    <div class="for-help">
                        <h5 class="mb-3">Need Help?</h5>
                        <p>
                            Please send any feedback or bug reports <br />
                            to support@smematrimony.com
                        </p>
                    </div>
                    <div class="unsubscribe">
                        <p><a href="">unsubscribe</a> from this list</p>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center pt-4 pb-5">
                <footer>
                    <p>SME Matrimorny. All rights reserved.</p>
                    <div class="social-icon">
                        <a href="">
                            <img src="./FACEBOOK.svg" alt="Facebook">
                        </a>
                        <a href="">
                            <img src="./TWITTER.svg" alt="Twitter">
                        </a>
                        <a href="">
                            <img src="./LINKEDIN.svg" alt="Linkedin">
                        </a>
                        <a href="">
                            <img src="./PINTEREST.svg" alt="Pinterest">
                        </a>
                    </div>
                </footer>
            </div>
        </div>
        <!-- End Landing Page -->
</body>

</html>