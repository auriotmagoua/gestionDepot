
$('#form_fournisseur').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/fournisseur/Save_fournisseur";

    $('#btn-log').prop('disabled', false);

    var nameFournisseur = $("#nameFournisseur").val();
    var phoneFournisseur = $("#phoneFournisseur").val(); 

    // var idUser = localStorage.getItem('idUser');

    if (nameFournisseur == "" || phoneFournisseur == "") {
        $('#btn-log').prop('disabled', false);
        if (nameFournisseur == "" || nameFournisseur == null) {
            toastr["error"]("Enter le nom du fournisseur", "Attention");
        }else if (phoneFournisseur == "" || phoneFournisseur == null) {
            toastr["error"]("Entrer le numero de telephone fournisseur", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_fournisseur')[0];
        const formData = new FormData(data_form); 

        $.ajax({
            url: url,
            type: "POST",
            contentType: false,
            processData: false,
            timeout: 600000,
            data: formData,
            cache: false,
            headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
            success: function (data) {
                if (data.success == true) {
                    toastr["success"](data.msg, "Réussite");
                    resetForm();
                    list_client();
                } else {
                    toastr["error"](data.msg, "Erreur");
                }
                $('#btn-log').prop('disabled', false);
            },
            error: function (data) {
                console.log(data.responseJSON);
                $('#btn-log').prop('disabled', false);
                toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            }
        });
    }
}) 


// Fonction pour réinitialiser le formulaire
function resetForm() {
    $("#nameFournisseur").val("");
    $("#phoneFournisseur").val("");
}