<?php
    include __DIR__.'/../../database/connection.php';
    $erreurs = [];
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username)){
            $erreurs['username'] = "Username is required";
        }
        if(empty($password)){
            $erreurs['password'] = "Password is required";
        }

        if(empty($erreurs)){
            // First get the user by username only
            $sql = "SELECT * FROM User WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
                $user = $result->fetch_assoc();
               
                if(password_verify($password, $user['password'])){
                    session_start();
                    $_SESSION['username'] = $user;
                    if($user['role_id'] == 1){
                        header('Location: ./../admin/dashboard.php');
                        exit();
                    } else {
                        header('Location: ./../index.php');
                        exit();
                    }
                } else {
                    $erreurs['login'] = "Invalid username or password";
                }
            } else {
                $erreurs['login'] = "Invalid username or password";
            }
        }
    }
?>


<?php include __DIR__.'/../layouts/header.php'; ?>

<h2>Login</h2>
<form method="post" action="./login.php">
    <?php if(!empty($erreurs) && isset($erreurs['login'])): ?> 
        <div class="alert alert-danger"><?php echo $erreurs['login']; ?></div>
    <?php endif; ?>
    
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username" >
        <?php if(!empty($erreurs) && isset($erreurs['username'])): ?> 
            <span class="erreur"><?php echo $erreurs['username']; ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password" >
        <?php if(!empty($erreurs) && isset($erreurs['password'])): ?> 
            <span class="erreur"><?php echo $erreurs['password']; ?></span>
        <?php endif; ?>
    </div>
    
    <button type="submit" name="submit" value="login" class="btn btn-primary">Login</button>
</form>

<?php include __DIR__.'/../layouts/footer.php'; ?>