<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>

<?php
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php admin_url() ?>">/</a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item"><a href="<?php admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Edit contact display
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <?php echo form_open('admin/contact-display/update', ['class' => 'custom-validation needs-validation']); ?>
                                        <div class="form-group">
                                            <label for="phonenumber">Contact display name:</label>
                                            <input type="hidden" name="client_id" class="form-control" id="client_id" value="<?php print $client_code; ?>">
                                            <input type="text" name="contact_display_name" class="form-control" id="contact_display_name" required>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Pusher app id:</label>
                                                    <input type="text" name="pusher_app_id" class="form-control" id="pusher_app_id" value="<?php print $client[0]["pusher_app_id"]; ?>" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Pusher key:</label>
                                                    <input type="text" name="pusher_key" class="form-control" id="pusher_key" value="<?php print $client[0]["pusher_key"]; ?>" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Pusher secret:</label>
                                                    <input type="text" name="pusher_secret" class="form-control" id="pusher_secret"  value="<?php print $client[0]["pusher_secret"]; ?>"  readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Pusher cluster:</label>
                                                    <input type="text" name="pusher_cluster" class="form-control" id="pusher_cluster"  value="<?php print $client[0]["pusher_cluster"]; ?>" readonly>
                                                </div>
                                                <div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            Customer details 
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <table class="table table-hover" id="cs_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer code</th>
                                                            <th>Customer name</th>
                                                            <th>Contact display</th>
                                                            <th>Contact logo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        for ($i = 0; $i <= count($client) - 1; $i++) {
                                                            $no = $i + 1;
                                                            $client_id = $client[$i]['client_id'];
                                                            $client_name = $client[$i]['client_name'];
                                                            $contact_display_name = $client[$i]['contact_display_name'];
                                                            $pusher_app_id = $client[$i]['pusher_app_id'];
                                                            $pusher_key = $client[$i]['pusher_key'];
                                                            $pusher_secret = $client[$i]['pusher_secret'];
                                                            $pusher_cluster = $client[$i]['pusher_cluster'];
                                                            $contact_logo = $client[$i]['contact_logo'];
                                                            $active = $client[$i]['active'];
                                                            print "<tr><td>$no</td>";
                                                            print "<td>$client_id</td>";
                                                            print "<td>$client_name</td>";
                                                            print "<td>$contact_display_name</td>";
                                                             
                                                            print "<td><img src='$contact_logo' width='50%' id='userimg'> "
                                                                    . "<button type='button' class='btn btn-sm btn-success btn-sm' data-toggle='modal' data-target='#file_manager_image' data-bs-image-type='input' data-bs-item-id='#userimg' data-bs-input-id='#newimage_id'>Change</button></td>";
                                                            print "<td><button class='btn btn-sm btn-warning btnedit' id='$contact_display_name'>Edit</button></td></tr>";
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <script>
                $("#userimg").on('load', function () {
                    var images = $('#userimg').attr('src');

                    $("#contact_logo").val(images);
                    $.ajax({
                        type: 'get',
                        url: 'contact-display/update_image',
                        data: {contact_logo: images},
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        success: function (data) {

                        }
                    });
                });
                $(".btnedit").click(function () {
                    $("#contact_display_name").val(this.id);
                });
            </script>
            <?php echo $this->endSection() ?>
            <script>
                $(document).ready(function () {
                    $('#cs_datatable').DataTable({
                        language: {
                            paginate: {
                                previous: "<i class='fas fa-angle-left'>",
                                next: "<i class='fas fa-angle-right'>"
                            }
                        },

                        "aLengthMenu": [
                            [15, 30, 60, 100],
                            [15, 30, 60, 100, "All"]
                        ],
                        drawCallback: function () {

                        }
                    });

                });

            </script>