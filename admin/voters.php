<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color:#F1E9D2 ">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><b>
            Voters List
          </b> </h1>
        <ol class="breadcrumb" style="color:black ; font-size: 17px; font-family:Times">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active" style="color:black ; font-size: 17px; font-family:Times">Dashboard</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box" style="background-color: #d8d1bd">
              <div class="box-header with-border" style="background-color: #d8d1bd">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-curve " style="background-color: #4682B4 ;color:black ; font-size: 12px; font-family:Times"><i class="fa fa-plus"></i> New</a>
              </div>
              <div class="box-body">
                <table id="example1" class="table ">
                  <thead>
                    <th>NIM</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Verified</th>
                    <th>Voted</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM voters";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "
                        <tr style='color:black ; font-size: 15px; font-family:Times'>
                          <td>" . $row['nim'] . "</td>
                          <td>" . $row['fullname'] . "</td>
                          <td>" . $row['email'] . "</td>
                          <td>" . ($row['verified'] ? 'Yes' : 'No') . "</td>
                          <td>" . ($row['voted'] ? 'Yes' : 'No') . "</td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-curve' style='background-color: #9CD095 ;color:black ; font-size: 12px; font-family:Times' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-warning btn-sm editPassword btn-curve' style='background-color: #FFD700 ;color:black ; font-size: 12px; font-family:Times' data-id='" . $row['id'] . "'><i class='fa fa-key'></i> Edit Password</button>
                            <button class='btn btn-danger btn-sm delete btn-curve' style='background-color:#ff8e88 ;color:black ; font-size: 12px; font-family:Times' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                          </td>
                        </tr>
                      ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/voters_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.editPassword', function(e) {
        e.preventDefault();
        $('#editPassword').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.photo', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'voters_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.id').val(response.id);
          $('#edit_nim').val(response.nim);
          $('#edit_fullname').val(response.fullname);
          $('#edit_email').val(response.email);
          $('#edit_verified').prop('checked', response.verified == 1);
        }
      });
    }
  </script>
</body>

</html>