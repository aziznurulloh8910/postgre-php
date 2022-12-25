<?php
  require_once 'config.php';
  include 'header.php';
  $query = $conn->query("select * from posts_garut");
  $query->execute();
  $data = $query->fetchAll();

  $description = "";
  $location = "";
  $user_id = "";
  $sukses = "";
  $error = "";
  if (isset($_GET['op'])) {
    $op = $_GET['op'];
  } else {
    $op = "";
  }
  
  if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = $conn->query("delete from posts_garut where id= '$id'");
    if ($sql1) {
      $sukses = "Berhasil hapus data";
    } else {
      $error  = "Gagal melakukan delete data";
    }
  }

  if ($op == 'edit') {
    $id = $_GET['id'];
    $sql2 = $conn->query("select * from posts_garut where id = '$id'");
    $sql2->execute();
    $edit = $sql2->fetchAll();
    $description = $edit[0]["description"];
    $location = $edit[0]["location"];
    $user_id = $edit[0]["user_id"];

    if ($description == '') {
        $error = "Data tidak ditemukan";
    }
  }

  if (isset($_POST['simpan'])) { //untuk create
    $description = $_POST['description'];
    $location = $_POST['location'];
    $user_id = $_POST['user_id'];

    if ($description) {
        if ($op == 'edit') { //untuk update
            $query_edit = $conn->query("update posts_garut set description = '$description', location = '$location', user_id = '$user_id' where id = '$id'");
            if ($query_edit) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
            $query_insert = $conn->query("insert into posts_garut (description, location, user_id) values ('$description', '$location', '$user_id')");
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
        Create / Edit Data Posts Garut
      </div>
      <div class="card-body">
        <?php
        if ($error) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php
            header("refresh:3;url=post_garut.php");//3 : detik
        }
        ?>
        <?php
        if ($sukses) {
        ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses ?>
            </div>
        <?php
            header("refresh:3;url=post_garut.php");
        }
        ?>
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="description" name="description" value="<?php echo $description ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="location" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location" name="location" value="<?php echo $location ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="user_id" class="col-sm-2 col-form-label">User</label>
            <div class="col-sm-10">
              <?php 
                $user = $conn->query("select * from users_garut");
                $userData = $user->fetchAll(PDO::FETCH_ASSOC);
              ?>
              <select class="form-control" name="user_id" id="user_id">
                <option value="">- Choose User -</option>
                  <?php 
                    foreach($userData as $value) {
                  ?>
                    <option value=<?php echo $value['id'] ?>><?php echo $value['name']?></option>
                  <?php
                    }
                  ?>
              </select>
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
          Posts Garut
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Description</th>
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
              <td scope="row"><?php echo $value['description'] ?></td>
              <td scope="row"><?php echo $value['location'] ?></td>
              <td scope="row">
                <a href="post_garut.php?op=edit&id=<?php echo $value['id'] ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                <a href="post_garut.php?op=delete&id=<?php echo $value['id']?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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