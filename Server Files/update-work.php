<?php

    // include the config file that we created last week
    require "config.php";
    require "common.php";


    // run when submit button is clicked
       if (isset($_POST['submit'])) {

           try {
               $connection = new PDO($dsn, $username, $password, $options);


               //grab elements from form and set as varaible
               $work =[
                 "id"         => $_POST['id'],
                 "artistname" => $_POST['artistname'],
                 "worktitle"  => $_POST['worktitle'],
                 "workdate"   => $_POST['workdate'],
                 "worktype"   => $_POST['worktype'],
                 "date"   => $_POST['date'],
               ];

               // create SQL statement
               $sql = "UPDATE `works`
                       SET id = :id,
                           artistname = :artistname,
                           worktitle = :worktitle,
                           workdate = :workdate,
                           worktype = :worktype,
                           date = :date
                       WHERE id = :id";

               //prepare sql statement
               $statement = $connection->prepare($sql);

               //execute sql statement
               $statement->execute($work);

               header('Location: index.php');

               } catch(PDOException $error) {
               echo $sql . "<br>" . $error->getMessage();
           }
       }


    //simple if/else statement to check if the id is available
    if (isset($_GET['id'])) {
        //yes the id exists

        // quickly show the id on the page
        echo $_GET['id'];

        try {
                  // standard db connection
                  $connection = new PDO($dsn, $username, $password, $options);

                  // set if as variable
                  $id = $_GET['id'];

                  //select statement to get the right data
                  $sql = "SELECT * FROM works WHERE id = :id";

                  // prepare the connection
                  $statement = $connection->prepare($sql);

                  //bind the id to the PDO id
                  $statement->bindValue(':id', $id);

                  // now execute the statement
                  $statement->execute();

                  // attach the sql statement to the new work variable so we can access it in the form
                  $work = $statement->fetch(PDO::FETCH_ASSOC);

              } catch(PDOExcpetion $error) {
                  echo $sql . "<br>" . $error->getMessage();
              }

    } else {
        // no id, show error
        echo "No id - something went wrong";
        //exit;
    }

?>

<head>


<div class="container-fluid">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<div class="jumbotron">


  <h1 class="display-4">Strength App</h1>
  <p class="lead">This is a simple app to assist the user with strength goals through progress notes</p>
  <hr class="my-4">
  <p>This app records three primary exercises important for strength</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="index.php" role="button">Home</a>
  </p>

  <?php if (isset($_POST['submit']) && $statement) { ?>
  <p>Work successfully updated.</p>
  <?php } ?>

<form method="post">


  <input type="text" name="id" id="id" value="<?php echo escape($work['id']); ?>" >
  <label for="id">Session</label>


  <input type="date" name="artistname" id="artistname" value="<?php echo escape($work['artistname']); ?>">
  <label for="artistname">Date</label>


  <input type="number" name="worktitle" id="worktitle" value="<?php echo escape($work['worktitle']); ?>">
  <label for="worktitle">Squat</label>

  <input type="number" name="workdate" id="workdate" value="<?php echo escape($work['workdate']); ?>">
  <label for="workdate">Clean</label>

  <input type="number" name="worktype" id="worktype" value="<?php echo escape($work['worktype']); ?>">
  <label for="worktype">Deadlift</label>

  <input type="submit" name="submit" value="Save"><br>

</form>
</div>
</div>
