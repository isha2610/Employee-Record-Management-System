<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "employee_crm";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// die if the connection was not successful

if (!$conn) {
  die("Sorry! we failed to connect. " . mysqli_connect_error());
} // else {
//   echo "Connection was Successful!";
// }

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `employee details` WHERE `employee details`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if($result) echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>RECORD DELETED SUCCESSFULLY!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">x</span></button></div>';
      
    else echo "Can't enter record because of the following error -->" . mysqli_error($conn);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['snoEdit'])){
    // Update
    $sno = $_POST['snoEdit'];
    $name = $_POST['nameEdit'];
    $email = $_POST['emailEdit'];
    $role = $_POST['roleEdit'];

    $sql = "UPDATE `employee details` SET `name` = '$name', `email` = '$email', `role` = '$role' WHERE `employee details`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if($result) echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>UPDATED SUCCESSFULLY!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button></div>';
    else echo "Can't enter record because of the following error -->" . mysqli_error($conn);

  } else{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "INSERT INTO `employee details` (`sno`, `name`, `email`, `role`) VALUES (NULL, '$name', '$email', '$role')";
    $result = mysqli_query($conn, $sql);

    if ($result) echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Record entered successfully!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button></div>';
    else echo "Can't enter record because of the following error -->" . mysqli_error($conn);
  }
}

?>

<body>
  <!-- Modal for update -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit employee details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- form starts here -->
          <div class="container">
            <form action="/php/crm/form.php" method="post">
              <input type="hidden" id="snoEdit" name="snoEdit">
              <div class="form-group py-4">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="nameEdit" name="nameEdit" placeholder="Enter name">
              </div>
              <div class="form-group py-4">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="emailEdit" name="emailEdit" placeholder="Enter email">
              </div>
              <div class="form-group py-4">
                <label for="exampleInputEmail1">Role</label>
                <input type="text" class="form-control" name="roleEdit" id="roleEdit" placeholder="Enter role">
              </div>
              <!-- <button type="submit" class="btn btn-primary">Update details</button> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
        <!-- form ends here -->
      </div>
    </div>
  </div>

  <!-- Creation/Insertion form -->
  <div class="container">
    <form action="/php/crm/form.php" method="post">
      <div class="form-group py-4">
      <h2>Add a Note</h2>
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
      </div>
      <div class="form-group py-4">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
      </div>
      <div class="form-group py-4">
        <label for="exampleInputEmail1">Role</label>
        <input type="text" class="form-control" name="role" id="role" placeholder="Enter role">
      </div>
      <div class="">      
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

<!-- Read -->
  <div class="py-4">
    <table class="table" action="get">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th> 
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Actions</th>

        </tr>
      </thead>
      <?php
      $sql = "SELECT * FROM `employee details`";
      $result = mysqli_query($conn, $sql);

      $num = mysqli_num_rows($result);
      if ($num > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tbody>
                    <tr>
                    <th scope='row'>" . $i . "</th>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['role'] . "</td>
                    <td>".'<button type="submit" class="update btn btn-primary" id='.$row['sno'].' data-bs-toggle="modal" data-bs-target="#editModal">Update</button> <button type="submit" class="delete btn btn-primary"  id=d'.$row['sno'].'>Delete</button>'."</td>
                    </tr>
                </tbody>";
          $i = $i + 1;
        }
      }
      ?>
    </table>
  </div>
</body>

<!-- update -->
<script>
  edits = document.getElementsByClassName('update');
  Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
      console.log(edits, );
      tr = e.target.parentNode.parentNode;
      name = tr.getElementsByTagName("td")[0].innerText;
      email = tr.getElementsByTagName("td")[1].innerText;
      role = tr.getElementsByTagName("td")[2].innerText;
      console.log(name, email, role);
      nameEdit.value = name;
      emailEdit.value = email;
      roleEdit.value = role;
      snoEdit.value = e.target.id;
      console.log(e.target.id);
      $('#editModal').modal('toggle');
    })
  })

  deletes = document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
      console.log("delete", );
      sno = e.target.id.substr(1, );
      if(confirm('Do you want to delete this record?')){
        window.location = `/php/crm/form.php?delete=${sno}`;
      }
      
    })
  })
</script>

</html>