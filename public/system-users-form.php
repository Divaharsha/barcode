<?php

include_once('includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");

include('includes/variables.php');
include_once('includes/custom-functions.php');

$fn = new custom_functions;
$config = $fn->get_configurations();
$permissions = $fn->get_permissions($_SESSION['id']);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<?php
if ($_SESSION['role'] == 'editor') {
    echo "<p class='alert alert-danger topmargin-sm'>Access denied - You are not authorized to access this page.</p>";
    return false;
}
?>
<section class="content-header">
    <h1>Create admin <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>

</section>
<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Admin </h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" id="add_form" action="public/db-operation.php">
                    <input type="hidden" id="add_system_user" name="add_system_user" value="1">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" class="form-control">
                                <option value="">---Select---</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                    </div><!-- /.box-body -->


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="submit_btn" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />

                    </div>
                    <div class="form-group">

                        <div id="result" style="display: none;"></div>
                    </div>

            </div><!-- /.box -->
            <?php
            if ($_SESSION['role'] != 'editor') { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">System Users</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="system-users" data-url="api-firebase/get-bootstrap-table-data.php?table=system-users" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="username" data-sortable="true">Username</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="role" data-sortable="true">Role</th>
                                    <th data-field="created_by" data-sortable="true" data-visible="false">Created By</th>
                                    <th data-field="created_by_id" data-sortable="true" data-visible="false">Created By Id</th>
                                    <th data-field="date_created" data-visible="false">Date Created</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-xs-6">
            <div class="box box-primary">
                <table>
                    <tr>
                        <th>Module/Permissions</th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                    <tr>
                        <td>Dealer Gold Smith Master</td>
                        <td><input type="checkbox" id="create-goldsmithmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-goldsmithmaster" name="is-create-goldsmithmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="read-goldsmithmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-goldsmithmaster" name="is-read-goldsmithmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="update-goldsmithmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-goldsmithmaster" name="is-update-goldsmithmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-goldsmithmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-goldsmithmaster" name="is-delete-goldsmithmaster" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Opening Master</td>
                        <td><input type="checkbox" id="create-openmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-openmaster" name="is-create-openmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="read-openmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-openmaster" name="is-read-openmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="update-openmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-openmaster" name="is-update-openmaster" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-openmaster-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-openmaster" name="is-delete-openmaster" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Daily transaction</td>
                        <td><input type="checkbox" id="create-dailytransaction-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-dailytransaction" name="is-create-dailytransaction" value="1">
                        </td>
                        <td><input type="checkbox" id="read-dailytransaction-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-dailytransaction" name="is-read-dailytransaction" value="1">
                        </td>
                        <td><input type="checkbox" id="update-dailytransaction-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-dailytransaction" name="is-update-dailytransaction" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-dailytransaction-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-dailytransaction" name="is-delete-dailytransaction" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Suspense Account</td>
                        <td><input type="checkbox" id="create-suspenseaccount-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-suspenseaccount" name="is-create-suspenseaccount" value="1">
                        </td>
                        <td><input type="checkbox" id="read-suspenseaccount-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-suspenseaccount" name="is-read-suspenseaccount" value="1">
                        </td>
                        <td><input type="checkbox" id="update-suspenseaccount-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-suspenseaccount" name="is-update-suspenseaccount" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-suspenseaccount-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-suspenseaccount" name="is-delete-suspenseaccount" value="1">
                        </td>
                    </tr>
 
                    <tr>
                        <td>Transaction Register</td>
                        <td><input type="checkbox" id="create-transactionregister-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-transactionregister" name="is-create-transactionregister" value="1">
                        </td>
                        <td><input type="checkbox" id="read-transactionregister-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-transactionregister" name="is-read-transactionregister" value="1">
                        </td>
                        <td><input type="checkbox" id="update-transactionregister-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-transactionregister" name="is-update-transactionregister" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-transactionregister-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-transactionregister" name="is-delete-transactionregister" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Dealer Ledger Report</td>
                        <td><input type="checkbox" id="create-dealerreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-dealerreport" name="is-create-dealerreport" value="1">
                        </td>
                        <td><input type="checkbox" id="read-dealerreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-dealerreport" name="is-read-dealerreport" value="1">
                        </td>
                        <td><input type="checkbox" id="update-dealerreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-dealerreport" name="is-update-dealerreport" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-dealerreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-dealerreport" name="is-delete-dealerreport" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Areawise Ledger Report</td>
                        <td><input type="checkbox" id="create-areawisereport-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-areawisereport" name="is-create-areawisereport" value="1">
                        </td>
                        <td><input type="checkbox" id="read-areawisereport-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-areawisereport" name="is-read-areawisereport" value="1">
                        </td>
                        <td><input type="checkbox" id="update-areawisereport-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-areawisereport" name="is-update-areawisereport" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-areawisereport-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-areawisereport" name="is-delete-areawisereport" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td>Stock Report</td>
                        <td><input type="checkbox" id="create-stockreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-create-stockreport" name="is-create-stockreport" value="1">
                        </td>
                        <td><input type="checkbox" id="read-stockreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-read-stockreport" name="is-read-stockreport" value="1">
                        </td>
                        <td><input type="checkbox" id="update-stockreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-update-stockreport" name="is-update-stockreport" value="1">
                        </td>
                        <td><input type="checkbox" id="delete-stockreport-button" class="js-switch" checked>
                            <input type="hidden" id="is-delete-stockreport" name="is-delete-stockreport" value="1">
                        </td>
                    </tr>
 

                </table>

            </div>
            </form>
        </div>
        <!-- Left col -->

        <div class="separator"> </div>
    </div>
    <div class="modal fade" id='editSystemUserModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Permissions</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <form id="update_form" method="POST" action="public/db-operation.php" data-parsley-validate class="form-horizontal form-label-left">
                            <input type='hidden' name="system_user_id" id="system_user_id" value='' />
                            <input type='hidden' name="update_system_user" id="update_system_user" value='1' />
                            <div class="box box-primary">
                                <table>
                                    <tr>
                                        <th>Module/Permissions</th>
                                        <th>Create</th>
                                        <th>Read</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                    <tr>
                                        <td>Dealer Gold Smith Master</td>
                                        <td><input type="checkbox" id="permission-create-goldsmithmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-goldsmithmaster" name="permission-is-create-goldsmithmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-goldsmithmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-goldsmithmaster" name="permission-is-read-goldsmithmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-goldsmithmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-goldsmithmaster" name="permission-is-update-goldsmithmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-goldsmithmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-goldsmithmaster" name="permission-is-delete-goldsmithmaster" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Opening Master</td>
                                        <td><input type="checkbox" id="permission-create-openmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-openmaster" name="permission-is-create-openmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-openmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-openmaster" name="permission-is-read-openmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-openmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-openmaster" name="permission-is-update-openmaster" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-openmaster-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-openmaster" name="permission-is-delete-openmaster" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Daily transaction</td>
                                        <td><input type="checkbox" id="permission-create-dailytransaction-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-dailytransaction" name="permission-is-create-dailytransaction" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-dailytransaction-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-dailytransaction" name="permission-is-read-dailytransaction" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-permission-update-dailytransaction-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-dailytransaction" name="permission-is-update-dailytransaction" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-dailytransaction-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-dailytransaction" name="permission-is-delete-dailytransaction" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suspense Account</td>
                                        <td><input type="checkbox" id="permission-create-suspenseaccount-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-suspenseaccount" name="permission-is-create-suspenseaccount" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-suspenseaccount-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-suspenseaccount" name="permission-is-read-suspenseaccount" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-permission-update-suspenseaccount-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-suspenseaccount" name="permission-is-update-suspenseaccount" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-suspenseaccount-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-suspenseaccount" name="permission-is-delete-suspenseaccount" value="1">
                                        </td>
                                    </tr>
                
                
                                    <tr>
                                        <td>Transaction Register</td>
                                        <td><input type="checkbox" id="permission-create-transactionregister-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-transactionregister" name="permission-is-create-transactionregister" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-transactionregister-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-transactionregister" name="permission-is-read-transactionregister" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-transactionregister-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-transactionregister" name="permission-is-update-transactionregister" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-transactionregister-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-transactionregister" name="permission-is-delete-transactionregister" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dealer Ledger Report</td>
                                        <td><input type="checkbox" id="permission-create-dealerreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-dealerreport" name="permission-is-create-dealerreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-dealerreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-dealerreport" name="permission-is-read-dealerreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-dealerreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-dealerreport" name="permission-is-update-dealerreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-dealerreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-dealerreport" name="permission-is-delete-dealerreport" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Areawise Ledger Report</td>
                                        <td><input type="checkbox" id="permission-create-areawisereport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-areawisereport" name="permission-is-create-areawisereport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-areawisereport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-areawisereport" name="permission-is-read-areawisereport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-areawisereport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-areawisereport" name="permission-is-update-areawisereport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-areawisereport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-areawisereport" name="permission-is-delete-areawisereport" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stock Report</td>
                                        <td><input type="checkbox" id="permission-create-stockreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-create-stockreport" name="permission-is-create-stockreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-read-stockreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-read-stockreport" name="permission-is-read-stockreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-update-stockreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-update-stockreport" name="permission-is-update-stockreport" value="1">
                                        </td>
                                        <td><input type="checkbox" id="permission-delete-stockreport-button" class="js-switch" checked>
                                            <input type="hidden" id="permission-is-delete-stockreport" name="permission-is-delete-stockreport" value="1">
                                        </td>
                                    </tr>
 
 

                                </table>

                            </div>
                            <input type="hidden" id="id" name="id">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-offset-3 col-md-8" style="display:none;" id="update_result"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>




<script>
    $('#add_form').validate({
        rules: {
            username: "required",
            email: "required",
            password: "required",
            role: "required",
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        }
    });
</script>

<script>
    $('#add_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($("#add_form").validate().form()) {
            if (confirm('Are you sure?Want to Add.')) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    beforeSend: function() {
                        $('#submit_btn').html('Please wait..');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        $('#result').html(result);
                        $('#result').show().delay(6000).fadeOut();
                        $('#submit_btn').html('Submit');
                        $('#add_form')[0].reset();
                        $('#system-users').bootstrapTable('refresh');
                    }
                });
            }
        }
    });
