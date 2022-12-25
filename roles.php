<?php
  require_once 'config.php';
  include 'header.php';
  $query = $conn->query("select * from roles");
  $query->execute();
  $data = $query->fetchAll();

  $name     = "";
  $sukses     = "";
  $error      = "";
  if (isset($_GET['op'])) {
    $op = $_GET['op'];
  } else {
    $op = "";
  }
  
  if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = $conn->query("delete from roles where id= '$id'");
    if ($sql1) {
      $sukses = "Berhasil hapus data";
    } else {
      $error  = "Gagal melakukan delete data";
    }
  }

  if ($op == 'edit') {
    $id = $_GET['id'];
    $sql2 = $conn->query("select * from roles where id = '$id'");
    $sql2->execute();
    $edit = $sql2->fetchAll();
    $name = $edit[0]["name"];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
  }

  if (isset($_POST['simpan'])) { //untuk create
    $name = $_POST['name'];
    
    if ($name) {
        if ($op == 'edit') { //untuk update
            $query_edit = $conn->query("update roles set name = '$name' where id = '$id'");
            if ($query_edit) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
            $query_insert = $conn->query("insert into roles (name) values ('$name')");
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
        Create / Edit Data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php
            header("refresh:3;url=roles.php");//3 : detik
        }
        ?>
        <?php
        if ($sukses) {
        ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses ?>
            </div>
        <?php
            header("refresh:3;url=roles.php");
        }
        ?>
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
            </div>
          </div>
          <div class="col-12">
            <input type="submit" name="simpan" value="Save Data" class="btn btn-primary items-center" />
          </div>
        </form>
      </div>
    </div>

    <!-- data table roles -->
    <div class="card">
      <div class="card-header text-white bg-secondary">
          Roles Table
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Role Name</th>
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
              <td scope="row">
                <a href="roles.php?op=edit&id=<?php echo $value['id'] ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                <a href="roles.php?op=delete&id=<?php echo $value['id']?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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