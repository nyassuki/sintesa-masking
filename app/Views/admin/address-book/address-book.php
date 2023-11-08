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
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    New phone number
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <?php echo form_open_multipart('admin/address_book_list/address-book/save', ['class' => 'custom-validation needs-validation']); ?>
                                        <div class="form-group">
                                            <label for="phonenumber">Phone number (E164 format):</label>
                                            <input type="text" name="phone_number" class="form-control" id="phone_number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phonenumber">Contact name :</label>
                                            <input type="text" name="contact_name" class="form-control" id="contact_name" value="<?php print $display_name; ?>" required>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox"> Push number</label>
                                        </div>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    Phone number list
                                    <center><img id="imgloading" src="/assets/img/loading.gif" style="display: none"></center>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <table class="table table-hover" id="cs_datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Phone number</th>
                                                    <th>Contact name</th>
                                                    <th>Active</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                for ($i = 0; $i <= count($addressbook) - 1; $i++) {
                                                    $no = $i + 1;
                                                    $id = $addressbook[$i]['id'];
                                                    $phone_number = $addressbook[$i]['phone_number'];
                                                    $contact_name = $addressbook[$i]['contact_name'];
                                                    $active = $addressbook[$i]['active'];
                                                    print "<tr><td>$no</td>";
                                                    print "<td>$phone_number</td>";
                                                    print "<td>$contact_name</td>";
                                                    print "<td>$active</td>";
                                                    print "<td><button id='$phone_number' class='btn btn-sm btn-danger del'>Del</button> <button class='btn btn-sm btn-warning btnedit' id='$phone_number'>Edit</button> <button class='btn btn-sm btn-primary push' id='$id'>Push</button></td></tr>";
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
    $(".btnedit").click(function () {
        $("#phone_number").val(this.id);
    });
    $(".push").click(function () {

        if (confirm("Push phone number to All client ?") == true) {
            $("#imgloading").show();
            $.ajax({
                type: 'get',
                url: '<?php print base_url(); ?>/admin/address_book_list/address-book/push',
                data: {contact_id: this.id},
                contentType: "application/json; charset=utf-8",
                traditional: true,
                success: function (data) {
                    alert("Success !");
                    $("#imgloading").hide();

                }
            });
        } else {
            text = "Canceled!";
        }
    });
    $(".del").click(function () {
        if (confirm("Delete phone " + this.id + " ?") == true) {
            $.ajax({
                type: 'get',
                url: '<?php print base_url(); ?>/admin/address_book_list/address-book/delete',
                data: {phone_number: this.id},
                contentType: "application/json; charset=utf-8",
                traditional: true,
                success: function (data) {
                }
            });
            location.reload();
        } else {
            text = "Canceled!";
        }
    })
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