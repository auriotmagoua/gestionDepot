
$('#form_categorie').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/categorie/Save_categorie";

    $('#btn-log').prop('disabled', true);

    var nameCategorie = $("#nameCategorie").val();
    var nombreBouteille = $("#nombreBouteille").val();

    // var idUser = localStorage.getItem('idUser');

    if (nameCategorie == "" || nombreBouteille == "") {
        $('#btn-log').prop('disabled', false);
        if (nameCategorie == "" || nameCategorie == null) {
            toastr["error"]("Enter le nom de la categorie", "Attention");
        }else if (nombreBouteille == "" || nombreBouteille == null) {
            toastr["error"]("Entrer le de bouteille", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_categorie')[0];
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
                    list_categorie();
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
    $("#nameCategorie").val("");
    $("#nombreBouteille").val("");
}