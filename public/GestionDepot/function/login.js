$("#msg").html("");
// close session
localStorage.clear();

$('#from_login').on('submit', function(e) {
    event.preventDefault();
    var formData = new FormData(this);
    let url = BASE_URL + "/user/login";

    $.ajax({
        url: url,
        type: "POST",
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) { 
            if (data.success == true) {
                $("#password1").val(""); 
                $("#login").val("");

                let msg = '<div class="alert alert-success" style="text-align: center;" id="success">' +
                data.msg + '</div>';
                $("#msg").html("");
                $("#msg").append(msg);
                // initialiwe session
                localStorage.setItem('token', data.data.token);
                localStorage.setItem('idUser', data.data.idUser);
                localStorage.setItem('login', data.data.login);
                localStorage.setItem('typeUser', data.data.typeUser);
                localStorage.setItem('autorisation', data.autorisation);  
                window.location.href = BASE_URL+"/view/HomePage";
                
            } else {
                let msg = '<div class="alert alert-danger" style="text-align: center;" id="success">' +
                data.msg + '</div>';
                $("#msg").html("");
                $("#msg").append(msg); 
            } 
        },
        error: function(data) {
            console.log(data.responseJSON);
            let msg = '<div class="alert alert-danger" style="text-align: center;" id="success">Oousp Quelque chose a mal fonctionner</div>';
            $("#msg").html("");
            $("#msg").append(msg);
        }
    });
});