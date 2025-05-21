<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/slugify.php'; ?>

<body class="hold-transition layout-top-nav" style="background-color: #f0f0f0;">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper" style="background-color: #f0f0f0;">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <?php
                    $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
                    $title = $parse['election_title'];
                    ?>


                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <?php
                            if (isset($_SESSION['error'])) {
                            ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <ul>
                                        <?php
                                        foreach ($_SESSION['error'] as $error) {
                                            echo "<li>" . $error . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php
                                unset($_SESSION['error']);
                            }
                            if (isset($_SESSION['success'])) {
                                echo "
                                <div class='alert alert-success alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h4><i class='icon fa fa-check'></i> Berhasil!</h4>
                                    " . $_SESSION['success'] . "
                                </div>
                            ";
                                unset($_SESSION['success']);
                            }
                            ?>

                            <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="message"></span>
                            </div>

                            <?php

                            $sql = "SELECT * FROM votes WHERE voters_id = '" . $voter['id'] . "'";
                            $vquery = $conn->query($sql);
                            $user_voted = $vquery->num_rows > 0;

                            if ($user_voted) {

                                // Calculate the percentage of voters who have voted
                                $total_voters_sql = "SELECT COUNT(*) as total FROM voters";
                                $total_voters_query = $conn->query($total_voters_sql);
                                $total_voters_row = $total_voters_query->fetch_assoc();
                                $total_voters = $total_voters_row['total'] ?? 1; // Avoid division by zero

                                $voted_voters_sql = "SELECT COUNT(*) as voted FROM voters WHERE voted = 1";
                                $voted_voters_query = $conn->query($voted_voters_sql);
                                $voted_voters_row = $voted_voters_query->fetch_assoc();
                                $voted_voters = $voted_voters_row['voted'];

                                $voted_percentage = ($voted_voters / $total_voters) * 100;
                                echo '<h1 class="text-center" style="color: #333; font-family: Arial, sans-serif; margin-bottom: 30px; margin-top: 30px;"><b>Perolehan Suara<br>' . $title . '</b></h1>';

                                echo "<h3 class='text-center' style='color: #333; font-family: Arial, sans-serif; margin-bottom: 30px;'>
                                        Perolehan suara masuk " . number_format($voted_percentage, 2) . "%
                                    </h3>";

                                $candidate = '';
                                $sql = "SELECT * FROM positions ORDER BY priority ASC";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                    $sql = "SELECT candidates.*, (SELECT COUNT(*) FROM votes WHERE votes.candidate_id = candidates.id) AS votes FROM candidates WHERE candidates.position_id='" . $row['id'] . "'";
                                    $cquery = $conn->query($sql);
                                    $candidate = '<div class="candidate-list-container"><ul class="candidate-list">';
                                    while ($crow = $cquery->fetch_assoc()) {
                                        $slug = slugify($row['description']);
                                        $checked = '';

                                        $voted_sql = "SELECT * FROM votes WHERE voters_id = '" . $voter['id'] . "' AND candidate_id = '" . $crow['id'] . "'";
                                        $voted_query = $conn->query($voted_sql);
                                        if ($voted_query->num_rows > 0) {
                                            $checked = 'checked';
                                        }

                                        $input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red ' . $slug . '" name="' . $slug . "[]" . '" value="' . $crow['id'] . '" ' . $checked . '>' : '<input type="radio" class="flat-red ' . $slug . '" name="' . slugify($row['description']) . '" value="' . $crow['id'] . '" ' . $checked . '>';
                                        $image = (!empty($crow['photo'])) ? 'images/' . $crow['photo'] : 'images/profile.jpg';
                                        $candidate .= '
                                            <li class="candidate-item">
                                                <label>
                                                    ' . $input . '
                                                    <img src="' . $image . '" class="candidate-img" alt="' . $crow['fullname'] . '">
                                                    <span class="cname">' . $crow['fullname'] . '</span>
                                                </label>
                                                <p class="votes-count">Votes: ' . $crow['votes'] . '</p>
                                            </li>
                                        ';
                                    }
                                    $candidate .= '</ul></div>';

                                    $instruct = ($row['max_vote'] > 1) ? 'Anda dapat memilih hingga ' . $row['max_vote'] . ' kandidat' : 'Pilih hanya satu kandidat';

                                    echo '
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-xs-12">
                                                <div class="box" style="background-color: #ffffff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                                                    <div class="box-header with-border" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px;">
                                                        <h3 class="box-title" style="color: #333; font-family: Arial, sans-serif;"><b>' . $row['description'] . '</b></h3>
                                                    </div>
                                                    <div class="box-body" style="padding: 20px;">
                                                        <div id="candidate_list">
                                                            ' . $candidate . '
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';

                                    $candidate = '';
                                }

                                echo '
                                <div class="row" style="margin-bottom: 40px;">
                                    <div class="col-xs-12">
                                        <div class="box" style="margin-bottom: 40px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 40px;">
                                            <h3 class="text-center" style="color: #333; font-family: Arial, sans-serif; margin-bottom: 30px;">
                                                Anda telah memberikan suara untuk pemilihan ini.
                                            </h3>         
                                            <div class="text-center" style="margin-bottom: 30px;">
                                                <button type="button" data-toggle="modal" data-target="#view" class="btn btn-primary btn-lg">
                                                    <i class="fa fa-eye"></i> Lihat
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }

                            ?>

                            <!-- Voting Ballot -->
                            <?php if (!$user_voted) { ?>
                                <form method="POST" id="ballotForm" action="submit_ballot.php">
                                    <?php
                                    echo '<h1 class="text-center" style="color: #333; font-family: Arial, sans-serif; margin-bottom: 30px; margin-top: 30px;"><b>Pemungutan Suara<br>' . $title . '</b></h1>';

                                    $candidate = '';
                                    $sql = "SELECT * FROM positions ORDER BY priority ASC";
                                    $query = $conn->query($sql);
                                    while ($row = $query->fetch_assoc()) {
                                        $sql = "SELECT candidates.*, (SELECT COUNT(*) FROM votes WHERE votes.candidate_id = candidates.id) AS votes FROM candidates WHERE candidates.position_id='" . $row['id'] . "'";
                                        $cquery = $conn->query($sql);
                                        $candidate = '<div class="candidate-list-container"><ul class="candidate-list">';
                                        while ($crow = $cquery->fetch_assoc()) {
                                            $slug = slugify($row['description']);
                                            $checked = '';
                                            if (isset($_SESSION['post'][$slug])) {
                                                $value = $_SESSION['post'][$slug];
                                                if (is_array($value)) {
                                                    foreach ($value as $val) {
                                                        if ($val == $crow['id']) {
                                                            $checked = 'checked';
                                                        }
                                                    }
                                                } else {
                                                    if ($value == $crow['id']) {
                                                        $checked = 'checked';
                                                    }
                                                }
                                            }

                                            $input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red ' . $slug . '" name="' . $slug . "[]" . '" value="' . $crow['id'] . '" ' . $checked . '>' : '<input type="radio" class="flat-red ' . $slug . '" name="' . slugify($row['description']) . '" value="' . $crow['id'] . '" ' . $checked . '>';
                                            $image = (!empty($crow['photo'])) ? 'images/' . $crow['photo'] : 'images/profile.jpg';
                                            $candidate .= '
                    <li class="candidate-item">
                        <label>
                            ' . $input . '
                            <img src="' . $image . '" class="candidate-img" alt="' . $crow['fullname'] . '">
                            <span class="cname">' . $crow['fullname'] . '</span>
                        </label>
                        <button type="button" class="btn btn-primary btn-sm platform" data-platform="' . $crow['platform'] . '" data-fullname="' . $crow['fullname'] . '" data-photo="' . $image . '">
                            <i class="fa fa-search"></i> Detail
                        </button>
                    </li>
                ';
                                        }
                                        $candidate .= '</ul></div>';

                                        $instruct = ($row['max_vote'] > 1) ? 'Anda dapat memilih hingga ' . $row['max_vote'] . ' kandidat' : 'Pilih hanya satu kandidat';

                                        echo '
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-xs-12">
                        <div class="box" style="background-color: #ffffff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                            <div class="box-header with-border" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px;">
                                <h3 class="box-title" style="color: #333; font-family: Arial, sans-serif;"><b>' . $row['description'] . '</b></h3>
                            </div>
                            <div class="box-body" style="padding: 20px;">
                                <p style="color: #666; margin-bottom: 15px; font-size: 16px;">' . $instruct . '
                                    <span class="pull-right">
                                        <button type="button" class="btn btn-success btn-sm reset" style="background-color: #28a745; border-color: #28a745; color: #fff; font-size: 12px; font-family: Arial, sans-serif;" data-desc="' . slugify($row['description']) . '">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>
                                    </span>
                                </p>
                                <div id="candidate_list">
                                    ' . $candidate . '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';

                                        $candidate = '';
                                    }
                                    ?>
                                    <div class="text-center" style="margin-top: 30px; margin-bottom: 50px;">
                                        <button type="button" class="btn btn-success btn-lg" style="background-color: #28a745; border-color: #28a745; color: #fff; font-size: 18px; font-family: Arial, sans-serif; margin-right: 10px;" id="preview">
                                            <i class="fa fa-file-text"></i> Pratinjau
                                        </button>
                                        <button type="button" class="btn btn-primary btn-lg" style="background-color: #007bff; border-color: #007bff; color: #fff; font-size: 18px; font-family: Arial, sans-serif;" id="submitBallot">
                                            <i class="fa fa-check-square-o"></i> Kirim
                                        </button>
                                    </div>
                                </form>
                            <?php } ?>
                            <!-- End Voting Ballot -->
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/ballot_modal.php'; ?>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmationModalLabel">Konfirmasi Pilihan Anda</h4>
                    <h5>Pastikan pilihan Anda sudah benar, karena setelah dikonfirmasi pilihan tidak dapat diubah. Jangan lupa memilih di setiap kategori</h5>
                </div>
                <div class="modal-body">
                    <div id="confirmationBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Modal -->
    <div id="fullscreenModal" class="fullscreen-modal">
        <span class="close">&times;</span>
        <img class="fullscreen-modal-content" id="fullscreenImg">
    </div>

    <!-- Selections Modal -->
    <div class="modal fade" id="selectionsModal" tabindex="-1" role="dialog" aria-labelledby="selectionsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectionsModalLabel">Your Selections</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="selectionsBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function() {
            $('.content').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            $(document).on('click', '.reset', function(e) {
                e.preventDefault();
                var desc = $(this).data('desc');
                $('.' + desc).iCheck('uncheck');
            });

            $(document).on('click', '.platform', function(e) {
                e.preventDefault();
                $('#platform').modal('show');
                var platform = $(this).data('platform');
                var fullname = $(this).data('fullname');
                var photo = $(this).data('photo');
                $('.candidate').html(fullname);
                $('#plat_view').html('<img src="' + photo + '" class="platform-img" alt="' + fullname + '"><p>' + platform + '</p>');
            });

            $(document).on('click', '.platform-img', function() {
                var src = $(this).attr('src');
                $('#fullscreenImg').attr('src', src);
                $('#fullscreenModal').css('display', 'block');
            });

            $('.close').click(function() {
                $('#fullscreenModal').css('display', 'none');
            });

            $('#preview').click(function(e) {
                e.preventDefault();
                var form = $('#ballotForm').serialize();
                if (form == '') {
                    $('.message').html('Anda harus memilih setidaknya satu kandidat');
                    $('#alert').show();
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'preview.php',
                        data: form,
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                var errmsg = '';
                                var messages = response.message;
                                for (i in messages) {
                                    errmsg += messages[i];
                                }
                                $('.message').html(errmsg);
                                $('#alert').show();
                            } else {
                                $('#preview_modal').modal('show');
                                $('#preview_body').html(response.list);
                            }
                        }
                    });
                }
            });

            $('#submitBallot').click(function(e) {
                e.preventDefault();
                var form = $('#ballotForm').serialize();
                if (form == '') {
                    $('.message').html('You must vote for at least one candidate');
                    $('#alert').show();
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'preview.php',
                        data: form,
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                var errmsg = '';
                                var messages = response.message;
                                for (i in messages) {
                                    errmsg += messages[i];
                                }
                                $('.message').html(errmsg);
                                $('#alert').show();
                            } else {
                                $('#confirmationBody').html(response.list);
                                $('#confirmationModal').modal('show');
                            }
                        }
                    });
                }
            });

            $('#confirmSubmit').click(function() {
                $('#ballotForm').submit();
            });

            $('#ballotForm').submit(function(e) {
                var form = $(this).serialize();
                if (form == '') {
                    e.preventDefault();
                    $('.message').html('You must vote for at least one candidate');
                    $('#alert').show();
                }
            });

            <?php if (!$user_voted) { ?>
                // Add click event to candidate items
                $(document).on('click', '.candidate-item', function() {
                    var input = $(this).find('input');
                    input.iCheck('check');
                });

                // Add checkmark to selected candidate
                $('input').on('ifChecked', function(event) {
                    $(this).closest('li').addClass('selected');
                });

                $('input').on('ifUnchecked', function(event) {
                    $(this).closest('li').removeClass('selected');
                });
            <?php } ?>

            // Show selections modal
            $('#viewSelections').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'view_selections.php',
                    data: {
                        voter_id: '<?php echo $voter['id']; ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            $('.message').html(response.message);
                            $('#alert').show();
                        } else {
                            $('#selectionsBody').html(response.list);
                            $('#selectionsModal').modal('show');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>