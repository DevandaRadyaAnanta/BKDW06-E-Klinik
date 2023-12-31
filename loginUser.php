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
                <img src="images/logo.png" class="img-fluid" alt="image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <div>
                    <h2 class="mb-5" style="color: #0047AB;">Login</h2>
                </div>
                <form method="POST" action="index.php?page=loginUser">
                    <?php
                    if (isset($error)) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                    ?>
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="inputUsername">Username</label>
                        <input type="text" id="inputUsername" name="username" required class="form-control form-control-lg" placeholder="Masukkan username anda" />
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="inputPassword">Password</label>
                        <input type="password" id="inputPassword" name="password" required class="form-control form-control-lg" placeholder="Masukkan password anda" />
                    </div>
                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                            <label class="form-check-label" for="form1Example3"> Remember me </label>
                        </div>
                        <a href="#!">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-lg btn-block w-100" style="background-color: #0047AB; color: #FFFFFF;">Sign In</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</section>
