<?php include __DIR__.'/../layouts/header.php'; ?>
<?php include __DIR__.'/../../database/connection.php'; ?>

<?php

#delete
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM User WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // echo "alert('User deleted successfully');";
    header('Location: ./dashboard.php');

    
}

$sql = "SELECT * FROM User";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->get_result();

?>

<h2>Admin Dashboard</h2>


<!-- Add User Button -->
<a href="./users/add.php" class="btn btn-primary mb-3">Add User</a>


<!-- TODO: Display a table of users with options to edit or delete -->
<!-- Use Bootstrap table classes -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        
       <?php 
        foreach ($users as $user) : ?>
             <tr>
             <td><?=$user['id']?></td>
             <td><?=$user['username']?></td>
             <td><?=$user['fullname']?></td>
             <td> <?=$user['role_id']?></td>
       
        <!-- TODO: Add edit and delete links with appropriate href values -->
        <td> 
            <a href='./users/edit.php?id=<?=$user['id']?>' class='btn btn-warning'>Edit</a> | 
            <!-- <a href='' class='btn btn-danger'>Delete</a> -->
             <!-- <a href='./users/edit.php?id=< ?=$user['id']?>' class='btn btn-warning'>Edit</a> |  -->
             <form action='./dashboard.php' method='post'>
                 <input type='hidden' name='id' value='<?=$user['id']?>'>
                 <button type='submit' name="submit" value="delete" class='btn btn-danger'>Delete</button>
             </form>
           
        </td>
        </tr>
        
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/../layouts/footer.php'; ?>