</script>

<script>
    $('#update_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if (confirm('Are you sure?Want to update.')) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                beforeSend: function() {
                    $('#update_btn').html('Please wait..');
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#update_result').html(result);
                    $('#update_result').show().delay(6000).fadeOut();
                    $('#update_btn').html('Submit');
                    $('#system-users').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#editSystemUserModal').modal('hide');
                    }, 3000);
                }
            });
        }
    });
</script>

<script>
    var changeCheckbox = document.querySelector('#create-goldsmithmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#is-create-goldsmithmaster').val(1);
        } else {
            $('#is-create-goldsmithmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-goldsmithmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#is-read-goldsmithmaster').val(1);
        } else {
            $('#is-read-goldsmithmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-goldsmithmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#is-update-goldsmithmaster').val(1);
        } else {
            $('#is-update-goldsmithmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-goldsmithmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-goldsmithmaster').val(1);
        } else {
            $('#is-delete-goldsmithmaster').val(0);
        }
    };
</script>
<script>
    var changeCheckbox = document.querySelector('#create-openmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-openmaster').val(1);
        } else {
            $('#is-create-openmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-openmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-openmaster').val(1);
        } else {
            $('#is-read-openmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-openmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-openmaster').val(1);
        } else {
            $('#is-update-openmaster').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-openmaster-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-openmaster').val(1);
        } else {
            $('#is-delete-openmaster').val(0);
        }
    };
