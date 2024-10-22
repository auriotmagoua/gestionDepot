
$('#form_produit').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/produit/Save_produit";

    $('#btn-log').prop('disabled', true);

    var nameProduit = $("#nameProduit").val();
    var idCategorie = $("#idCategorie").val();
    var prixProduit = $("#prixProduit").val();

    // var idUser = localStorage.getItem('idUser');

    if (nameProduit == "" || prixProduit == "" || idCategorie == "") {
        $('#btn-log').prop('disabled', false);
        if (nameProduit == "" || nameProduit == null) {
            toastr["error"]("Enter le nom du produit", "Attention");
        }else if (prixProduit == "" || prixProduit == null) {
            toastr["error"]("Entrer le prix", "Attention");
        }
        else if (idCategorie == "" || idCategorie == null) {
            toastr["error"]("Choissisez une categorie", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_produit')[0];
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
                    list_produit();
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
    $("#nameProduit").val("");
    $("#idCategorie").val("");
    $("#prixProduit").val("");
}