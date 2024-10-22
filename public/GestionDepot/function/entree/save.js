
$('#form_entree').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/entree/Save_entree";

    $('#btn-log').prop('disabled', true);

    var idProduit = $("#idProduit").val();
    var nombreCasier = $("#nombreCasier").val();

    // var idUser = localStorage.getItem('idUser');

    if (idProduit == "" || nombreCasier == "") {
        $('#btn-log').prop('disabled', false);
        if (idProduit == "" || idProduit == null) {
            toastr["error"]("Choisir un produit", "Attention");
        }else if (nombreCasier == "" || nombreCasier == null) {
            toastr["error"]("Entrer le nombre de casier", "Attention");
        }
    }else{
        // add data form
        var data_form = $('#form_entree')[0];
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
                    list_entree();
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
    $("#idProduit").val("");
    $("#nombreCasier").val("");
}

list_produit_select2();

// imprimer la liste des produits dans le select 2
function list_produit_select2() {
    
    let url = BASE_URL + "/produit/List_produit";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            let ligne = '<option value="0">Auccun produit</option>';
            for (var i = 0; i < json.length; i++) {
                ligne += "";
                ligne = '<option value="'+json[i].idProduit+'">'+json[i].nameProduit.toUpperCase()+'</option>';
                // append select
                
            }
            
            $('#idProduit').append(ligne);
            $('#idProduitU').append(ligne);
            // $('#parent_edit').append(ligne);
            // $('#idProduit').append(ligne);

        },
        error: function(response){
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            Swal.close();
        }
    });
}