</script>
<script>
    var changeCheckbox = document.querySelector('#create-dailytransaction-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-dailytransaction').val(1);
        } else {
            $('#is-create-dailytransaction').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-dailytransaction-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-dailytransaction').val(1);
        } else {
            $('#is-read-dailytransaction').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-dailytransaction-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-dailytransaction').val(1);
        } else {
            $('#is-update-dailytransaction').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-dailytransaction-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-dailytransaction').val(1);
        } else {
            $('#is-delete-dailytransaction').val(0);
        }
    };
    // var switchStatus = false;
</script>
<script>
    var changeCheckbox = document.querySelector('#create-suspenseaccount-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-suspenseaccount').val(1);
        } else {
            $('#is-create-suspenseaccount').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-suspenseaccount-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-suspenseaccount').val(1);
        } else {
            $('#is-read-suspenseaccount').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-suspenseaccount-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-suspenseaccount').val(1);
        } else {
            $('#is-update-suspenseaccount').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-suspenseaccount-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-suspenseaccount').val(1);
        } else {
            $('#is-delete-suspenseaccount').val(0);
        }
    };
    // var switchStatus = false;
</script>
<script>
    var changeCheckbox = document.querySelector('#create-transactionregister-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-transactionregister').val(1);
        } else {
            $('#is-create-transactionregister').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-transactionregister-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-transactionregister').val(1);
        } else {
            $('#is-read-transactionregister').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-transactionregister-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-transactionregister').val(1);
        } else {
            $('#is-update-transactionregister').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-transactionregister-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-transactionregister').val(1);
        } else {
            $('#is-delete-transactionregister').val(0);
        }
    };
    // var switchStatus = false;
