    $('#form_password').on('submit', function (e) {
        e.preventDefault();


        var login2 = $("#login2").val();
        var passwd1 = $("#passwd1").val();
        var passwd2 = $("#passwd2").val();
        // alert(login2 + ' ' + passwd1 + ' ' + passwd2);
    
        // var idUser = localStorage.getItem('idUser');
    
        if (login2 == "" || passwd1 == "" || passwd2 == "") {
            if (login2 == "" || login2 == null) {
                toastr["error"]("Entrer votre login", "Attention");
            }else if (passwd1 == "" || passwd1 == null) {
                toastr["error"]("Entrer l'ancien mot de passe", "Attention");
            }
            else if (passwd2 == "" || passwd2 == null) {
                toastr["error"]("Entrer le nouveau mot de passe", "Attention");
            }
        }else{

            var idUser = localStorage.getItem('idUser');
                // alert(idUser);
            let url = BASE_URL + "/user/Change_pass/"+idUser;
            var data_form = $('#form_password')[0];
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
    });    

    function resetForm() {
        $("#passwd1").val("");
        $("#passwd2").val("");
    }

 
    

    