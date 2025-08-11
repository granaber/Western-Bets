function modal_myBtn(idAuth) {
	var idtoken = document.getElementById("tokenId");
	var modalBtn = document.getElementById("modalBtn");
	var modal = document.getElementById("myModal");

	modal.style.display = "block";

	var span = document.getElementsByClassName("closex")[0];
	span.onclick = function () {
		modal.style.display = "none";
	};

	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
		if (event.target == modalBtn) {
			verfiToken(idAuth, idtoken.value).then(({ status, messaje }) => {
				if (status) saveTocken();
				else {
					alert(messaje);
				}
				modal.style.display = "none";
			});
		}
	};

	idtoken.focus();
}

function verfiToken(idauth, token) {
	const Url ='https://token.saamqx.net:4600/verify?';

	return axios.get(`${Url}code=${idauth}opop${token}`).then(({ data }) => {
		const { err } = data;
		if (!err) {
			const { status, respose } = data;
			if (status) return { status: true, messaje: respose };
			else return { status: false, messaje: respose };
		} else {
			const { message } = data;
			return { status: false, messaje: message };
		}
	});
}

function saveTocken() {
	new Ajax.Request("procierre.php?op=34", {
		method: "get",
		onSuccess: function (transport) {
			var response = transport.responseText.evalJSON(true);

			if (response.status) alert("Listo su Tocket ACEPTADO");
			else
				alert(
					"Intente de nuevo! o no esta REGISTRADO para aceptar su TOKEN o no tiene AUTORIZACION!"
				);
		},

		onFailure: function () {
			alert("No tengo respuesta Comuniquese con el Administrador!");
		},
	});
}
