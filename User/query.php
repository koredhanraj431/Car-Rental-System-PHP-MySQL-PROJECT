<?php
session_start();
include('Includes/server.php');
if (!isset($_SESSION['username'])) {
  echo "<script type = \"text/javascript\">
                  alert(\"You must login first\");
                window.location = (\"index.php\")
      </script>";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
  <link rel="icon" href="images/favicon-16x16.png">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>Queries</title>
  <style media="screen">
    .image {
      width: 300px;
      margin: auto;
      min-height: 200px;
      border: 2px solid black;
      border-radius: 5px;
      margin-top: 20px;
      display: flex;
      justify-content: center;
    }

    label {
      font-size: 20px;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      color: brown;
    }

    input,
    select {
      font-size: 18px;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    .formcontainer {
      width: 50%;
      margin-top: 25px;
      margin-left: 32%;
      font-size: 20px;
    }

    .queries {
      width: 75%;
      margin: 20px auto;
      margin-bottom: 20px;
    }

    td {
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
  </style>
</head>

<body>
  <!-- navbar -->
  <?php
  session_start();
  include('Includes/header.php');

  if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $qtype = $_POST['type'];
    $qmsg = $_POST['ask'];

    $qry = "INSERT INTO queries (username, qr_type,qr_answer, qr_message,status) VALUES('$username','$qtype',' ','$qmsg','Open')";
    mysqli_query($db, $qry);

    echo "<script type = \"text/javascript\">
                  alert(\"Your Query has been submitted\");
                window.location = (\"query.php\")
      </script>";
  }
  ?>
  <h1 style="text-align:center; color:Brown; margin-top: 100px; font-weight:bold; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> Ask your Queries here!</h1>
  <h4 style="text-align:center; color:black; margin-top: 4px; font-weight:bold; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> We will try to answer them as soon as possible.</h4>

  <img class="image" src="images/queries.png" alt="query" style="border-radius: 6px; height: 140px; width: 250px;">

  <form action="" method="POST" class="formcontainer">
    <div class="form-group">
      <div class="col-md-8">
        <div class="ui-select">
          <label>Type of query : </label>
          <select id="query_type" class="form-control" name="type" required>
            <option value="" selected>Select Query </option>
            <option value="Bookings">Bookings</option>
            <option value="About Cars">About Cars</option>
            <option value="About charges and fares">About charges and fares</option>
            <option value="About Booking-Cancellation">About Booking-cancellation</option>
            <option value="Regarding Refund">Regarding Refund</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Ask you query : </label>
      <div class="col-md-8">
        <input class="form-control" type="text" name="ask" placeholder="Ask your query!" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label"></label>
      <div class="col-md-8 mx-auto">
        <input type="submit" class="btn btn-dark" name="submit" value="Ask Query"><br><br>
      </div>
    </div>
  </form>
  <div class="queries">
    <?php
    $username = $_SESSION['username'];
    $qry = "SELECT * FROM queries WHERE username='$username'";
    $res = $db->query($qry);
    if (mysqli_num_rows($res) > 0) { ?>

      <hr>
      <h2 style="text-align:center; color:maroon;">Your Submitted Queries!</h2>
      <hr>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th class="text-center" style="vertical-align:middle;" align="center">Registered Query ID</th>
            <th class="text-center" style="vertical-align:middle;" align="center">Query type</th>
            <th class="text-center" style="vertical-align:middle;" align="center">Query </th>
            <th class="text-center" style="vertical-align:middle;" align="center">Answer </th>
            <th class="text-center" style="vertical-align:middle;" align="center">Status</th>
          </tr>
        </thead>

        <?php
        $username = $_SESSION['username'];
        $qry = "SELECT * FROM queries WHERE username='$username'";
        $res = $db->query($qry);
        while ($rws = $res->fetch_assoc()) {
        ?>
          <tr>
            <td style="vertical-align:middle;" align="center"><?php echo $rws['id']; ?></td>
            <td style="vertical-align:middle;" align="center"><?php echo $rws['qr_type']; ?></td>
            <td style="vertical-align:middle;" align="center"><?php echo $rws['qr_message']; ?></td>
            <?php if ($rws['status'] == 'Open') { ?>
              <td></td>
              <td class="text-danger" style="vertical-align:middle; font-weight: bold;" align="center"><?php echo $rws['status']; ?></td>
            <?php } else {
            ?>
              <td style="vertical-align:middle;" align="center"><?php echo $rws['qr_answer']; ?></td>
              <td class="text-success" style="vertical-align:middle; font-weight: bold;" align="center"><?php echo $rws['status']; ?></td>
            <?php
            } ?>
          </tr>
        <?php
        }
        ?>
      </table>
    <?php
    } else {
    ?>
      <div class="text-danger">
        <h2 style="text-align:center; color:maroon;">You have not submitted any queries yet!</h2>
      </div>
    <?php
    } ?>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>