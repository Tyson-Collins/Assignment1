<?php
// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {

    // include the config file that we created before
    require "config.php";

    // this is called a try/catch statement
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // SECOND: Get the contents of the form and store it in an array
        $new_work = array(
            "artistname" => $_POST['artistname'],
            "worktitle" => $_POST['worktitle'],
            "workdate" => $_POST['workdate'],
            "worktype" => $_POST['worktype'],
        );

        // THIRD: Turn the array into a SQL statement
        $sql = "INSERT INTO works (artistname, worktitle, workdate, worktype) VALUES (:artistname, :worktitle, :workdate, :worktype)";

        // FOURTH: Now write the SQL to the database
        $statement = $connection->prepare($sql);
        $statement->execute($new_work);
	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>


<?php include "templates/header.php"; ?>

<div class="jumbotron">
<?php if (isset($_POST['submit']) && $statement) { ?>
<p>Work successfully added.</p>
<?php } ?>

<!--form to collect data for each artwork-->

<form method="post">

    <input type="date" name="artistname" id="artistname">
    <label for="artistname">Date</label>
<br>

    <input type="number" name="worktitle" id="worktitle">
    <label for="worktitle">Squat</label>

    <input type="number" name="workdate" id="workdate">
    <label for="workdate">Clean</label>

    <input type="number" name="worktype" id="worktype">
    <label for="worktype">Deadlift</label>


    <!--
    <label for="work-description">Work Description</label>
    <input type="textarea" name="work-description" id="work-description">
    <label for="purchase-date">Purchase Date</label>
    <input type="textarea" name="purchase-date" id="purchase-date">
    <label for="purchase-details">Purchase Details</label>
    <input type="textarea" name="purchase-details" id="purchase-details">
-->
<br>
    <input type="submit" name="submit" value="Submit">

</form>
</div>
<?php include "templates/footer.php"; ?>
