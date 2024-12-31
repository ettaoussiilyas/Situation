

<?php
    include __DIR__.'/../../database/connection.php';
    $erreurs = [];
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];

        if(empty($username)){
            $erreurs['username'] = "Username is required";
        }
        if(empty($password)){
            $erreurs['password'] = "Password is required";
        }
        if(empty($fullname)){
            $erreurs['fullname'] = "Fullname is required";
        }

        if(empty($erreurs)){
           
            $sql = "SELECT * FROM User WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
                $erreurs['username'] = "Username already exists";
            }else{
                $sql = "INSERT INTO User (username, fullname, password, role_id, created_at) VALUES (?, ?, ?, 2, NOW())";
                $passwordhashi = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $fullname, $passwordhashi);
                $stmt->execute();
                header('Location: ./login.php');
                exit();
            }
        }

    }
?>
<?php include __DIR__.'/../layouts/header.php'; ?>

<h2>Register</h2>

<form method="post" action="./register.php">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username" >
        <?php if(!empty($erreurs) && isset($erreurs['username'])): ?> 
            <span class="erreur"><?php echo $erreurs['username']; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="fullname">Fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname" >
        <?php if(!empty($erreurs) && isset($erreurs['fullname'])):?> 
            <span class="erreur"><?php echo $erreurs['fullname']; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password" >
        <?php if(!empty($erreurs) && isset($erreurs['password'])): ?> 
            <span class="erreur"><?php echo $erreurs['password']; ?></span>
        <?php endif; ?>
    </div>

    <button type="submit" name="submit" value="register" class="btn btn-success">Register</button>
</form>

<?php include __DIR__.'/../layouts/footer.php'; ?>
