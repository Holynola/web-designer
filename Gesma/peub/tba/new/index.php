<!DOCTYPE html>
<html>
<head>
	<title>Image gallery</title>
</head>
<style type="text/css">
	body {
		margin: 0;
		padding: 0;
		background: #ccc;
	}

	.thumnails {
		width: 30%;
		float: left;
		margin-left: 30px;
		margin-bottom: 20px;
		background: #fff;
		padding: 5px;
		box-sizing: border-box;
	}

	.thumnails img {
		width: 100%;
		height: 250px;
	}
</style>
<body>
	<main>
		<h1>Image Gallery</h1>

		<?php
			$dir = glob('images/{*.jpg, *.png}', GLOB_BRACE);

			foreach ($dir as $value) {
				?>
				<div class="thumnails">
					<a href="inde.php?pid=<?=$value?>" style="text-decoration: none; color: black;">
						<img src="<?php echo $value; ?>" alt="<?php echo $value; ?>">
						<span>
							<?php
								$domain = strstr($value, '/');
								echo $domain;
							?>
						</span>
					</a>	
				</div>	
				<?php
			}
		?>
	</main>
</body>
</html>