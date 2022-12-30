<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();

?>
<?php
if (isset($_POST['btnAdd'])) {

        $amount = $db->escapeString(($_POST['amount']));
        $number = mt_rand(10000000, 99999999);
        $evc_code = sprintf("%08d", $number);
        $error = array();
       
        if (empty($amount)) {
            $error['amount'] = " <span class='label label-danger'>Required!</span>";
        }
     
       
       
       if (!empty($amount)) 
       {
           
            $sql_query = "INSERT INTO evc_codes (amount,evc_code)VALUES('$amount','$evc_code')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['generate_code'] = "<section class='content-header'>
                                                <span class='label label-success'>EVC Code Generated Successfully</span> </section>";
            } else {
                $error['generate_code'] = " <span class='label label-danger'>Failed to Generate</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Generate Evc Code <small><a href='evc_codes.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Gnerate Evc Codes</a></small></h1>
    <?php echo isset($error['generate_code']) ? $error['generate_code'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id='generate_code_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                                <label for="exampleInputEmail1">Amount</label> <i class="text-danger asterik">*</i><?php echo isset($error['amount']) ? $error['amount'] : ''; ?>
                                <input type="number" class="form-control" name="amount" required>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Generate Evc Code</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
     $('#generate_code_form').validate({
            ignore: [],
            debug: false,
            rules: {
                amount: "required",
            }
     });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>