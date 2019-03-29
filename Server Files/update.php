<?php
// this code will only execute after the submit button is clicked


    // include the config file that we created before
    require "config.php";

    // this is called a try/catch statement
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // SECOND: Create the SQL
        $sql = "SELECT * FROM `works`";

        // THIRD: Prepare the SQL
        $statement = $connection->prepare($sql);
        $statement->execute();

        // FOURTH: Put it into a $result object that we can access in the page
        $result = $statement->fetchAll();
	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}

?>


<?php include "templates/header.php"; ?>



<div class="jumbotron">

<?php
                // This is a loop, which will loop through each result in the array
                foreach($result as $row) {
            ?>
<p>
    Session:
    <?php echo $row["id"]; ?><br> Date:
    <?php echo $row['artistname']; ?><br> Squat:
    <?php echo $row['worktitle']; ?><br> Clean:
    <?php echo $row['workdate']; ?><br> Deadlift:
    <?php echo $row['worktype']; ?><br>
    <a href='update-work.php?id=<?php echo $row['id']; ?>'>Edit</a>
</p>
<?php
            // this willoutput all the data from the array
            //echo '<pre>'; var_dump($row);
        ?>

<hr>
<?php }; //close the foreach

?>



<form method="post">

    <input type="submit" name="submit" value="View all">

</form>
</div>

<?php include "templates/footer.php"; ?>
