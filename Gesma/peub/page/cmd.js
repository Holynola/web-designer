document.getElementById("sent").addEventListener("submit", function(e) {
	var error;
	for (var a = 1; a < 100; a++) {
		var boissonId+a = document.getElementById("boissonId"+a);
		var pacasier+a = document.getElementById("pacasier"+a);
		var qte+a = document.getElementById("qte"+a);

		if (!qte+a.value) {
			error = "Veuillez entrer le nombre de casiers !";
		}
		if (!pacasier+a.value) {
			error = "Veuillez entrer le prix du casier !";
		}
		if (!boissonId+a.value) {
			error = "Veuillez sélectionner la boisson !";
		}
	}

	if (error) {
		e.preventDefault();
		alert(error);
		return false;
	} else {
		alert("La Commande a été enregistrée !");
	}
});