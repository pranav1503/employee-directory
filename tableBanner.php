<?php
  include 'isTable.php';
  $s3_config = include 's3_config.php';
 ?>

<div class="w-100" style="height:50%;background-color:blue">
  <div class="container" style="color:white;padding-top:50px;padding-bottom:50px;">
    <?php if(!$table_present){ ?>
    <h3>DynamoDb: </h3>
    <p>Table employee_directory not present.</p>
  <?php } ?>
  <br>
  <?php if(!$isBucket){ ?>
  <h3>S3: </h3>
  <p>S3 Bucket <?php echo $s3_config['bucket']; ?> not present.</p>
  <?php } ?>
  </div>
</div>
