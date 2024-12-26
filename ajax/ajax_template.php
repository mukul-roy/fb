<?php

if (file_exists(__DIR__ . "/../autoload.php")) {
   require_once __DIR__ . "/../autoload.php";
}



?>


<?php

if (isset($_GET['action'])) {
   $action = $_GET['action'];
}


switch ($action) {

      //facebook ajex get form data
  
      case "users_create";
      //get form data
      echo $name = $_POST['posta_user_name'];
      echo $post_content = $_POST['post_content'];


      //upload user photo
      $fileName = fileupload([
         "name"    => $_FILES['post_user_photo']['name'],
         "tmp_name"    => $_FILES['post_user_photo']['tmp_name'],
      ], "../media/post/");
      echo $fileName;
      //upload post photo
      // $post_photo = fileupload([
      //    "name"    => $_FILES['post_photos']['name'],
      //    "tmp_name"    => $_FILES['post_photos']['tmp_name'],
      // ], "../media/post/user_photo/");
      // echo $post_photo;

      //post photos upload
      $post_photo = [];
      if (!empty($_FILES['post_photos']['name'][0])) {
         for ($i = 0; $i < count($_FILES['post_photos']['name']); $i++) {

            $post_photo_item = fileupload([
               "tmp_name"   => $_FILES['post_photos']['tmp_name'][$i],
               "name"   => $_FILES['post_photos']['name'][$i],
            ], "../media/post/user_photo/");

            array_push($post_photo, $post_photo_item);
         }
      }

      $post_photo_json = json_encode($post_photo);

      //sent data to db
      $sql = "INSERT INTO users (name, content, photo, postphotos) VALUES (?, ?, ?, ?)";
      $statement = connect()->prepare($sql);
      $statement->execute([$name, $post_content, $fileName,  $post_photo_json]); // Corrected


      break;

      //get all facebook user 
 
   //comment ajex get form data
  
   case "comment_create";
   //get form data
   echo $name = $_POST['comment_user_name'];
   echo $post_content = $_POST['comment_content'];
   $id = $_POST['commentId'];


   //upload user photo
   $fileName = fileupload([
      "name"    => $_FILES['comment_user_photo']['name'],
      "tmp_name"    => $_FILES['comment_user_photo']['tmp_name'],
   ], "../media/post/");
   echo $fileName;
   //upload post photo
   // $post_photo = fileupload([
   //    "name"    => $_FILES['post_photos']['name'],
   //    "tmp_name"    => $_FILES['post_photos']['tmp_name'],
   // ], "../media/post/user_photo/");
   // echo $post_photo;

   //post photos upload
   // $post_photo = [];
   // if (!empty($_FILES['post_photos']['name'][0])) {
   //    for ($i = 0; $i < count($_FILES['post_photos']['name']); $i++) {

   //       $post_photo_item = fileupload([
   //          "tmp_name"   => $_FILES['post_photos']['tmp_name'][$i],
   //          "name"   => $_FILES['post_photos']['name'][$i],
   //       ], "../media/post/user_photo/");

   //       array_push($post_photo, $post_photo_item);
   //    }
   // }

   // $post_photo_json = json_encode($post_photo);

   //sent data to db
   $sql = "UPDATE users SET commentname='$name',comment='$post_content',commenrphoto='$fileName'  WHERE id='$id' ";
   // $sql = "INSERT INTO users (commentname, comment, commenrphoto) VALUES (?, ?, ?)";
   $statement = connect()->prepare($sql);
   $statement->execute(); // Corrected


   break;

   //get all facebook user 

      case "devs_all";
      //new create sql
      $sql = "SELECT * FROM users";
      $statement = connect()->prepare($sql);
      $statement->execute();
      $data = $statement->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($data);

      break;



      //status_update
   // case "devs_status_update";
   //    $id = $_POST['statusId'];
   //    $likes = $_POST['likes'];

      

      // $sql = "SELECT * FROM users WHERE id='$id'";
      // $statement = connect()->prepare($sql);
      // $statement->execute();
      // $data = $statement->fetch(PDO::FETCH_OBJ);
      // $new_likes = $data->likes + 1;
      // console.log($new_likes);
      // echo json_encode($new_likes);

      // $sql = "UPDATE users SET likes = $new_likes WHERE id='$id' ";
      // $statement = connect()->prepare($sql);
      // $statement->execute();


      // Fetch current likes for the user
      // $sql = "SELECT likes FROM users WHERE id = :id";
      // $statement = connect()->prepare($sql);
      // $statement->execute([':id' => $id]);
      // $data = $statement->fetch(PDO::FETCH_OBJ);

      // if ($data) {
      //    // Increment likes
      //    $new_likes = $data->likes + 1;

         // Update likes in the database
      //    $sql = "UPDATE users SET likes = :new_likes WHERE id = :id";
      //    $statement = $db->prepare($sql);
      //    $statement->execute([
      //       ':new_likes' => $new_likes,
      //       ':id' => $id
      //    ]);

      //    // Return the updated like count as JSON
      //    echo json_encode(['likes' => $new_likes]);
      // }

      // break;



      // case "devs_delete";
      //    echo "Devs Delete okey";
      //    break;

      //    //status_update
      //    // case "devs_status_update";
      //    $id = $_POST['statusId'];
      //    $status = $_POST['status'];


      //    //  $updatestatus = !$status;
      //    if ($status == true) {
      //       $updatestatus = 0;
      //    } else {
      //       $updatestatus = 1;
      //    }

      //    //update status
      //    $sql = "UPDATE devs2 SET status='$updatestatus' WHERE id='$id' ";
      //    $statement = connect()->prepare($sql);
      //    $statement->execute();

      //    return true;
      //    break;

      //status_update
         case "devs_status_update";
            $id = $_POST['statusId'];
            // $status = $_POST['likes'];

            // $updatestatus = $status +1;
            // if ($status == true) {
            //    $updatestatus = 0;
            // } else {
            //    $updatestatus = 1;
            // }

            // $sql = "UPDATE users SET likes = '$updatestatus' WHERE id='$id' ";
            $sql = "UPDATE users SET likes = likes + 1 WHERE id = $id";
            $statement = connect()->prepare($sql);
            $statement->execute();
            // echo json_encode($data);

            $sql = "SELECT * FROM users WHERE likes>0 AND id = $id";
                  $statement = connect()->prepare($sql);
                  $statement->execute();
                  $data = $statement->fetchAll(PDO::FETCH_OBJ);
                  echo json_encode($data);

            break;



      //       //get edit
      //    case "devs_edit";
      //       $id = $_POST['editId'];

      //       $sql = "SELECT * FROM devs2 WHERE id='$id' ";
      //       $statement = connect()->prepare($sql);
      //       $statement->execute();
      //       $data =  $statement->fetch(PDO::FETCH_OBJ);

      //       echo json_encode($data);

      //       return true;
      //       break;

      //    case "devs_create";
      //       //get form data
      //       $name = $_POST['name'];
      //       $age = $_POST['age'];
      //       $skill = $_POST['skill'];
      //       $location = $_POST['location'];

      //       //upload photo
      //       $fileName = fileupload([
      //          "name"    => $_FILES['photo']['name'],
      //          "tmp_name"    => $_FILES['photo']['tmp_name'],
      //       ], "../media/devs/");

      //       //sent data to db
      //       $sql = "INSERT INTO devs2 (name, age, skill, location, photo) VALUES (?,?,?,?,?) ";
      //       $statement = connect()->prepare($sql);
      //       $statement->execute([$name, $age, $skill, $location, $fileName]);

      //       break;

      //    case "devs_update";
      //       $name = $_POST['name'];
      //       $age = $_POST['age'];
      //       $skill = $_POST['skill'];
      //       $location = $_POST['location'];
      //       $updateId = $_POST['updateId'];

      //       $sql = "UPDATE devs2 SET name='$name', age='$age', skill='$skill', location='$location' WHERE id='$updateId' ";
      //       $statement = connect()->prepare($sql);
      //       $statement->execute();

      //       break;

      //    case "devs_all";
      //       //new create sql
      //       $sql = "SELECT * FROM devs2";
      //       $statement = connect()->prepare($sql);
      //       $statement->execute();
      //       $data = $statement->fetchAll(PDO::FETCH_OBJ);
      //       echo json_encode($data);

      //       break;
}


?>