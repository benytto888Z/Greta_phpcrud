<?php
include('db.php');
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
//print strftime("%A %d %B %Y %T");
//die();

$reponse = $bdd->query('SELECT * FROM todos');



if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $todo = $_POST['todo'];
  //echo $todo;
 
  $date = strftime("%A %d %B %Y");

  //echo $date;

  //die();

  if($todo == ''){
    //echo " feee";
    $error = "Ce champ est requis";
    
  }else{
      $req = $bdd->prepare('INSERT INTO todos(nom_todo, date_todo) VALUES(:td_nom, :td_date)');
        
        try{
          $req->execute(array(
          'td_nom' => $todo,
          'td_date' => $date,
          ));
        }catch(Exception $e){

            die("Echec");
        }finally{
            header("Location:index.php?todo_ajout");
        }

  }

 
  
   
  }

  if(isset($_GET['delete_todo'])){

    $del_todo = $_GET['delete_todo'];
    
    $query = "DELETE FROM todos WHERE id_todo = :id";
    $stmt = $bdd->prepare($query);
 


      //echo $del_todo;
      // die();


      try{
        $stmt->execute(['id'=>$del_todo]);
      }catch(Exception $e){
          die("Echec");
      }finally{
          header("Location:index.php?todo_delete");
      }
  }

if(isset($_POST['search'])){
  header("Location:search.php");
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
   .search{
     margin: 33px;
   }
  </style>
  
  <title>Crud php</title>
</head>
<body>
 <div class="container">
        <div class="todo">
              <h1><a href="index.php">Tâches à faire</a></h1>
              <h3>Ajouter une nouvelle tâche</h3>

              <?php

             // echo $error;
                  if (((isset($error)) && $error !=='')) {
                    echo "<div class='alert alert-danger'>
                                $error
                          </div>";
                  }
              ?>


             <div>
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="todo" placeholder="Entrer une tâche à faire">
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="btn_todo" value="Ajouter une nouvelle tâche">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-info" name="search" value="Rechercher une tâche">
                  </div>

              </form>
              </div>

              <div class="table-responsive col-lg-12">
                  <table class="table table-bordered table-striped table-hover">
                          <thead>
                            <th>ID</th>
                            <th>Todo</th>
                            <th>Date de création</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                            <th>Afficher</th>
                          </thead>
                          <tbody>
                          <?php
                          // On affiche chaque entrée une à une
                          while ($rows = $reponse->fetch())
                          {
                              $id = $rows['id_todo'];
                              $nom = $rows['nom_todo'];
                              $date = $rows['date_todo'];
                              ?>
                          <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nom; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><a href="edit.php?edit_todo=<?= $id; ?>" class="btn btn-primary">Modifier</a></td>
                            <td><a href="index.php?delete_todo=<?= $id; ?>" class="btn btn-danger">Supprimer</a></td>
                            <td><a href="" class="btn btn-info">Afficher</a></td>
                          </tr>
                     
                          <?php
                          }
                          ?>
                       
                          
                            
                          </tbody>
                  </table>
              </div>
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