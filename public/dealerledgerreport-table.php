<section class="content-header">
    <h1>
        Dealer Ledger Report /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>

    
</section>
<?php
if ($permissions['dealerreport']['read'] == 1) {
?>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Choose Sundry</h4>
                            <select id='sundry' name="sundry" class='form-control' required>
                                <option value='Sundry Debitors'>Sundry Debitors</option>
                                <option value='Sundry Creditors'>Sundry Creditors</option>
                            </select>
                        </div>

                    </div>
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=dealerledger" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="sundry" data-sortable="true">Type</th>
                                    <th data-field="open_debit" data-sortable="true">Open Debit</th>
                                    <th data-field="open_credit" data-sortable="true">Open Credit</th>
                                    <th data-field="pure_debit" data-sortable="true">Pure Debit</th>
                                    <th data-field="pure_credit" data-sortable="true">Pure Credit</th>
                                    <th data-field="operate">Action</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view dealer ledger report.</div>
<?php } ?>
<script>
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#name').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    $('#sundry').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#name').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            "sundry": $('#sundry').val(),
            "name": $('#name').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