</script>
<script>
    var changeCheckbox = document.querySelector('#create-dealerreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-dealerreport').val(1);
        } else {
            $('#is-create-dealerreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-dealerreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-dealerreport').val(1);
        } else {
            $('#is-read-dealerreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-dealerreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-dealerreport').val(1);
        } else {
            $('#is-update-dealerreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-dealerreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-dealerreport').val(1);
        } else {
            $('#is-delete-dealerreport').val(0);
        }
    };
    // var switchStatus = false;
</script>
<script>
    var changeCheckbox = document.querySelector('#create-areawisereport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-areawisereport').val(1);
        } else {
            $('#is-create-areawisereport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-areawisereport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-areawisereport').val(1);
        } else {
            $('#is-read-areawisereport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-areawisereport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-areawisereport').val(1);
        } else {
            $('#is-update-areawisereport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-areawisereport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-areawisereport').val(1);
        } else {
            $('#is-delete-areawisereport').val(0);
        }
    };
    // var switchStatus = false;
</script>
<script>
    var changeCheckbox = document.querySelector('#create-stockreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-create-stockreport').val(1);
        } else {
            $('#is-create-stockreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#read-stockreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-read-stockreport').val(1);
        } else {
            $('#is-read-stockreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#update-stockreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-update-stockreport').val(1);
        } else {
            $('#is-update-stockreport').val(0);
        }
    };
    var changeCheckbox = document.querySelector('#delete-stockreport-button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        // alert(changeCheckbox.checked);
        if ($(this).is(':checked')) {
            $('#is-delete-stockreport').val(1);
        } else {
            $('#is-delete-stockreport').val(0);
        }
    };
    // var switchStatus = false;
</script>

