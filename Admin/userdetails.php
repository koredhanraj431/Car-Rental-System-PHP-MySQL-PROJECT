<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>User Details</title>
    <style>
        .userdetails {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
            margin-bottom: 10px;
        }

        h4 {
            color: brown;
            font-weight: bold;
            margin-left: 50px;
        }

        .container {
            border: 2px solid brown;
            border-radius: 3em;
            display: flex;
            justify-content: space-around;
            padding: 10px;
            margin-top: 20px;
        }

        .items {
            margin: 4px;
            padding: 10px;
            align-items: center;
        }

        .buttons {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php
    session_start();

    include('../Includes/config.php');
    if (strlen($_SESSION['uname']) == 0) {
        header('location:index.php');
    } else {
        include('includes/navbar.php');
    }
    ?>

    <?php
    if (isset($_POST['user_details'])) {
        //User details
        $id = $_POST['user_details'];
        $u_details = "SELECT id,username,email FROM users WHERE id='$id'";
        $u_res = $dbh->query($u_details);
        $rws2 = $u_res->fetch_assoc();
        //Profile details
        $user_id = $rws2['id'];
        $userprofile = "SELECT * FROM userprofile WHERE id='$user_id'";
        $prof_res = $dbh->query($userprofile);
        $rws3 = $prof_res->fetch_assoc();
    }
    ?>
    <div class="container userdetails">

        <div style="margin-top: 20px;">
            <div class="items">
                <h3>User Details : </h3>
                <div style="margin-top: 20px;">
                    <div>
                        <p>User ID : <?php echo $rws2['id']; ?></p>
                        <p>Username : <?php echo $rws2['username']; ?></p>
                        <p>Email : <?php echo $rws2['email']; ?></p>

                    </div>
                </div>
                <div style="margin-top: 50px;">
                    <h3>Profile Details : </h3>
                    <?php if ($rws3) { ?>
                        <div style="margin-top: 10px;">
                            <p>Name : <?php echo $rws3['fname'], " ", $rws3['lname']; ?></p>
                            <p>Date-of-Birth : <?php echo $rws3['dob']; ?></p>
                            <p>Mobile Number : <?php echo $rws3['mob']; ?></p>
                            <p>Address : <?php echo $rws3['address']; ?></p>
                            <p>City : <?php echo $rws3['city']; ?></p>
                            <p>Country : <?php echo $rws3['country']; ?></p>
                        </div>
                    <?php } else { ?>
                        <h4>User has not completed his profile.</h4>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div><a href="admin.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px; float:right;">Go Back</a></div>

    </div>
</body>

</html>