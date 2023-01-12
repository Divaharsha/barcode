<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM category ORDER BY id ASC";
$db->sql($sql_query);
$res = $db->getResult();

$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);
$res_cur = $db->getResult();

if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}
?>
<section class="content-header">
    <h1>Barcode</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-3 form-group">
                <button class="btn btn-primary text-center" id="generateBarcode">Generate</button>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3 form-group">
             <svg id="barcode"></svg>
        </div>

    </div>

    <div class="row no-print">
        <div class="col-xs-12">
            <form><button class="btn btn-primary text-center" type='button' value='Print this page' onclick='printpage();'><i class="fa fa-print"></i> Print</button>
            </form>
            <script>
               function printpage() {
                    document.getElementById("generateBarcode").style.display = "none"; // added this line

                    var is_chrome = function() {
                        return Boolean(window.chrome);
                    }
                    if (is_chrome) {
                        window.print();
                        setTimeout(function() {
                        window.close();
                        }, 1000);
                        //give them 10 seconds to print, then close
                    } else {
                        window.print();
                        window.close();
                    }
                }

            </script>
        </div>
    </div>
</section>
<div class="separator"> </div>

<script>
    const button = document.getElementById("generateBarcode");
    button.addEventListener("click", function() {
        JsBarcode("#barcode", "<?php echo $ID; ?>", {
            lineColor: "#120e0c",
            width: 4,
            height: 100,
            displayValue: true
            });
    });

</script>
