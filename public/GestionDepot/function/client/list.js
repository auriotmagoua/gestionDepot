list_client();

function list_client() {

    let url = BASE_URL + "/client/List_client";
    let timerInterval;
    const swalloptions = {
        title: 'Veuillez patienter !',
        html: 'Chargement encour...',
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
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            for (var i = 0; i < json.length; i++) {
                let modifier = '';
                let supprimer = '';
                let typeUser = localStorage.getItem('typeUser'); 
               
                if (typeUser == "admin") {
                   modifier = '<button class="btn btn-outline-primary" onClick="select_data(' + json[i].idClient + ','+(i)+');">Modifier</button>';
                   supprimer = '<button class="btn btn-outline-danger" onClick="delete_row(' + json[i].idClient + ','+i+')">Supprimer</button>';
                }
                let   solde = '<button class="btn btn-outline-success" onclick="Solde_client(' + json[i].idClient + ')">Solde</button>'

                tableau[i] = new Array(4);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].nameClient.toUpperCase()); 
                tableau[i][2] = (json[i].phoneClient);
                tableau[i][3] = (modifier  +' '+ supprimer +' '+ solde);

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

function delete_row(id, ligne) {
    
    //let url = $('meta[name=app-url]').attr("content") + "/client/Delete/"+id+"";
    let url = BASE_URL + "/client/Delete/"+id+"";
    var table = $('#datatable-buttons').DataTable();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    
    swalWithBootstrapButtons.fire({
        title: 'Attention !!!',
        text: "Êtes-vous sûr de vouloir supprimer ce client définitivement ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // suppression
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
                success: function (data) {
                    if (data.success == true) {
                        // suppression de la ligne
                        table.row(ligne).remove();
                        // reorganise
                        let nbre_ligne = parseInt($('#datatable-buttons tr').length) - 1;
                        for (var i = 0; i <= (nbre_ligne - 1); i++) {
                            var cellule = table.cell(i, 0);
                            cellule.data(i + 1).draw();
                        }
                    }else if((data.success == false)){
                        swalWithBootstrapButtons.fire(
                            'Erreur',
                            data.msg,
                            'error'
                        )
                    }

                },
                error: function (data) {
                    swalWithBootstrapButtons.fire(
                        'Erreur',
                        'L\'opération a échouer.',
                        'error'
                    )
                }
            });
            
        } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Annuler',
                'L\'opération de suppression a été annulée.',
                'error'
            )
        }
    })
}

function select_data(idClient, ligne){
    
    //let url = $('meta[name=app-url]').attr("content") + "/client/getOneClient/"+idClient+"";
    let url = BASE_URL + "/client/getOneClient/"+idClient+"";
    
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function (json) {
            if (json.success == true) {
                $('#ligne_update').val(ligne);
                $('#idClientU').val(idClient);
                $("#nameClientU").val(json.data.nameClient);
                $("#phoneClientU").val(json.data.phoneClient);
                $("#modal_edit_client").modal("show", true);
            }else if((json.success == false)){
                toastr["error"](json.msg, "Erreur");
            }
        },
        error: function (data) {
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
        }
    });
}

$('#form_update_client').on('submit', function (e) {
    e.preventDefault();

    //let url = $('meta[name=app-url]').attr("content") + "/client/Update";
    let url = BASE_URL + "/client/Update";
    
    $('#btn-log').prop('disabled', true);
    const formData = new FormData();

    var nameClient = $('#nameClientU').val();
    var phoneClient = $('#phoneClientU').val();
    var ligne_update = $('#ligne_update').val();


    if (nameClient == "" || phoneClient == ""  || ligne_update == "") {
        $('#btn-log').prop('disabled', false);
        toastr["error"]("Informations Invalides, il se pourrait que vous n\'avez pas tout renseigner les champs obligatoires", "Erreur");

    } else {
        // add data form
        var data_form = $('#form_update_client')[0];
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
    
                    var table = $('#datatable-buttons').DataTable();

                    let rowData = table.row(ligne_update).data();
                    rowData[1] = nameClient.toUpperCase();
                    rowData[2] = phoneClient;

                    table.row(ligne_update).data(rowData).draw();
                    $('#btn-log').prop('disabled', false);
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



function Solde_client(idClient){
    //let url = $('meta[name=app-url]').attr("content") + "/client/Solde_client/"+idClient+"";
    let url = BASE_URL + "/client/Solde_client/"+idClient+"";
    
    window.location.href = url;
}