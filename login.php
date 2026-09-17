<?php
session_start();
include '../includes/config.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple hardcoded login (you can replace with database authentication)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Savor Flavor</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .login-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .login-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .error-message {
            background: #e74c3c;
            color: white;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .login-info {
            text-align: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        
        .login-info h4 {
            margin: 0 0 0.5rem 0;
            color: #2c3e50;
        }
        
        .login-info p {
            margin: 0;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-header">
                <h1>Admin Login</h1>
                <p>Savor Flavor Restaurant Management</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="admin" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="admin123" required>
                </div>
                
                <button type="submit" class="login-btn">Login to Dashboard</button>
            </form>
            
            <div class="login-info">
                <h4>Demo Credentials</h4>
                <p><strong>Username:</strong> admin</p>
                <p><strong>Password:</strong> admin123</p>
            </div>
            
            <div style="text-align: center; margin-top: 1rem;">
                <a href="../index.php" style="color: #3498db; text-decoration: none;">
                    ← Back to Main Website
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Add loading effect to login button
            const loginBtn = document.querySelector('.login-btn');
            const loginForm = document.querySelector('form');
            
            loginForm.addEventListener('submit', function() {
                loginBtn.innerHTML = 'Logging in...';
                loginBtn.disabled = true;
            });
        });
    </script>
</body>
</html>