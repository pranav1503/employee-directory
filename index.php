<?php
  require 'util/header.php';
  require 'dynamoDBUtil.php';
  include 'isTable.php';
  $tableName = 'employee_directory';
  $params = [
    'TableName' => $tableName,
  ];
  if ($table_present && $isBucket) {
?>
  <div class="header container" style="margin-top:20px;">
    <div class="row">
      <div class="col-8">
        <h3>Employees List</h3>
      </div>
      <div class="col-4 text-end">
        <a href="add.php" class="btn btn-danger">Add <i class="fas fa-plus"></i></a>
      </div>
    </div>
    <div style="margin-top:30px" class="overflow-auto">
      <table class="table table-hover">
        <thead>
          <tr class="table-dark">
            <th scope="col">Name</th>
            <th scope="col">Designation</th>
            <th scope="col">Email</th>
            <th scope="col">Photo Available</th>
          </tr>
        </thead>
        <tbody style="cursor:pointer;">
          <?php
            try {
              $result = $dynamodb->scan($params);
              if($result['Count'] > 0){
                foreach ($result['Items'] as $emp) {
                    $employee = $marshaler->unmarshalItem($emp);
           ?>
          <tr onclick="viewEmployee('<?php echo $employee['id']; ?>')">
            <td><?php echo ucwords($employee['name']); ?></td>
            <td><?php echo ucwords($employee['designation']); ?></td>
            <td><?php echo $employee['email']; ?></td>
            <?php if(empty($employee['photo'])){ ?>
              <td style="color:red"><i class="far fa-times-circle"></i></td>
            <?php } else { ?>
              <td style="color:green"><i class="far fa-check-circle"></i></td>
            <?php } ?>
          </tr>
          <?php
              } // For each loop close
            } else {
           ?>
           <td colspan="4" style="text-align:center;">No Employee Records</td>
          <?php
            } // if-else count close
          ?>
        </tbody>
      </table>
    </div>
  </div>
<script type="text/javascript">
  function viewEmployee(id) {
    window.location.href = "employee.php?id="+id;
  }
</script>
<?php
  }catch (DynamoDbException $e) {
      echo "Unable to query:\n";
      echo $e->getMessage() . "\n";
  }
}else {
    include 'tableBanner.php';
}
  include 'util/footer.php';
?>
