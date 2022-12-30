<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
$ID='1';
if (isset($_POST['btnUpdate'])) {

    $day_electricity_meter_reading = $db->escapeString(($_POST['day_electricity_meter_reading']));
    $night_electricity_meter_reading = $db->escapeString(($_POST['night_electricity_meter_reading']));
    $day_gas_meter_reading = $db->escapeString(($_POST['day_gas_meter_reading']));
    $error = array();
    
   
    if (empty($day_electricity_meter_reading)) {
        $error['day_electricity_meter_reading'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($night_electricity_meter_reading)) {
        $error['night_electricity_meter_reading'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($day_gas_meter_reading)) {
        $error['day_gas_meter_reading'] = " <span class='label label-danger'>Required!</span>";
    }
   
       
    
    if (!empty($day_electricity_meter_reading) && !empty($night_electricity_meter_reading) && !empty($day_gas_meter_reading)) {
           
            $sql_query = "UPDATE settings SET day_electricity_meter_reading='$day_electricity_meter_reading',night_electricity_meter_reading='$night_electricity_meter_reading',day_gas_meter_reading='$day_gas_meter_reading' WHERE id=1";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['update'] = "<section class='content-header'>
                                                <span class='label label-success'>Setting Detail Updated Successfully</span> </section>";
            } else {
                $error['update'] = " <span class='label label-danger'>Failed</span>";
            }
        }
    }

    // create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM settings WHERE id = 1";
$db->sql($sql_query);
$res = $db->getResult();
?>
<section class="content-header">
<h1>Settings <small><a href='home.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Home</a></small></h1>  
  <?php echo isset($error['update']) ? $error['update'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Settings</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="delivery_charge" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                         <div class="row">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1"> Electricity meter reading (Day)</label> <i class="text-danger asterik">*</i><?php echo isset($error['day_electricity_meter_reading']) ? $error['day_electricity_meter_reading'] : ''; ?>
                                        <input type="number" class="form-control" name="day_electricity_meter_reading" value="<?= $res[0]['day_electricity_meter_reading']; ?>" required>
                                    </div>
                              </div>
                         </div>
                         <br>
                         <div class="row">
                            <div class="form-group">
                                   <div class="col-md-8">
                                        <label for="exampleInputEmail1">Electricity meter reading (Night)</label> <i class="text-danger asterik">*</i><?php echo isset($error['night_electricity_meter_reading']) ? $error['night_electricity_meter_reading'] : ''; ?>
                                        <input type="number" class="form-control" name="night_electricity_meter_reading" value="<?= $res[0]['night_electricity_meter_reading']; ?>" required>
                                    </div>
                            </div>
                         </div>
                         <br>
                         <div class="row">
                            <div class="form-group">
                                   <div class="col-md-8">
                                        <label for="exampleInputEmail1">Gas meter reading (Day)</label> <i class="text-danger asterik">*</i><?php echo isset($error['day_gas_meter_reading']) ? $error['day_gas_meter_reading'] : ''; ?>
                                        <input type="number" class="form-control" name="day_gas_meter_reading" value="<?= $res[0]['day_gas_meter_reading']; ?>" required>
                                    </div>
                            </div>
                         </div>        
                           
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>