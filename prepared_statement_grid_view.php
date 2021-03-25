<?php
	require_once("require/database_connection.php");

	$query = "SELECT emp.`employee_id`, CONCAT(emp.`first_name`, ' ', emp.`last_name`) AS 'full_name', emp.`email`, emp.`gender`, emp.`salary`, company.`company_name`, department.`department_name`, CONCAT(man.`first_name`, ' ', man.`last_name`) AS 'manager'
		FROM employee emp, employee man, company, department
		WHERE emp.`manager`=man.`employee_id`
		AND emp.`department_id`=department.`department_id`
		AND emp.`company_id`=company.`company_id`
		AND emp.`salary`>?
		AND emp.`gender`=?";

	$prepare_statement = mysqli_prepare($connection, $query) or die("Error Message: ".mysqli_error($connection));

	$salary = 5000;
	$gender	= "Male";

	mysqli_stmt_bind_param($prepare_statement, "is", $salary, $gender);

	mysqli_stmt_execute($prepare_statement);

	mysqli_stmt_bind_result($prepare_statement, $employee_id, $full_name, $email, $gender, $salary, $company_name, $department_name, $manager);
?>
<html>
	<head>
		<title>Grid View</title>
	</head>
	<body>
		<h3 align="center">Employees Information</h3>
		<div align="center">
			<table border="1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Gender</th>
						<th>Salary</th>
						<th>Company</th>
						<th>Department</th>
						<th>Manager</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while(mysqli_stmt_fetch($prepare_statement))
						{
							?>
								<tr>
									<td><?php echo $employee_id; ?></td>
									<td><?php echo $full_name; ?></td>
									<td><?php echo $email; ?></td>
									<td><?php echo $gender; ?></td>
									<td><?php echo $salary; ?></td>
									<td><?php echo $company_name; ?></td>
									<td><?php echo $department_name; ?></td>
									<td><?php echo $manager; ?></td>
								</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
		<?php
			mysqli_stmt_free_result($prepare_statement);

			mysqli_close($connection);
		?>
	</body>
</html>






