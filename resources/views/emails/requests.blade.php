<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emdad</title>
    <!-- Style -->
    <style>
        body{
            font-size: 14px;
        }
        .logo{
            display: block;
            width: auto;
            max-width: 200px;
            margin: 20px auto;
        }
        .logo img{
            width: auto;
            max-width: 100%;
        }
        .content-wrapper{
            display: block;
            width: 100%;
            max-width: 500px;
            background: #00186a;
            border-radius: 20px;
            color: #fff;
            padding: 30px;
            margin: 20px auto;
            text-align: center;
        }
        a{
            color: #ff9e18;
        }
        .btn{
            background: #ff9e18 !important;
            color: #fff !important;
            border: none;
            border-radius: 20px;
            padding: 6px 15px;
            text-decoration: none !important;
        }
        .footer{
            display: block;
            text-align: center;
            margin: 0 auto;
            color: #aaa;
        }
        .footer > div{
            margin-top: 5px;
        }
    </style>
</head>
<body>
<!-- Content -->
<div class="logo">
    <img src="assets/images/logo.png" alt="">
</div>
<div class="content-wrapper">
    <p>Hello Mr Abdallah</p>
    <p>Thank you for register with us</p>
    <p>your account's username is <a href="#" class="color-main">abdallah</a></p>
    <p>To activate your account click the following link</p>
    <br>
    <a href="mail-template.html" class="btn">Confirm Mail</a>
    <br><br><br><br>
    <h3>Thank you</h3>
    <h4>Emdad team</h4>
    <a href="index.html" class="color-main">Emdad tasder</a>
</div>
<div class="footer">
    <div>sent to <a href="mailto:">abdallah@mail.com</a></div>
    <div>You received this email because you signed up, if you don't want to receive mails any more, <a href="#">unsubscribe here.</a></div>
    <div>All rights reserved to <a href="#">Emdad tasder  © <span id="year"></span></a></div>
</div>
<script>
    // Get current year
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
</body>
</html>
