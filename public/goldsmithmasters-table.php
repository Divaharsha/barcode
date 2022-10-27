<section class="content-header">
    <h1>
        Dealer Goldsmith Masters /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-goldsmithmaster.php"><i class="fa fa-plus-square"></i> Add New Goldsmith Master</a>
    </ol>


</section>
<?php
if ($permissions['goldsmithmaster']['read'] == 1) {
?>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=goldsmith_master" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="goldsmith_type" data-sortable="true">Goldsmith Type</th>
                                    <th data-field="mobile" data-sortable="true">Payment Mobile Number</th>
                                    <th data-field="digital_signature_number" data-sortable="true">Digital sign number</th>
                                    <th data-field="gst_number" data-sortable="true">GST Number</th>
                                    <th data-field="pan_number" data-sortable="true">PAN Number</th>
                                    <th data-field="open_cash_debit" data-sortable="true">Cash Debit</th>
                                    <th data-field="open_cash_credit" data-sortable="true">Cash Credit</th>
                                    <th data-field="open_pure_debit" data-sortable="true">Pure Debit</th>
                                    <th data-field="open_pure_credit" data-sortable="true">Pure Credit</th>
                                    <th data-field="email" data-sortable="true">Email Id</th>
                                    <th data-field="address" data-sortable="true">Address</th>
                                    <th data-field="place" data-sortable="true">Place</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
                                    <th data-field="update_touch" data-events="actionEvents">Update Touch</th>
             
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>
    <?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view goldsmith masters.</div>
<?php } ?>
<script>
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
