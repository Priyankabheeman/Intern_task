<?php
    session_start();

    include("php1/config.php");
    if(!isset($_SESSION['valid'])){
        header("Location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newstyle.css">
    <title>Change Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="profile.php">Logo</a> </p>
        </div>

        <div class="right-links">
            <a href="#"></a>
            <a href="php1/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>

    <div class="container">
        <div class="box form-box">
            <?php 
            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                $id = $_SESSION['id'];

                // Prepared statement for updating user details
                $edit_query = $con->prepare("UPDATE users SET Username = ?, Email = ?, Age = ? WHERE Id = ?");
                $edit_query->bind_param("ssii", $username, $email, $age, $id);

                if($edit_query->execute()){
                    echo "<div class='message'>
                          <p>Profile Updated!</p>
                          </div> <br>";
                    echo "<a href='profile.php'><button class='btn'>Go TO Profile</button>";
                } else {
                    echo "<div class='message'>
                          <p>Error occurred while updating profile.</p>
                          </div> <br>";
                }

                $edit_query->close();
            } else {
                $id = $_SESSION['id'];

                // Prepared statement for selecting user details
                $query = $con->prepare("SELECT Username, Email, Age FROM users WHERE Id = ?");
                $query->bind_param("i", $id);
                $query->execute();
                $query->bind_result($res_Uname, $res_Email, $res_Age);
                $query->fetch();
                $query->close();
            ?>
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>

</body>
</html>
