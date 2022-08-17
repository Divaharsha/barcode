<section class="content-header">
    <h1>
        Transaction Register /
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
                            <h4 class="box-title">Filter by Name </h4>
                            <select id='name' name="name" class='form-control' required>
                                        <?php
                                        $sql = "SELECT * FROM `goldsmith_master`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['name'] ?>'><?= $value['name'] ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Filter by Particular </h4>
                            <select id='particular' name="particular" class='form-control' required>
                                <option value=''>Any</option>
                                        <?php
                                        $sql = "SELECT * FROM `brand`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['category'] ?>'><?= $value['category'] ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Filter by Type </h4>
                            <select id='type' name="type" class='form-control' required>
                                <option value=''>Any</option>
                                        <?php
                                        $sql = "SELECT * FROM `types`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['type'] ?>'><?= $value['type'] ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Filter by Place </h4>
                            <select id='place' name="place" class='form-control' required>
                                <option value=''>Any</option>
                                        <?php
                                        $sql = "SELECT * FROM `goldsmith_master` GROUP BY `place`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['place'] ?>'><?= $value['place'] ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">From Date </h4>
                            <input type="date" class="form-control" name="fromdate" />
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">To Date </h4>
                            <input type="date" class="form-control" name="todate" />
                        </div>

                    </div>
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=transactionregister" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="type" data-sortable="true">Type</th>
                                    <th data-field="stone_weight" data-sortable="true">Stone</th>
                                    <th data-field="weight" data-sortable="true">Weight</th>
                                    <th data-field="touch" data-sortable="true">Touch</th>
                                    <th data-field="purity" data-sortable="true">Purity</th>
                                    <th data-field="rate" data-sortable="true">Rate</th>
                                    <th data-field="amount" data-sortable="true">Amount</th>
                                    <th data-field="mc" data-sortable="true">MC</th>
                                    
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
    $('#type').on('change', function() {
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
            "type": $('#type').val(),
            "name": $('#name').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
