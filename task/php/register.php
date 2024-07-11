<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newstyle.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php
        session_start();
        include("php1/config.php");

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = $_POST['password'];

            // Verifying the unique email
            $verify_query = $con->prepare("SELECT Email FROM users WHERE Email = ?");
            $verify_query->bind_param("s", $email);
            $verify_query->execute();
            $verify_query->store_result();

            if ($verify_query->num_rows != 0) {
                echo "<div class='message'>
                          <p>This email is used, Try another one Please!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
            } else {
                $verify_query->close();

                // Prepared statement for inserting user details
                $insert_query = $con->prepare("INSERT INTO users (Username, Email, Age, Password) VALUES (?, ?, ?, ?)");
                $insert_query->bind_param("ssis", $username, $email, $age, $password);

                if ($insert_query->execute()) {
                    echo "<div class='message'>
                              <p>Registration successful!</p>
                          </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button></a>";
                } else {
                    echo "<div class='message'>
                              <p>Error occurred during registration.</p>
                          </div> <br>";
                }

                $insert_query->close();
            }
        } else {
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>

                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        <?php } ?>
        </div>
    </div>
</body>
</html>
