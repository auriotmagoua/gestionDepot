
$('#form_user').on('submit', function (e) {
    event.preventDefault();

    let url = BASE_URL + "/user/Save_user";

    $('#btn-log').prop('disabled', true);

    var login2 = $("#login2").val();
    var password2 = $("#password2").val();

    // var idUser = localStorage.getItem('idUser');

    if (login2 == "" || password2 == "") {
        $('#btn-log').prop('disabled', false);
        if (login2 == "" || login2 == null) {
            toastr["error"]("Enter un login", "Attention");
        }else if (password2 == "" || password2 == null) {
            toastr["error"]("Entrer un mot de passe", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_user')[0];
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
                    list_user();
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
    $("#login2").val("");
    $("#password2").val("");
}



