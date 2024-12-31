<?php 
    include __DIR__.'/../../layouts/header.php'; 
    include __DIR__.'/../../../database/connection.php';

    //get id from url
    $id = $_GET['id'];
    
    //query to get data of user
    $sql = "SELECT * FROM User WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    // $stmt->close();

    //update user
    if(isset($_POST['submit'])){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $role_id = $_POST['role'];
        $sql = "UPDATE User SET fullname = ?, username = ?, role_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $fullname, $username, $role_id, $id);
        $stmt->execute();
        header('Location: ../dashboard.php');
    }




?>

<h2>Edit User</h2>

<form method="post" action="">
    <!-- TODO: Add input fields for name and email -->
    <div class="form-group">
        <label for="fullname">fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname" required value="<?=$user['fullname']?>">
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="username" class="form-control" name="username" id="username" required value="<?=$user['username']?>">
    </div>

    <div class="form-group">
       <select name="role" id="role">
        <option default>select role</option>
        <option value="1">Admin</option>
        <option value="2">User</option>
       </select>
    </div>

    <!-- TODO: Add submit button -->
    <button type="submit" name="submit" value="update" class="btn btn-primary">Save Infos</button>
</form>

<?php include __DIR__.'/../../layouts/footer.php'; ?>
