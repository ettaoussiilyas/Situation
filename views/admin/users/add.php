<?php 
    include __DIR__.'/../../layouts/header.php'; 
    include __DIR__.'/../../../database/connection.php';

    

    //update user
    if(isset($_POST['submit'])){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $role_id = $_POST['role'];
        $password = $_POST['password'];
        $sql = "INSERT INTO User VALUES (NULL, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $passwordhashi = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssi", $username, $fullname, $password  ,$role_id);
        $stmt->execute();
        header('Location: ../dashboard.php');
    }




?>

<h2>Add User</h2>

<form method="post" action="">
    <!-- TODO: Add input fields for name and email -->
    <div class="form-group">
        <label for="fullname">fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname" required>
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="username" class="form-control" name="username" id="username" required>
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="username" class="form-control" name="username" id="username" required>
    </div>
    <div class="form-group">
        <label for="password">password:</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>

    <div class="form-group">
       <select name="role" id="role">
        <option default>select role</option>
        <option value="1">admin</option>
        <option value="2">user</option>
       </select>
    </div>

    <!-- TODO: Add submit button -->
    <button type="submit" name="submit" value="add" class="btn btn-primary">Add Employee</button>
</form>

<?php include __DIR__.'/../../layouts/footer.php'; ?>
