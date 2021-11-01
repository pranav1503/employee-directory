<?php
  $myfile = fopen("../s3_config.php", "w") or die("Unable to open file!");
  $bucket = $_POST['bucket'];
  $txt = "<?php
    return array('bucket' => '".$bucket."');
   ?>";
  fwrite($myfile, $txt);
  fclose($myfile);
?>
