list_payement();

function list_versement(numAcheter,ligne) {
    let timerInterval;
    const swalloptions = {
        title: 'Veuillez patienter !',
        html: 'Chargement en cours...',
        timerProgressBar: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }
    const swalPromise = Swal.fire(swalloptions);
    let idClient = $("#id_client_hidden").val();
    let url = BASE_URL + "/payement/ListPayementFact/"+numAcheter+"";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            for (var i = 0; i < json.length; i++) {
                tableau[i] = new Array(4);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].avance+" Fcfa"); 
                tableau[i][2] = (json[i].mode);
                tableau[i][3] = (json[i].created_at);
            }
            $('#datatable').DataTable().destroy();

            var handleDataTableButtons = function () {
                if ($("#datatable").length) {
                    $("#datatable").DataTable({
                        responsive: true,
                        data: tableau,
                        "scrollCollapse": true,
                        autoFill: true,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                        },
                    });
                }
            };
    
            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            TableManageButtons.init();
            Swal.close();
        },
        error: function(response){
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            Swal.close();
        }
    });
    swalPromise.then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer');
        }
    });
    
}

function list_payement() {
    let timerInterval;
    const swalloptions = {
        title: 'Veuillez patienter !',
        html: 'Chargement en cours...',
        timerProgressBar: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }
    const swalPromise = Swal.fire(swalloptions);
    let idClient = $("#id_client_hidden").val();
    let url = BASE_URL + "/payement/List_payement_client";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        data : {
            idClient: idClient
        },
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            for (var i = 0; i < json.length; i++) {
                let   versement = '';
                let   detail = '<button class="btn btn-outline-info" data-toggle="modal" data-target=".detailFact" onClick="list_versement(\'' + json[i].numAcheter + '\','+ i +')">Détail</button>';
                if ((json[i].montant - json[i].avance - json[i].remise) != 0) {
                    versement = '<button class="btn btn-outline-primary" data-toggle="modal" data-target=".bs-example-modal-lg" onClick="select_versement_row(\'' + json[i].numAcheter + '\','+ i +')">Versement</button>';
                }
                let reste = json[i].montant - json[i].avance - json[i].remise+" Fcfa";
                if (json[i].remise != 0) {
                    reste = json[i].montant - json[i].avance - json[i].remise+" Fcfa (R: "+json[i].remise+" Fcfa)";
                }
                tableau[i] = new Array(6);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].numAcheter); 
                tableau[i][2] = (json[i].montant+" Fcfa");
                tableau[i][3] = ((json[i].avance)+" Fcfa");
                tableau[i][4] = (reste);  
                tableau[i][5] = (versement+" "+detail);
            }
            $('#datatable-buttons').DataTable().destroy();

            var handleDataTableButtons = function () {
                if ($("#datatable-buttons").length) {
                    $("#datatable-buttons").DataTable({
                        responsive: true,
                        data: tableau,
                        "scrollCollapse": true,
                        autoFill: true,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                        },
                    });
                }
            };
    
            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            TableManageButtons.init();
            Swal.close();
        },
        error: function(response){
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            Swal.close();
        }
    });
    swalPromise.then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer');
        }
    });
    
}


function select_versement_row(numAcheter,ligne){
    $('#numAcheter').val(numAcheter);
    $('#ligne').val(ligne);
}



$('#form_versement').on('submit', function (e) {
    e.preventDefault();
    var idUser = localStorage.getItem('idUser');
    let url = BASE_URL + "/payement/Save_versement/"+idUser+"";
    $('#btn-log').prop('disabled', false);

    var montant = $("#montant").val();


    if (montant == "") {
        $('#btn-log').prop('disabled', false);
        if (montant == "" || montant == null) {
            toastr["error"]("Entrer le montant du versement", "Attention");
        }
        
    } else {
        // add data form
        var data_form = $('#form_versement')[0];
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
                    list_payement();
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


function resetForm() {
    $("#montant").val("");
}