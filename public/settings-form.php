<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
$ID='1';
if (isset($_POST['btnUpdate'])) {

    $app = $db->escapeString(($_POST['app']));
    $app_name = $db->escapeString(($_POST['app_name']));
    $developer_name = $db->escapeString(($_POST['developer_name']));
    $downloads_count = $db->escapeString(($_POST['downloads_count']));
    $ratings = $db->escapeString(($_POST['ratings']));
    $error = array();
    
   
    if (empty($app)) {
        $error['app'] = " <span class='label label-danger'>Required!</span>";
    }
   
       
    
    if (!empty($app)) {

         //image1
         if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1'])){

             $old_image = $db->escapeString($_POST['old_image']);
             $extension = pathinfo($_FILES["image1"]["name"])['extension'];
             $new_image = $ID . "." . $extension;
             

             $result = $fn->validate_image($_FILES["image1"]);
             $target_path = 'upload/images/';
             
             $filename = microtime(true) . '.' . strtolower($extension);
             $full_path = $target_path . "" . $filename;
             if (!move_uploaded_file($_FILES["image1"]["tmp_name"], $full_path)) {
                 echo '<p class="alert alert-danger">Can not upload image.</p>';
                 return false;
                 exit();
             }
             if (!empty($old_image1)) {
                 unlink( $old_image1);
             }
             $upload_image1 = 'upload/images/' . $filename;
             $sql = "UPDATE settings SET image1='$upload_image1' WHERE id =  $ID";
             $db->sql($sql);
         }

           //image2
         if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0 && !empty($_FILES['image2'])){

             $old_image = $db->escapeString($_POST['old_image']);
             $extension = pathinfo($_FILES["image2"]["name"])['extension'];
             $new_image = $ID . "." . $extension;
             

             $result = $fn->validate_image($_FILES["image2"]);
             $target_path = 'upload/images/';
             
             $filename = microtime(true) . '.' . strtolower($extension);
             $full_path = $target_path . "" . $filename;
             if (!move_uploaded_file($_FILES["image2"]["tmp_name"], $full_path)) {
                 echo '<p class="alert alert-danger">Can not upload image.</p>';
                 return false;
                 exit();
             }
             if (!empty($old_image2)) {
                 unlink( $old_image2);
             }
             $upload_image2 = 'upload/images/' . $filename;
             $sql = "UPDATE settings SET image2='$upload_image2' WHERE id =  $ID";
             $db->sql($sql);
         }
          
         //image3
         if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0 && !empty($_FILES['image3'])) {
             $old_image = $db->escapeString($_POST['old_image']);
             $extension = pathinfo($_FILES["image3"]["name"])['extension'];
             $new_image = $ID . "." . $extension;
             

             $result = $fn->validate_image($_FILES["image3"]);
             $target_path = 'upload/images/';
             
             $filename = microtime(true) . '.' . strtolower($extension);
             $full_path = $target_path . "" . $filename;
             if (!move_uploaded_file($_FILES["image3"]["tmp_name"], $full_path)) {
                 echo '<p class="alert alert-danger">Can not upload image.</p>';
                 return false;
                 exit();
             }
             if (!empty($old_image3)) {
                 unlink( $old_image3);
             }
             $upload_image3 = 'upload/images/' . $filename;
             $sql = "UPDATE settings SET image3='$upload_image3' WHERE id =  $ID";
             $db->sql($sql);
         }

         //image
         if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])){
          
            $old_image = $db->escapeString($_POST['old_image']);
             $extension = pathinfo($_FILES["image"]["name"])['extension'];
             $new_image = $ID . "." . $extension;
             

             $result = $fn->validate_image($_FILES["image"]);
             $target_path = 'upload/images/';
             
             $filename = microtime(true) . '.' . strtolower($extension);
             $full_path = $target_path . "" . $filename;
             if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
                 echo '<p class="alert alert-danger">Can not upload image.</p>';
                 return false;
                 exit();
             }
             if (!empty($old_image)) {
                 unlink( $old_image);
             }
             $upload_image = 'upload/images/' . $filename;
             $sql = "UPDATE settings SET `image`='$upload_image' WHERE id = $ID";
             $db->sql($sql);
         }
           
            $sql_query = "UPDATE settings SET app='$app',app_name='$app_name',developer_name='$developer_name',ratings='$ratings',downloads_count='$downloads_count' WHERE id=1";
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
        <div class="col-md-12">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Settings</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="delivery_charge" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" id="old_image1" name="old_image"  value="<?= $res[0]['image1']; ?>">
                        <input type="hidden" id="old_image2" name="old_image"  value="<?= $res[0]['image2']; ?>">
                        <input type="hidden" id="old_image3" name="old_image"  value="<?= $res[0]['image3']; ?>">
                         <div class="row">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label for="exampleInputEmail1">App Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['app_name']) ? $error['app_name'] : ''; ?>
                                        <input type="text" class="form-control" name="app_name" value="<?= $res[0]['app_name']; ?>" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="exampleInputEmail1">Mobile Application (APK)</label> <i class="text-danger asterik">*</i><?php echo isset($error['app']) ? $error['app'] : ''; ?>
                                        <input type="text" class="form-control" name="app" value="<?= $res[0]['app']; ?>" required>
                                    </div>
                              </div>
                         </div>
                         <br>
                         <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Developer Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['developer_name']) ? $error['developer_name'] : ''; ?>
                                        <input type="text" class="form-control" name="developer_name" value="<?= $res[0]['developer_name']; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Ratings</label> <i class="text-danger asterik">*</i><?php echo isset($error['ratings']) ? $error['ratings'] : ''; ?>
                                        <input type="text" class="form-control" name="ratings" value="<?= $res[0]['ratings']; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Downloads</label> <i class="text-danger asterik">*</i><?php echo isset($error['downloads_count']) ? $error['downloads_count'] : ''; ?>
                                        <input type="text" class="form-control" name="downloads_count" value="<?= $res[0]['downloads_count']; ?>" required>
                                    </div>
                              </div>
                         </div>
                         <br>
                         <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                        <label for="exampleInputFile">App Logo</label> 
                                            <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                            <p class="help-block"><img id="blah" src="<?php echo $res[0]['image']; ?>" style="max-width:100%" /></p>
                                </div>
                            </div>
                         </div>
                         <br>
                         <div class="row">
                            <div class="form-group">
                               <div class='col-md-3'>
                                       <label for="exampleInputFile">Screenshot Image1</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image1" id="image1">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image1']; ?>" style="max-width:50%;padding:4px;" /></p>
                                </div>
                               <div class='col-md-3'>
                                       <label for="exampleInputFile">Screenshot Image2</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image2" id="image2">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image2']; ?>" style="max-width:50%;padding:4px;" /></p>
                                </div>
                                <div class='col-md-3'>
                                       <label for="exampleInputFile">Screenshot Image3</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image3" id="image3">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image3']; ?>" style="max-width:50%;padding:4px;"/></p>
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