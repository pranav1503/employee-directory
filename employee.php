<?php
  include 'util/header.php';
  require 'dynamoDBUtil.php';
  require 's3Util.php';

  if(!array_key_exists('id', $_GET)){
    header("Location: index.php");
    exit;
  }
  $tableName = 'employee_directory';
  $bucket = 'employee-directory-pr-0001';
  $id = $_GET['id'];
  $key = $marshaler->marshalJson('
    {
        "id": "' . $id . '"
    }
  ');

  $params = [
    'TableName' => $tableName,
    'Key'       => $key
  ];
  try {
    $result = $dynamodb->getItem($params);
    $employee = $result["Item"];
    $employee = $marshaler->unmarshalItem($employee);
?>
  <div class="container" style="margin-top:50px;">
    <div class="row">
      <div class="col-md-3">

      </div>
      <div class="col-md-6" style="padding:20px; border: 1px solid black; border-radius: 10px;">
        <h2>Employee Details</h2>
        <hr>
        <form id="form" method="post" style="margin-top:20px" onsubmit="addEmployee(); return false">
          <div class="row">
            <div class="col-md mb-3">
              <label for="exampleInputEmail1" class="form-label">Name *</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="First name" aria-label="Name" required value="<?php echo $employee['name']; ?>">
            </div>
            <div class="col-md mb-3">
              <label for="exampleInputEmail1" class="form-label">Designation *</label>
              <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" aria-label="Designation" required value="<?php echo $employee['designation']; ?>">
            </div>
          </div>
          <div class="mb-3">
            <label for="emailID" class="form-label">Email address *</label>
            <input type="email" class="form-control" id="emailID" name="emailID" placeholder="Email Address" aria-describedby="emailHelp" disabled value="<?php echo $employee['email']; ?>">
          </div>
          <?php
              $is_photo = !empty($employee['photo']);
              if($is_photo){
                $cmd = $s3Client->getCommand('GetObject', [
                  'Bucket' => $bucket,
                  'Key' => $employee['photo']
                ]);
                $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

                // Get the actual presigned-url
                $presignedUrl = (string)$request->getUri();
           ?>
           <img src="<?php echo $presignedUrl ?>" alt="" style="height:100px;width: 100px;">
         <?php } ?>
          <div class="mb-3">
            <label for="formFile" class="form-label">Upload Photo</label>
            <input class="form-control" type="file" id="formFile" name="file" accept=".jpg,.png">
          </div>
          <button type="submit" class="btn btn-success">Update</button>
          <a class="btn btn-danger" href="index.php">Delete</a>
          <a class="btn btn-secondary" href="index.php">Cancel</a>
        </form>
      </div>
      <div class="col-md-3">

      </div>
    </div>
  </div>

<?php
  } catch (DynamoDbException $e) {
      echo "Unable to get item:\n";
      echo $e->getMessage() . "\n";
  }
 ?>

<?php
  include 'util/footer.php';
?>

<script type="text/javascript">
  function addEmployee() {
    try{
      var file = $('#formFile').prop('files');
      var form_data = new FormData();
      if(file.length != 0){
          form_data.append('photo', file[0]);
      }
      var name = $('#name').val();
      var designation = $('#designation').val();
      var emailID = $('#emailID').val();
      form_data.append('name', name);
      form_data.append('designation', designation);
      form_data.append('emailID', emailID);
      $.ajax({
          url: "add/addEmp.php",
          type: 'POST',
          data: form_data,
          contentType: false,
          cache : false,
          processData: false,
          success: function(result){
              console.log(result);
              var resultJSON = JSON.parse(result)
              if (resultJSON.status == 'success') {
                  alert('Employee Added Successfully!');
                  window.location.href = 'index.php?id=' + resultJSON.id;
              }else{
                  alert('Database Down!');
                  console.error(resultJSON.message);
              }
          },
          error: function() {
              alert("Server Down. Try again later.");
          }
      });
    }catch(err){
      console.log(err);
    }
  }
</script>

<!-- {
  'name' : name,
  'designation' : designation,
  'emailID' : emailID
} -->
