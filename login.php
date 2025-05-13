<?php
session_start();
require_once 'db.php';

$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from form
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password, name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct, create session
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                
                // Redirect to homepage
                header("Location: index.html");
                exit;
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CarZi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="car.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .login-container h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #FF6B35;
        }
        
        .login-form .form-group {
            margin-bottom: 15px;
        }
        
        .login-form .form-control {
            padding: 10px;
            border-radius: 5px;
        }
        
        .login-form .btn {
            width: 100%;
            padding: 10px;
            background-color: #FF6B35;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .login-form .btn:hover {
            background-color: #e55a2b;
        }
        
        .login-links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 14px;
        }
        
        .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .social-login .btn {
            flex: 1;
            margin: 0 5px;
        }
        
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"><strong><span>CAR</span>ZI</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-space-between justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.html#home">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.html#feature">Features</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.html#review">Review</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.html#faq">FAQ</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.html#aboutus">AboutUS</a>
                    </li>
                </ul>
                <div class="btn">
                    <button class="nav_button me-3" onclick="window.location.href='login.php'">LogIn</button>
                    <button class="nav_button" onclick="window.location.href='register.php'">SignIn</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <h3>USER LOGIN</h3>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="login-links">
                <a href="forgot-password.php">Forgot Your Password?</a>
            </div>
            <button type="submit" class="btn">Login now</button>
            
            <div class="text-center mt-3">
                <p>or login with</p>
            </div>
            
            <div class="social-login">
                <button type="button" class="btn btn-outline-secondary">Google</button>
                <button type="button" class="btn btn-outline-primary">Facebook</button>
            </div>
            
            <div class="text-center mt-3">
                <p>Don't have account? <a href="register.php">Create one</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>