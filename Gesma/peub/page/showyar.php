<?php
	include('dbConf.php');

	if (isset($_POST['age'])) {
		$age = $_POST['age'];

		$query = "SELECT * FROM points WHERE anneePt =:age";
		$statement = $bdd->prepare($query);
		$statement->bindParam(":age", $age);
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		$reponse = $bdd->query("SELECT * FROM points WHERE anneePt = '$age'");

		while ($val = $reponse->fetch())
		{
?>
	<a href="detConso.php?day=<?=$val['dayPt']?>&amp;heure=<?=$val['heurePt']?>" style="text-decoration: none;color: black;">
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
									<span style="color: red;"><?php echo $val['dayPt']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Heure</td>
								<td> : 
									<span style="color: red;"><?php echo $val['heurePt']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Estimation des<br>commandes</td>
								<td> : 
									<span style="color: red"><?php echo $val['estcomPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Estimation du stock<br>avant point</td>
								<td> : 
									<span style="color: red"><?php echo $val['eststkPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Montant vente</td>
								<td> : 
									<span style="color: red"><?php echo $val['mntvtePt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Bénéfice</td>
								<td> : 
									<span style="color: red"><?php echo $val['benefPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Montant reçu</td>
								<td> : 
									<span style="color: red"><?php echo $val['mntrPt']; ?> FCFA</span>
								</td>
							</tr>

							<tr>
								<td style="text-align: right;">Ecart Montants<br>(Vente/Reçu) (FCFA)</td>
								<td> : 
									<span style="color: red"><?php echo $val['ekaPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Dépenses</td>
								<td> : 
									<span style="color: red"><?php echo $val['dpsePt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Crédit</td>
								<td> : 
									<span style="color: red"><?php echo $val['crdPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Autres</td>
								<td> : 
									<span style="color: red"><?php echo $val['autrPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Estimation du<br>stock  Manquant</td>
								<td> : 
									<span style="color: red"><?php echo $val['mankPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Estimation du stock<br>après point</td>
								<td> : 
									<span style="color: red"><?php echo $val['estsapPt']; ?> FCFA</span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Nom du gérant</td>
								<td> : 
									<span style="color: red"><?php echo $val['nomGer']; ?></span>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">Nom du contrôleur</td>
								<td> : 
									<span style="color: red"><?php echo $val['nomCrtl']; ?></span>
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