<section class="content-header">
    <h1>
        Transaction Register /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
</section>
<?php
if ($permissions['transactionregister']['read'] == 1) {
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
                            <h4 class="box-title">Filter by Name </h4>
                            <select id='gm_id' name="gm_id" class='form-control' required>
                            <option value=''>Any</option>
                                        <?php
                                        $sql = "SELECT * FROM `goldsmith_master`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
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
                                        $sql = "SELECT * FROM `goldsmith_master` WHERE place != '' GROUP BY `place`";
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
                            <input type="date" class="form-control" name="fromdate" id="fromdate" />
                        </div>
                        <div class="form-group col-md-3">
                            <h4 class="box-title">To Date </h4>
                            <input type="date" class="form-control" name="todate" id="todate" />
                        </div>

                    </div>
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=transactionregister" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{
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
    <?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view transaction register.</div>
<?php } ?>
<script>
    $('#gm_id').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    $('#type').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#gm_id').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#particular').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#place').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#fromdate').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#todate').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "type": $('#type').val(),
            "place": $('#place').val(),
            "gm_id": $('#gm_id').val(),
            "particular": $('#particular').val(),
            "fromdate": $('#fromdate').val(),
            "todate": $('#todate').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
