<?php
  require_once('connection.php');
  $flattype_sql = mysqli_query($connection, 'SELECT * FROM flattypes WHERE ' . $_GET['get'] . ' = ' . $_POST['id']);
  $flattypesrowsnum = mysqli_num_rows($flattype_sql);
  $r2 = 1;
  while ($r2 <= $flattypesrowsnum) {
    $flattypesrows = mysqli_fetch_assoc($flattype_sql);
    $flattype =
    [
      'id' => $flattypesrows['id'],
      'shirkat_id' => $flattypesrows['shirkat_id'],
      'type' => $flattypesrows['type'],
      'month_debet_sum' => $flattypesrows['month_debet_sum'],
      'field' => $flattypesrows['field']
    ];
    $flattypes[] = $flattype;
    $r2++;
  }
  echo json_encode($flattypes);
  $connection -> close();
?>