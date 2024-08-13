<?php
	include('dbConf.php');

	if (isset($_POST['age'])) {
		$age = $_POST['age'];

		$query = "SELECT * FROM stock WHERE anneeStk =:age";
		$statement = $bdd->prepare($query);
		$statement->bindParam(":age", $age);
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		$reponse = $bdd->query("SELECT * FROM stock WHERE anneeStk = '$age'");

		while ($val = $reponse->fetch())
		{
?>
	<a href="detConso.php?day=<?=$val['dayStk']?>&amp;heure=<?=$val['heureStk']?>" style="text-decoration: none;color: black;">
	<?php
		}
	?>	
		<form method="post" enctype="multipart/form-data">
			<?php
				foreach ($data as $val) {
			?>
			<li>
				<div class="container">
					<br>
						<table>
							<tr>
								<td style="text-align: right;">Date</td>
								<td> : 
									<span style="color: red;"><?php echo $val['dayStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Heure</td>
								<td> : 
									<span style="color: red;"><?php echo $val['heureStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Bouteilles en stock<br>avant commandes</td>
								<td> : 
									<span style="color: red;"><?php echo $val['btsavStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Casiers commandés</td>
								<td> : 
									<span style="color: red;"><?php echo $val['ccmdStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Bouteilles en stock<br>après commandes</td>
								<td> : 
									<span style="color: red;"><?php echo $val['btsapStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Bouteilles vendues</td>
								<td> : 
									<span style="color: red;"><?php echo $val['btevduStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Stock restant<br>(bouteilles)</td>
								<td> : 
									<span style="color: red;"><?php echo $val['stkresStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Stock physique<br>(bouteilles)</td>
								<td> : 
									<span style="color: red;"><?php echo $val['stkphyStk']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Stock manquant<br>(bouteilles)</td>
								<td> : 
									<span style="color: red;"><?php echo $val['stkmanStk']; ?></span>
								</td>
							</tr>
						</table>
					<br>
				</div>
			</li>
			<?php
				}
			?>
		</form>
	</a>	
<?php
	}
?>	