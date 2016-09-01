<?php
session_start();
if(isset($_SESSION['ISCBsessUsername'])){
  switch($_SESSION['ISCBsessUtype']){
    case '1': header('Location: ../administrator/'); break;
    case '2': header('Location: ../viewer/'); break;
    default: header('Location: ../');
    exit();
  }
}else{
  header('Location: ../index.html');
  exit();
}
?>
