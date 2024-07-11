<?php
    session_start();

    include("php1/config.php");
    if (!isset($_SESSION['valid'])) {
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newstyle.css">
    <title>Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Logo</p>
        </div>

        <div class="right-links">
            <?php
            $id = $_SESSION['id'];

            // Prepare a select statement
            $stmt = $con->prepare("SELECT Username, Email, Age, Id FROM users WHERE Id = ?");
            $stmt->bind_param("i", $id);

            // Execute the statement
            $stmt->execute();

            // Bind result variables
            $stmt->bind_result($res_Uname, $res_Email, $res_Age, $res_id);

            // Fetch the result
            $stmt->fetch();

            // Close the statement
            $stmt->close();

            echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
            ?>

            <a href="php1/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                </div>
                <div class="box">
                    <p>Your email is <b><?php echo $res_Email ?></b>.</p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>And you are <b><?php echo $res_Age ?> years old</b>.</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
