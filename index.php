<?php

$dsn = "mysql:host=localhost;dbname=navbar";
$user = "root";
$pass = "";
try{
    $conn = new PDO($dsn,$user,$pass);
} catch (Exception $e){
    echo "<h3>Failed To Connect To MySQL : { " . $e->getMessage() . " }</h3>";
}
/////////////////////////////////////////////////////////////////////////////////
$menu = $conn->prepare("SELECT * FROM menu ORDER BY id");
$menu->execute();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dynamic Navbar</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="page">
			<ul>
				<?php
					while ($menu_row = $menu->fetch(PDO::FETCH_OBJ)) {
						$submenu = $conn->prepare("SELECT * FROM submenu WHERE cat_id = :id");
						$submenu->bindParam(':id',$menu_row->id,PDO::PARAM_INT);
						$submenu->execute();
						?>
							<li><a href=""><?php echo $menu_row->name; ?></a>
								<?php
									if ($submenu->rowCount()) {
										?>
											<ul>
												<?php
													while ($sub_row = $submenu->fetch(PDO::FETCH_OBJ)) {
														?>
															<li><a href="<?php echo $sub_row->href; ?>">
																<?php echo $sub_row->sub_name; ?></a>
															</li>
														<?php
													}
												?>
											</ul>
										<?php
									}
								?>
							</li>
						<?php
					}
				?>
			</ul>
		</div>
	</body>
</html>












