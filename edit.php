<?php
include('db.php');

setlocale(LC_ALL, "fr_FR.UTF-8");

if(isset($_GET['edit_todo'])){
  $edit_id=$_GET['edit_todo'];
  //echo "oki";
}

if(isset($_POST['btn_edit'])){
  $edit_todo = $_POST['todo'];

  $query = "UPDATE todos SET nom_todo = :nom_todo WHERE id_todo = :id_todo";
  $stmt = $bdd->prepare($query);
  $stmt->execute([
     'nom_todo'=>$edit_todo,
      'id_todo'=>$edit_id
    ]);

    if(!$stmt)
    {
      die("Echec");
    }else{
      header("Location:index.php?todo_modifier");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
   .todo{
     display: flex;
     flex-direction: column;
     justify-content: center;
     align-items: center;
     border-radius: 3px;
     border: 1px solid #ccc;
     text-align: center;
     margin-top: 22px;
   }
  </style>
  
  <title>Crud php</title>
</head>
<body>
 <div class="container">
        <div class="todo">
              <h1>TodoList avec PHP & Mysql</h1>
              <h3>Ajouter une nouvelle tâche</h3>

              <form action="" method="POST">
                    <?php
                           $query = "SELECT * FROM todos WHERE id_todo = :id";
                           $stmt = $bdd->prepare($query);
                           $stmt->execute(['id'=>$edit_id]);
                           $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>

                  <div class="form-group">
                    <input type="text" class="form-control" name="todo" value ="<?php echo $row['nom_todo']; ?>" placeholder="Entrer une tâche à faire">
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="btn_edit" value="Modifier la tâche">
                  </div>

              </form>

            
        </div>
 </div>


  
  <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>