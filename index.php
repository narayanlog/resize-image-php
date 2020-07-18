<!DOCTYPE html>
<html>
   <head>
      <title>Image Upload and Resize Using PHP</title>
      <link rel="stylesheet" href="csss.css">
      <!-- Bootstrap Core Css -->
      <link href="css/bootstrap.css" rel="stylesheet" />
      <!-- Font Awesome Css -->
      <link href="css/font-awesome.min.css" rel="stylesheet" />
      <!-- Bootstrap Select Css -->
      <link href="css/bootstrap-select.css" rel="stylesheet" />
      <!-- Custom Css -->
      <link href="css/app_style.css" rel="stylesheet" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" type="text/css" href="styles.css" />
   </head>
   <body>
      <!-- Grid -->
      <div class="w3-row w3-padding w3-border">
      <!-- Blog entries -->
      <div class="w3-col l12 s12">
      <!-- Blog entry -->
      <div class="w3-container w3-white w3-margin w3-padding-large all-content-wrapper">
         <section class="container">
            <div class="form-group custom-input-space has-feedback">
               <div class="page-heading">
                  <h3 class="post-title">Upload and Resize an Image with PHP</h3>
               </div>
               <div class="page-body clearfix">
                  <div class="row">
                     <div class="col-md-offset-2 col-md-8">
                        <div class="panel panel-primary">
                           <div class="panel-heading">Image Upload and Resize it:</div>
                           <div class="panel-body">
                              <form action="" method="post" enctype="multipart/form-data">
                                 <div class="form-group col-md-3">
                                    <label class="required">Width</label>
                                    <input type="number" name="new_width" required />
                                 </div>
                                 <div class="form-group col-md-3">
                                    <label class="required">Height</label>
                                    <input type="number" name="new_height" required />
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label class="required">Choose Image</label>
                                    <input type="file" name="upload_image" class="custom-file-input" required />
                                 </div>
                                 <div style="text-align: center;">
                                    <script id="mNCC" language="javascript">
                                       medianet_width = "728";
                                       medianet_height = "90";
                                       medianet_crid = "655540672";
                                       medianet_versionId = "3111299"; 
                                    </script>
                                 </div>
                                 <input type="submit" name="form_submit" class="btn btn-primary" value="Submit"  style="
                                    margin-top: 25px;
                                    width: 100%;
                                    background-color: #1d91d2;
                                    "/>
                              </form>
                              <?php
                                 function resizeImage($resourceType,$image_width,$image_height,$resizeWidth,$resizeHeight) {
                                     // $resizeWidth = 100;
                                     // $resizeHeight = 100;
                                     $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
                                     imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
                                     return $imageLayer;
                                 }
                                 
                                 if(isset($_POST["form_submit"])) {
                                 	$imageProcess = 0;
                                     if(is_array($_FILES)) {
                                         $new_width = $_POST['new_width'];
                                         $new_height = $_POST['new_height'];
                                         $fileName = $_FILES['upload_image']['tmp_name'];
                                         $sourceProperties = getimagesize($fileName);
                                         $resizeFileName = time();
                                         $uploadPath = "./uploads/";
                                         $fileExt = pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION);
                                         $uploadImageType = $sourceProperties[2];
                                         $sourceImageWidth = $sourceProperties[0];
                                         $sourceImageHeight = $sourceProperties[1];
                                         switch ($uploadImageType) {
                                             case IMAGETYPE_JPEG:
                                                 $resourceType = imagecreatefromjpeg($fileName); 
                                                 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                                                 imagejpeg($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                                                 break;
                                 
                                             case IMAGETYPE_GIF:
                                                 $resourceType = imagecreatefromgif($fileName); 
                                                 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                                                 imagegif($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                                                 break;
                                 
                                             case IMAGETYPE_PNG:
                                                 $resourceType = imagecreatefrompng($fileName); 
                                                 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                                                 imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                                                 break;
                                 
                                             case IMAGETYPE_JPG:
                                                 $resourceType = imagecreatefrompng($fileName); 
                                                 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                                                 imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                                                 break;
                                 
                                             default:
                                                 $imageProcess = 0;
                                                 break;
                                         }
                                         move_uploaded_file($fileName, $uploadPath. $resizeFileName. ".". $fileExt);
                                         $imageProcess = 1;
                                     }
                                 
                                 	if($imageProcess == 1){
                                 	?>
                              <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
                                 <i class="fa fa-fw fa-check-circle"></i>
                                 <strong> Note !</strong> <span class="success-message">Image Resize Successfully </span>
                              </div>
                              <hr>
                              <div class="row">
                                 <div class="col-md-4">
                                    <img class="img-rounded img-responsive" src="<?php echo $uploadPath."thump_".$resizeFileName.'.'. $fileExt; ?>" width="<?php echo $new_width; ?>" height="<?php echo $new_height; ?>" >
                                    <h4><b>Thump Image</b></h4>
                                    <a href="<?php echo $uploadPath."thump_".$resizeFileName.'.'. $fileExt; ?>" download class="btn btn-danger"><i class="fa fa-download"></i> Download </a href="">
                                 </div>
                                 <div class="col-md-8">
                                    <img class="img-rounded img-responsive" src="<?php echo $uploadPath.$resizeFileName.'.'. $fileExt; ?>" >
                                    <h4><b>Original Image</b></h4>
                                 </div>
                              </div>
                              <?php
                                 }else{
                                 ?>
                              <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
                                 <i class="fa fa-fw fa-times-circle"></i>
                                 <strong> Note !</strong> <span class="warning-message">Invalid Image </span>
                              </div>
                              <?php
                                 }
                                 $imageProcess = 0;
                                 }
                                 ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <script src="js/jquery.min.js"></script>
      <!-- Bootstrap Core Js -->
      <script src="js/bootstrap.min.js"></script>
      <!-- Bootstrap Select Js -->
      <script src="js/bootstrap-select.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
   </body>
</html>