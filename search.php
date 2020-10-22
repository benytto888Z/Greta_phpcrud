<?php
include 'db.php';

setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
$reponse = $bdd->query('SELECT * FROM todos');
if (isset($_POST['search'])) {
    $search = $_POST['search'];
//echo $search;
    $reponse = $bdd->query("SELECT * FROM todos WHERE nom_todo LIKE '%$search%'") ?? '';
//var_dump($reponse);
}

/*$reponse->execute(array(
'search' => $search
));*/
//var_dump($reponse);
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
             <div>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="todo" placeholder="Entrer une tâche à faire">
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="btn_todo" value="Ajouter une nouvelle tâche">
                  </div>

              </form>
              </div>

              <div class="col-lg-4 search">
                <form action="search.php" method="POST">
                      <input type="text" class="form-control" name="search" placeholder="Rechercher une tâche">
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
if ( $reponse->rowCount() >0 ){

    while ($rows = $reponse->fetch()) {

        $id = $rows['id_todo'];
        $nom = $rows['nom_todo'];
        $date = $rows['date_todo'];
       // echo ($nom);
        ?>
                          <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nom; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><a href="edit.php?edit_todo=<?=$id;?>" class="btn btn-primary">Modifier</a></td>
                            <td><a href="index.php?delete_todo=<?=$id;?>" class="btn btn-danger">Supprimer</a></td>
                            <td><a href="" class="btn btn-info">Afficher</a></td>
                          </tr>

                          <?php
}}else if ($reponse->rowCount() == 0){
?>
    <tr>
      <td></td>
      <td class="text-center text-danger bg-dark"><h1>Pas de resultat</h1></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    
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