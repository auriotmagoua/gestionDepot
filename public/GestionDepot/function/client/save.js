
$('#form_client').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/client/Save_client";

    $('#btn-log').prop('disabled', false);

    var nameClient = $("#nameClient").val();
    var phoneClient = $("#phoneClient").val(); 

    // var idUser = localStorage.getItem('idUser');

    if (nameClient == "" || phoneClient == "") {
        $('#btn-log').prop('disabled', false);
        if (nameClient == "" || nameClient == null) {
            toastr["error"]("Enter le nom du client", "Attention");
        }else if (phoneClient == "" || phoneClient == null) {
            toastr["error"]("Entrer le numero de telephone client", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_client')[0];
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
    $("#nameClient").val("");
    $("#phoneClient").val("");
}