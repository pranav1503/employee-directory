<?php
  require 'util/header.php';
  require 'dynamoDBUtil.php';
  require 'isTable.php';
  $s3_config = include('s3_config.php');
?>
<div class="container bg-light rounded-3" style="margin-top: 50px;height:500px;padding:50px;">
  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
      <h4>DynamoDB: <?php if($table_present){?><span style="color:green"><i class="far fa-check-circle"></i></span><?php } else {?>
        <span style="color:red"><i class="far fa-times-circle"></i></span><?php } ?>
      </h4>
      <?php if ($table_present) {
        echo "<p> Table employee_directory is present.</p>";
      }else{
      ?>
      <p>Table employee_directory not present. <button type="button" class="btn btn-warning" onclick="createTable()" name="button">Create</button></p>
    <?php } ?>
    <br><br>
    <h4>S3 Bucket: <?php if($isBucket){?><span style="color:green"><i class="far fa-check-circle"></i></span><?php } else {?>
      <span style="color:red"><i class="far fa-times-circle"></i></span><?php } ?>
    </h4>
    <div class="row">
      <div class="col-8">
          <input type="text" class="form-control" id="bucketVal" value="<?php echo $s3_config['bucket']; ?>" >
      </div>
      <div class="col-4">
          <button type="button" class="btn btn-warning" id="bucketValBtn">Change</button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <h4>EC2 Instance Details: </h4>
        <br>
        <?php try{
          $url = "http://169.254.169.254/latest/meta-data/instance-id";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $url);
          $res = curl_exec($ch);
          ?>
        <h5>Instance ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo  $res; ?> </h5>
        <br>
      <?php } catch(Exception $e) { echo "<h5>EC2 instance details not available.</h5>"; }?>
      </div>
    </div>
    </div>
    <div class="col-md-3">

    </div>
  </div>
</div>

<?php
  include 'util/footer.php';
?>

<script type="text/javascript">
document.getElementById ("bucketValBtn").addEventListener ("click", changeBucket, false);
function changeBucket() {
  $.ajax({
      url: "s3update/s3update.php",
      type: 'POST',
      data: {
        'bucket': $("#bucketVal").val()
      },
      success: function(){
        alert('S3 Bucket Changed')
        window.location.href = 'settings.php';
      },
      error: function() {
          alert("Server Down. Try again later.");
      }
  });
}
  function createTable() {
    $.ajax({
        url: "createTable.php",
        type: 'POST',
        success: function(result){
            if(result == "success"){
              alert("Table Created.");
            }else{
              alert("Table creation failed.");
            }
            window.location.href = "settings.php";
        },
        error: function() {
            alert("Server Down. Try again later.");
        }
    });
  }
</script>
