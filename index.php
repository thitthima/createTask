	<?php 
	    // initialize errors variable
		$errors = "";

		// connect to database
		$db = mysqli_connect("localhost", "root", "", "todo");

		// insert a quote if submit button is clicked
		if (isset($_POST['submit'])) {
			if (empty($_POST['task'])) {
				$errors = "You must fill in the task";
			}
			if (empty($_POST['time'])) {
				$errors = "You must fill in the start time";
			}
			if (empty($_POST['time_end'])) {
				$errors = "You must fill in the end time";
			}
				else{
				$task = $_POST['task'];
				$time = $_POST['time'];
				$time_end = $_POST['time_end'];
				$sql = "INSERT INTO task (task, time , time_end) VALUES ('$task','$time','$time_end')";
				mysqli_query($db, $sql);
				header('location: index.php');
			}
		}	

	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM task WHERE id=".$id);
		header('location: index.php');
	}

	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>ToDo List Application PHP and MySQL</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="heading">
			<h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySQL database</h2>
		</div>
		<form method="post" action="index.php" class="input_form">
		<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
	<?php } ?>	
			
			Task : <input type="text" name="task" class="task_input">
			<br><br>
			Start : <input type="time" name="time" class="time_input">
			End : <input type="time" name="time_end" class="time_input">
			<br><br>
			<center><button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button></center>
		</form>

		<table>
		<thead>
			<tr>
				<th>N</th>
				<th>Tasks</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th style="width: 60px;">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php 
			// select all tasks if page is visited or refreshed
			$task = mysqli_query($db, "SELECT * FROM task");

			$i = 1; while ($row = mysqli_fetch_array($task)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['task']; ?> </td>
					<td class="time"><?php echo $row['time']; ?></td>
					<td class="time_end"><?php echo $row['time_end']; ?></td>
					<td class="delete"> 
						<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
					</td>
				</tr>
			<?php $i++; } ?>	
		</tbody>
	</table>
	</body>
	</html>