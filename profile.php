<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet"  href="Home/CSS/reset.css">
    <link rel="stylesheet"  href="Home/CSS/style.css">
    <script>
        function redirectToSendDocument() {
            window.location.href = "senddocument.php";
        }
        function redirectToGetDocument() {
            window.location.href = "getdocument.php";
        }
    </script>
</head>
<body>
    <header class="header">
        <div class="wrapper">
                <div class="header_wrapper">

                    <div class="header_logo"> 
                        <a href="/" class="header_logo_link">
                            <img src="Home/Images/2.png" alt="Logotyp" class="header_logo_picture">
                        </a>
                    </div>
                

                     <nav class="header__nav">
                         <ul class="header__list">
                             <li class="header__items"><a href="" class="header__links">Menu</a></li>
                             <li class="header__items"><a href="" class="header__links">Online transaction</a></li>
                             <li class="header__items"><a href="javascript:void(0)" onclick="redirectToSendDocument()" class="header__links">Send documents</a></li>
                             <li class="header__items"><a href="javascript:void(0)" onclick="redirectToGetDocument()" class="header__links">Get documents</a></li>
                         </ul>
                     </nav>

                     <form>
                         <a href="vendor/logout.php" class="logout">Exite</a>
                     </form>
                 
                </div>

            </header>

            <!--main-->

            <main class="main">
                <section class="intro">
                    <img src="Home/1.jpg" alt="Photo" class="intro">
                    <img src="Home/Images/cloud.png" class="cloud">
                    <img src="Home/Images/cloud.png" class="cloud2">
                </section>
            </main>

            <div class="post_wrapper">

                <div class="post_post" data-number="01">
                    <h3 class="post_title">About our team</h3>

                    <p class="post_subtitle">Our team consists of 3 people who watch and monitor their product every day, trying to improve it day by day</p>

                    <img class="post_img" src="Home/Images/1.jpg" alt="">

                </div>

                <div class="post_post" data-number="02">
                    <h3 class="post_title">About our DApp</h3>

                    <p class="post_subtitle">
                    Our application is used for file sharing and serves as a guarantee that your transaction will go through without a single deception</p>

                    <img class="post_img" src="Home/Images/2.jpg" alt="">

                </div>

                <div class="post_post" data-number="03">
                    <h3 class="post_title">How to join our team</h3>

                    <p class="post_subtitle">To do this, write to us at the email address specified in the contact details of the site</p>

                    <img class="post_img" src="Home/Images/3.jpg" alt="">

                </div>

        </div>

    </div>
</body>
</html>
