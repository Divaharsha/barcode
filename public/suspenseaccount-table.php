<section class="content-header">
    <h1>
        Suspense Account/
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>

    
</section>
<?php
if ($permissions['suspenseaccount']['read'] == 1) {
?>
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Type </h4>
                                <select id='type' name="type" class='form-control'>
                                        <option value="Weight">Weight</option>
                                        <option value="Cash">Cash</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title"> </h4>
                                <a class="btn btn-block btn-primary" href="add-suspense.php"><i class="fa fa-plus-square"></i> Add Weight</a>
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title"> </h4>
                                <a class="btn btn-block btn-success" href="add-suspense-cash.php"><i class="fa fa-money"></i>  Add Cash</a>
                            </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=suspense_account" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-show-footer="true" data-footer-style="footerStyle" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    
                                    <th data-field="name" data-footer-formatter="priceFormatterlabel">Total</th>  
                                    <th data-field="total" data-footer-formatter="priceFormatter">Total</th>     
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view suspense account.</div>
<?php } ?>
<script>

   
    $('#total').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#type').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "type": $('#type').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    function priceFormatter(data) {
        var field = this.field
        return '<span style="color:green;font-weight:bold;font-size:large;"> <?= $settings['currency'] ?> ' + data.map(function(row) {
                return +row[field]
            })
            .reduce(function(sum, i) {
                return sum + i
            }, 0);
    }
    function priceFormatterlabel(data) {
        var field = this.field
        return '<span style="color:green;font-weight:bold;font-size:large;"> Total';
    }
</script>
