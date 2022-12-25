<?php
  require_once 'config.php';
  include 'header.php';
  $query = $conn->query("select * from users_garut");
  $query->execute();
  $data = $query->fetchAll();

  $name = "";
  $username = "";
  $password = "";
  $phone = "";
  $location = "";
  $role_id = "";
  $sukses = "";
  $error = "";
  if (isset($_GET['op'])) {
    $op = $_GET['op'];
  } else {
    $op = "";
  }
  
  if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = $conn->query("delete from users_garut where id= '$id'");
    if ($sql1) {
      $sukses = "Berhasil hapus data";
    } else {
      $error  = "Gagal melakukan delete data";
    }
  }

  if ($op == 'edit') {
    $id = $_GET['id'];
    $sql2 = $conn->query("select * from users_garut where id = '$id'");
    $sql2->execute();
    $edit = $sql2->fetchAll();
    $name = $edit[0]["name"];
    $username = $edit[0]["username"];
    $password = $edit[0]["password"];
    $phone = $edit[0]["phone"];
    $location = $edit[0]["location"];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
  }

  if (isset($_POST['simpan'])) { //untuk create
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $phone = $_POST['phone'];
    $location = $_POST['location'];

    if ($name) {
        if ($op == 'edit') { //untuk update
            $query_edit = $conn->query("update users_garut set name = '$name', username = '$username', password = '$password', phone = '$phone', location = '$location', role_id = '2' where id = '$id'");
            if ($query_edit) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
            $query_insert = $conn->query("insert into users_garut (name, username, password, phone, location, role_id) values ('$name', '$username', '$password', '$phone', '$location', '2')");
            if ($query_insert) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
      $error = "Silakan masukkan semua data";
    }
  }
?>

<body>
  <div class="mx-auto">
    <?php 
      include 'navbar.php';
    ?>
    <!-- form input -->
    <div class="card">
      <div class="card-header">
        Create / Edit Data User Garut
      </div>
      <div class="card-body">
        <?php
        if ($error) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php
            header("refresh:3;url=user_garut.php");//3 : detik
        }
        ?>
        <?php
        if ($sukses) {
        ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses ?>
            </div>
        <?php
            header("refresh:3;url=user_garut.php");
        }
        ?>
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="location" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location" name="location" value="<?php echo $location ?>">
            </div>
          </div>
          <div class="col-12">
            <input type="submit" name="simpan" value="Save Data" class="btn btn-primary" />
          </div>
        </form>
      </div>
    </div>

    <!-- data table roles -->
    <div class="card">
      <div class="card-header text-white bg-secondary">
          User Garut
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Username</th>
              <th scope="col">Phone</th>
              <th scope="col">Location</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($data as $value) {
            ?>
            <tr>
              <td scope="row"><?php echo $value['id'] ?></td>
              <td scope="row"><?php echo $value['name'] ?></td>
              <td scope="row"><?php echo $value['username'] ?></td>
              <td scope="row"><?php echo $value['phone'] ?></td>
              <td scope="row"><?php echo $value['location'] ?></td>
              <td scope="row">
                <a href="user_garut.php?op=edit&id=<?php echo $value['id'] ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                <a href="user_garut.php?op=delete&id=<?php echo $value['id']?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
              </td>
            </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>