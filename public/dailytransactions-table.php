<section class="content-header">
    <h1>
        Daily Transactions /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-dailytransactions.php"><i class="fa fa-plus-square"></i> Add New Daily Transaction</a>
    </ol>

    
</section>
<?php
if ($permissions['dailytransaction']['read'] == 1) {
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
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=daily_transaction" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="goldsmith_master_name" data-sortable="true">Goldsmith Master Name</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="type" data-sortable="true">Type</th>
                                    <th data-field="subcategory" data-sortable="true">Subcategory</th>
                                    <th data-field="weight" data-sortable="true">Weight</th>
                                    <th data-field="stone_weight" data-sortable="true">Stone Weight</th>
                                    <th data-field="wastage" data-sortable="true">Wastage</th>
                                    <th data-field="touch" data-sortable="true">Touch</th>
                                    <th data-field="rate" data-sortable="true">Rate</th>
                                    <th data-field="gst" data-sortable="true">Gst</th>
                                    <th data-field="amount" data-sortable="true">Amount</th>
                                    <th data-field="mc" data-sortable="true">MC</th>
                                    <th data-field="purity" data-sortable="true">Purity</th>
                                    <th data-field="tds" data-sortable="true">TDS/TCS</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view daily transaction.</div>
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