<script>
    window.actionEvents = {
        'click .edit-system-user': function(e, value, row, index) {
            permissions = row.permissions;
            permissions = JSON.parse(permissions);
            // console.log(permissions);
            $("#update_form").trigger("reset");


            $('#system_user_id').val(row.id);

            if (permissions.goldsmithmaster.create == 1) {
                // $('#permission-create-order-button').attr('checked', true);
                $('#permission-create-goldsmithmaster-button').prop('checked', true);
                $('#permission-is-create-goldsmithmaster').val(1);
            } else {
                $('#permission-create-goldsmithmaster-button').attr('checked', false);
                $('#permission-is-create-goldsmithmaster').val(0);
            }
            if (permissions.goldsmithmaster.read == 1) {
                $('#permission-read-goldsmithmaster-button').attr('checked', true);
                $('#permission-is-read-goldsmithmaster').val(1);
            } else {
                $('#permission-read-goldsmithmaster-button').attr('checked', false);
                $('#permission-is-read-goldsmithmaster').val(0);
            }
            if (permissions.goldsmithmaster.update == 1) {
                $('#permission-update-goldsmithmaster-button').attr('checked', true);
                $('#permission-is-update-goldsmithmaster').val(1);
            } else {
                $('#permission-update-goldsmithmaster-button').attr('checked', false);
                $('#permission-is-update-goldsmithmaster').val(0);
            }
            if (permissions.goldsmithmaster.delete == 1) {
                $('#permission-delete-goldsmithmaster-button').attr('checked', true);
                $('#permission-is-delete-goldsmithmaster').val(1);
            } else {
                $('#permission-delete-goldsmithmaster-button').attr('checked', false);
                $('#permission-is-delete-goldsmithmaster').val(0);
            }

            if (permissions.openmaster.create == 1) {
                $('#permission-create-openmaster-button').attr('checked', true);
                $('#permission-is-create-openmaster').val(1);
            } else {
                $('#permission-create-openmaster-button').attr('checked', false);
                $('#permission-is-create-openmaster').val(0);
            }
            if (permissions.openmaster.read == 1) {
                $('#permission-read-openmaster-button').attr('checked', true);
                $('#permission-is-read-openmaster').val(1);
            } else {
                $('#permission-read-openmaster-button').attr('checked', false);
                $('#permission-is-read-openmaster').val(0);
            }
            if (permissions.openmaster.update == 1) {
                $('#permission-update-openmaster-button').attr('checked', true);
                $('#permission-is-update-openmaster').val(1);
            } else {
                $('#permission-update-openmaster-button').attr('checked', false);
                $('#permission-is-update-openmaster').val(0);
            }
            if (permissions.openmaster.delete == 1) {
                $('#permission-delete-openmaster-button').attr('checked', true);
                $('#permission-is-delete-openmaster').val(1);
            } else {
                $('#permission-delete-openmaster-button').attr('checked', false);
                $('#permission-is-delete-openmaster').val(0);
            }
            if (permissions.dailytransaction.create == 1) {
                $('#permission-create-dailytransaction-button').attr('checked', true);
                $('#permission-is-create-dailytransaction').val(1);
            } else {
                $('#permission-create-dailytransaction-button').attr('checked', false);
                $('#permission-is-create-dailytransaction').val(0);
            }
            if (permissions.dailytransaction.read == 1) {
                $('#permission-read-dailytransaction-button').attr('checked', true);
                $('#permission-is-read-dailytransaction').val(1);
            } else {
                $('#permission-read-dailytransaction-button').attr('checked', false);
                $('#permission-is-read-dailytransaction').val(0);
            }
            if (permissions.dailytransaction.update == 1) {
                $('#permission-update-dailytransaction-button').attr('checked', true);
                $('#permission-is-update-dailytransaction').val(1);
            } else {
                $('#permission-update-dailytransaction-button').attr('checked', false);
                $('#permission-is-update-dailytransaction').val(0);
            }
            if (permissions.dailytransaction.delete == 1) {
                $('#permission-delete-dailytransaction-button').attr('checked', true);
                $('#permission-is-delete-dailytransaction').val(1);
            } else {
                $('#permission-delete-dailytransaction-button').attr('checked', false);
                $('#permission-is-delete-dailytransaction').val(0);
            }


            if (permissions.suspenseaccount.create == 1) {
                $('#permission-create-suspenseaccount-button').attr('checked', true);
                $('#permission-is-create-suspenseaccount').val(1);
            } else {
                $('#permission-create-suspenseaccount-button').attr('checked', false);
                $('#permission-is-create-suspenseaccount').val(0);
            }
            if (permissions.suspenseaccount.read == 1) {
                $('#permission-read-suspenseaccount-button').attr('checked', true);
                $('#permission-is-read-suspenseaccount').val(1);
            } else {
                $('#permission-read-suspenseaccount-button').attr('checked', false);
                $('#permission-is-read-suspenseaccount').val(0);
            }
            if (permissions.suspenseaccount.update == 1) {
                $('#permission-update-suspenseaccount-button').attr('checked', true);
                $('#permission-is-update-suspenseaccount').val(1);
            } else {
                $('#permission-update-suspenseaccount-button').attr('checked', false);
                $('#permission-is-update-suspenseaccount').val(0);
            }
            if (permissions.suspenseaccount.delete == 1) {
                $('#permission-delete-suspenseaccount-button').attr('checked', true);
                $('#permission-is-delete-suspenseaccount').val(1);
            } else {
                $('#permission-delete-suspenseaccount-button').attr('checked', false);
                $('#permission-is-delete-suspenseaccount').val(0);
            }

            if (permissions.transactionregister.create == 1) {
                $('#permission-create-transactionregister-button').attr('checked', true);
                $('#permission-is-create-transactionregister').val(1);
            } else {
                $('#permission-create-transactionregister-button').attr('checked', false);
                $('#permission-is-create-transactionregister').val(0);
            }
            if (permissions.transactionregister.read == 1) {
                $('#permission-read-transactionregister-button').attr('checked', true);
                $('#permission-is-read-transactionregister').val(1);
            } else {
                $('#permission-read-transactionregister-button').attr('checked', false);
                $('#permission-is-read-transactionregister').val(0);
            }
            if (permissions.transactionregister.update == 1) {
                $('#permission-update-transactionregister-button').attr('checked', true);
                $('#permission-is-update-transactionregister').val(1);
            } else {
                $('#permission-update-transactionregister-button').attr('checked', false);
                $('#permission-is-update-transactionregister').val(0);
            }
            if (permissions.transactionregister.delete == 1) {
                $('#permission-delete-transactionregister-button').attr('checked', true);
                $('#permission-is-delete-transactionregister').val(1);
            } else {
                $('#permission-delete-transactionregister-button').attr('checked', false);
                $('#permission-is-delete-transactionregister').val(0);
            }


            if (permissions.dealerreport.create == 1) {
                $('#permission-create-dealerreport-button').attr('checked', true);
                $('#permission-is-create-dealerreport').val(1);
            } else {
                $('#permission-create-dealerreport-button').attr('checked', false);
                $('#permission-is-create-dealerreport').val(0);
            }
            if (permissions.dealerreport.read == 1) {
                $('#permission-read-dealerreport-button').attr('checked', true);
                $('#permission-is-read-dealerreport').val(1);
            } else {
                $('#permission-read-dealerreport-button').attr('checked', false);
                $('#permission-is-read-dealerreport').val(0);
            }
            if (permissions.dealerreport.update == 1) {
                $('#permission-update-dealerreport-button').attr('checked', true);
                $('#permission-is-update-dealerreport').val(1);
            } else {
                $('#permission-update-dealerreport-button').attr('checked', false);
                $('#permission-is-update-dealerreport').val(0);
            }
            if (permissions.dealerreport.delete == 1) {
                $('#permission-delete-dealerreport-button').attr('checked', true);
                $('#permission-is-delete-dealerreport').val(1);
            } else {
                $('#permission-delete-dealerreport-button').attr('checked', false);
                $('#permission-is-delete-dealerreport').val(0);
            }


            if (permissions.areawisereport.create == 1) {
                $('#permission-create-areawisereport-button').attr('checked', true);
                $('#permission-is-create-areawisereport').val(1);
            } else {
                $('#permission-create-areawisereport-button').attr('checked', false);
                $('#permission-is-create-areawisereport').val(0);
            }
            if (permissions.areawisereport.read == 1) {
                $('#permission-read-areawisereport-button').attr('checked', true);
                $('#permission-is-read-areawisereport').val(1);
            } else {
                $('#permission-read-areawisereport-button').attr('checked', false);
                $('#permission-is-read-areawisereport').val(0);
            }
            if (permissions.areawisereport.update == 1) {
                $('#permission-update-areawisereport-button').attr('checked', true);
                $('#permission-is-update-areawisereport').val(1);
            } else {
                $('#permission-update-areawisereport-button').attr('checked', false);
                $('#permission-is-update-areawisereport').val(0);
            }
            if (permissions.areawisereport.delete == 1) {
                $('#permission-delete-areawisereport-button').attr('checked', true);
                $('#permission-is-delete-areawisereport').val(1);
            } else {
                $('#permission-delete-areawisereport-button').attr('checked', false);
                $('#permission-is-delete-areawisereport').val(0);
            }

            if (permissions.stockreport.create == 1) {
                $('#permission-create-stockreport-button').attr('checked', true);
                $('#permission-is-create-stockreport').val(1);
            } else {
                $('#permission-create-stockreport-button').attr('checked', false);
                $('#permission-is-create-stockreport').val(0);
            }
            if (permissions.stockreport.read == 1) {
                $('#permission-read-stockreport-button').attr('checked', true);
                $('#permission-is-read-stockreport').val(1);
            } else {
                $('#permission-read-stockreport-button').attr('checked', false);
                $('#permission-is-read-stockreport').val(0);
            }
            if (permissions.stockreport.update == 1) {
                $('#permission-update-stockreport-button').attr('checked', true);
                $('#permission-is-update-stockreport').val(1);
            } else {
                $('#permission-update-stockreport-button').attr('checked', false);
                $('#permission-is-update-stockreport').val(0);
            }
            if (permissions.stockreport.delete == 1) {
                $('#permission-delete-stockreport-button').attr('checked', true);
                $('#permission-is-delete-stockreport').val(1);
            } else {
                $('#permission-delete-stockreport-button').attr('checked', false);
                $('#permission-is-delete-stockreport').val(0);
            }


        }
    }
    //   var changeCheckbox = document.querySelector('#permission-create-order-button');
    // var init = new Switchery(changeCheckbox);
    // changeCheckbox.onchange = function() {
    //     if ($(this).is(':checked')) {
    //         $('#permission-is-create-order').val(1);
    //     }else{
    //         $('#permission-is-create-order').val(0);
    //     }
    // };
    $('#permission-create-goldsmithmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-goldsmithmaster').val(1);
        } else {
            $('#permission-is-create-goldsmithmaster').val(0);
        }
    });
    $('#permission-read-goldsmithmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-goldsmithmaster').val(1);
        } else {
            $('#permission-is-read-goldsmithmaster').val(0);
        }
    });
    $('#permission-update-goldsmithmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-goldsmithmaster').val(1);
        } else {
            $('#permission-is-update-goldsmithmaster').val(0);
        }
    });
    $('#permission-delete-goldsmithmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-goldsmithmaster').val(1);
        } else {
            $('#permission-is-delete-goldsmithmaster').val(0);
        }
    });


    $('#permission-create-openmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-openmaster').val(1);
        } else {
            $('#permission-is-create-openmaster').val(0);
        }
    });
    $('#permission-read-openmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-openmaster').val(1);
        } else {
            $('#permission-is-read-openmaster').val(0);
        }
    });
    $('#permission-update-openmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-openmaster').val(1);
        } else {
            $('#permission-is-update-openmaster').val(0);
        }
    });
    $('#permission-delete-openmaster-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-openmaster').val(1);
        } else {
            $('#permission-is-delete-openmaster').val(0);
        }
    });


    $('#permission-create-dailytransaction-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-dailytransaction').val(1);
        } else {
            $('#permission-is-create-dailytransaction').val(0);
        }
    });
    $('#permission-read-dailytransaction-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-dailytransaction').val(1);
        } else {
            $('#permission-is-read-dailytransaction').val(0);
        }
    });
    $('#permission-update-dailytransaction-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-dailytransaction').val(1);
        } else {
            $('#permission-is-update-dailytransaction').val(0);
        }
    });
    $('#permission-delete-dailytransaction-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-dailytransaction').val(1);
        } else {
            $('#permission-is-delete-dailytransaction').val(0);
        }
    });

    $('#permission-create-suspenseaccount-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-suspenseaccount').val(1);
        } else {
            $('#permission-is-create-suspenseaccount').val(0);
        }
    });
    $('#permission-read-suspenseaccount-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-suspenseaccount').val(1);
        } else {
            $('#permission-is-read-suspenseaccount').val(0);
        }
    });
    $('#permission-update-suspenseaccount-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-suspenseaccount').val(1);
        } else {
            $('#permission-is-update-suspenseaccount').val(0);
        }
    });
    $('#permission-delete-suspenseaccount-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-suspenseaccount').val(1);
        } else {
            $('#permission-is-delete-suspenseaccount').val(0);
        }
    });



    $('#permission-create-transactionregister-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-transactionregister').val(1);
        } else {
            $('#permission-is-create-transactionregister').val(0);
        }
    });
    $('#permission-read-transactionregister-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-transactionregister').val(1);
        } else {
            $('#permission-is-read-transactionregister').val(0);
        }
    });
    $('#permission-update-transactionregister-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-transactionregister').val(1);
        } else {
            $('#permission-is-update-transactionregister').val(0);
        }
    });
    $('#permission-delete-transactionregister-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-transactionregister').val(1);
        } else {
            $('#permission-is-delete-transactionregister').val(0);
        }
    });


    $('#permission-create-dealerreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-dealerreport').val(1);
        } else {
            $('#permission-is-create-dealerreport').val(0);
        }
    });
    $('#permission-read-dealerreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-dealerreport').val(1);
        } else {
            $('#permission-is-read-dealerreport').val(0);
        }
    });
    $('#permission-update-dealerreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-dealerreport').val(1);
        } else {
            $('#permission-is-update-dealerreport').val(0);
        }
    });
    $('#permission-delete-dealerreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-dealerreport').val(1);
        } else {
            $('#permission-is-delete-dealerreport').val(0);
        }
    });


    $('#permission-create-areawisereport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-areawisereport').val(1);
        } else {
            $('#permission-is-create-areawisereport').val(0);
        }
    });
    $('#permission-read-areawisereport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-areawisereport').val(1);
        } else {
            $('#permission-is-read-areawisereport').val(0);
        }
    });
    $('#permission-update-areawisereport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-areawisereport').val(1);
        } else {
            $('#permission-is-update-areawisereport').val(0);
        }
    });
    $('#permission-delete-areawisereport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-areawisereport').val(1);
        } else {
            $('#permission-is-delete-areawisereport').val(0);
        }
    });



    $('#permission-create-stockreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-create-stockreport').val(1);
        } else {
            $('#permission-is-create-stockreport').val(0);
        }
    });
    $('#permission-read-stockreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-read-stockreport').val(1);
        } else {
            $('#permission-is-read-stockreport').val(0);
        }
    });
    $('#permission-update-stockreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-update-stockreport').val(1);
        } else {
            $('#permission-is-update-stockreport').val(0);
        }
    });
    $('#permission-delete-stockreport-button').change(function() {
        if ($(this).is(':checked')) {
            $('#permission-is-delete-stockreport').val(1);
        } else {
            $('#permission-is-delete-stockreport').val(0);
        }
    });


</script>
<script>
    $(document).on('click', '.delete-system-user', function() {
        if (confirm('Are you sure? Want to delete system user.')) {
            id = $(this).data("id");
            $.ajax({
                url: 'public/db-operation.php',
                type: "get",
                data: 'id=' + id + '&delete_system_user=1',
                success: function(result) {
                    if (result == 0) {
                        $('#system-users').bootstrapTable('refresh');
                    } else {
                        alert('Error! System user could not be deleted.');
                    }

                }
            });
        }
    });
</script>