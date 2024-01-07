<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "User tidak ditemukan";
    }
}
?>

<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="logo.png" class="img-fluid" alt="image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <div>
                    <h2 class="mb-5" style="color: #0047AB;">Login Admin</h2>
                </div>
                <form method="POST" action="index.php?page=loginUser">
                    <?php
                    if (isset($error)) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                    ?>
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                          <input type="text" id="inputUsername" name="username" class="form-control form-control-lg" placeholder="Masukkan username anda"/>
                          <label class="form-label" for="inputUsername">Username</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="inputPassword" name="password" class="form-control form-control-lg" placeholder="Masukkan password anda"/>
                        <label class="form-label" for="inputPassword">Password</label>
                    </div>

                    <div>
                        <p href="#!">Don't have an account?</a></p>
                        <p href="#!">Forgot password?</a></p> 
                    </div>

                    <button type="submit" class="btn btn-lg btn-block w-100" style="background-color: #0047AB; color: #FFFFFF;">Sign In</button>

                </form>
            </div>
        </div>
    </div>
</section>