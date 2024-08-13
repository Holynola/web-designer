<?php
	include('dbConf.php');

	if (isset($_POST['age'])) {
		$age = $_POST['age'];

		$query = "SELECT * FROM commande, supplier WHERE commande.fourId = supplier.idSup AND moisCmd =:age";
		$statement = $bdd->prepare($query);
		$statement->bindParam(":age", $age);
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		$reponse = $bdd->query("SELECT * FROM commande, supplier WHERE commande.fourId = supplier.idSup AND moisCmd = '$age'");

		while ($val = $reponse->fetch())
		{
?>
	<a href="detCmd.php?day=<?=$val['dayCmd']?>&amp;heure=<?=$val['heureCmd']?>" style="text-decoration: none;color: black;">
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
					<p>Date : <?php echo $val['dayCmd']; ?></p>
					<p style="color: orange;">N° Facture : <?php echo $val['numfact']; ?></p>
					<p><span style="color: green;">Fournisseur :</span><br><?php echo $val['nomSup'] ?></p>
					<p><span style="color: green;">Montant :</span><br><?php echo $val['mtt']; ?> Francs CFA</p>
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