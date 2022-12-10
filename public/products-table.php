<section class="content-header">
    <h1>
       Products /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-product.php"><i class="fa fa-plus-square"></i> Add New Product</a>
    </ol>


</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12 col-xs-12">
                <div class="box">
                    <div class="box-header">
                                <div class="form-group col-md-4">
                                    <h4 class="box-title">Filter by Product Status </h4>
                                    <select id='status' name="status" class='form-control'>
                                            <option value="1">Approved</option>
                                            <option value="0">Not-Approved</option>
                                    </select>
                                </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                    <table id='products_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=products" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "products-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="subcategory_name" data-sortable="true">Sub-Category Name</th>
                                    <th data-field="goldsmith_name" data-sortable="true">Dealer Goldsmith Name</th>
                                    <th data-field="huid_number" data-sortable="true">HUID Number</th>
                                    <th data-field="gross_weight" data-sortable="true">Gross Weight</th>
                                    <th data-field="size" data-sortable="true">Size</th>
                                    <th data-field="stone_weight" data-sortable="true">Stone Weight</th>
                                    <th data-field="net_weight" data-sortable="true">Net Weight</th>
                                    <th data-field="wastage" data-sortable="true">Wastage</th>
                                    <th data-field="cover_weight" data-sortable="true">Cover Weight</th>
                                    <th data-field="image">Image</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
                                    <th data-field="update" data-events="actionEvents">Update</th>

             
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
       $('#status').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });


    function queryParams(p) {
        return {
            "status": $('#status').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
