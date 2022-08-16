<section class="content-header">
    <h1>
        Dealer Ledger Report /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>

    
</section>
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
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Choose Type</h4>
                            <select id='sundry' name="sundry" class='form-control' required>
                                <option value='Debit'>Debit</option>
                                <option value='Credit'>Credit</option>
                            </select>
                        </div>

                    </div>
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=dealers" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="pure" data-sortable="true">Pure</th>
                                    <th data-field="cash" data-sortable="true">Cash</th>
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
