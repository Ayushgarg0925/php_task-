<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" ferrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Login in</title>
</head>

<body>



    <div class="content">
        <div class="container  shadow">
            <div class="row">
                
                <div class="col-md-6">
                    <img src="../assets/images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center" style="padding-top: 15vh;">
                        <div class="col-md-8">
                            <!-- <div class="mb-4">
                                <img src="../assets/common_assets/img/Sansoftwares-logo-1.png" alt="Image" class="img-fluid">
                            </div> -->
                            <div class="mb-4">
                                <h3 style="color:#565656;"><i class="fa-solid fa-user" style="color: #ff7600;"> </i> Log In</h3>
                            </div>
                            <form method="post" id='form_id'>
                                <div class="form-group first">
                                    <label for="Email">Email <span id="emailErr" style="color:red;"></span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        style="font-size:15px;color:#565656;">

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password <span id="pwdErr" style="color:red;"></span></label>
                                    <input type="password" class="form-control" style="color:#565656;" id="password" name="password">

                                </div>

                                <input type="button" value="Log In" onclick="login()" class="btn btn-block" style="background-color:#ff7600; color:white;">

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/ajax.js"></script>

</body>

</html>