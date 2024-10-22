list_fournisseur();

function list_fournisseur() {

    let url = BASE_URL + "/fournisseur/List_fournisseur";
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
                let buttonStyle = 'style="padding: 2px 2px; font-size: 16px;"'; // Ajuster la hauteur avec padding et diminuer la taille de la police
                if (typeUser == "admin") {
                   modifier = '<button class="btn btn-outline-primary" ' + buttonStyle + ' onClick="select_data(' + json[i].idFournisseur + ','+(i)+');">Modifier</button>';
                   supprimer = '<button class="btn btn-outline-danger" ' + buttonStyle + ' onClick="delete_row(' + json[i].idFournisseur + ','+i+')">Supprimer</button>';
                }
                // let   solde = '<button class="btn btn-outline-success" onclick="Solde_client(' + json[i].idClient + ')">Solde</button>'

                tableau[i] = new Array(4);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].nameFournisseur.toUpperCase()); 
                tableau[i][2] = (json[i].phoneFournisseur);
                tableau[i][3] = (modifier  +' '+ supprimer);

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
    let url = BASE_URL + "/fournisseur/Delete/"+id+"";
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
        text: "Êtes-vous sûr de vouloir supprimer ce fournisseur définitivement ?",
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

function select_data(id, ligne){
    
    //let url = $('meta[name=app-url]').attr("content") + "/client/getOneClient/"+idClient+"";
    let url = BASE_URL + "/fournisseur/getOneFournisseur/"+id+"";
    
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function (json) {
            if (json.success == true) {
                $('#ligne_update').val(ligne);
                $('#idFournisseurU').val(json.data.idFournisseur);
                $("#nameFournisseurU").val(json.data.nameFournisseur);
                $("#phoneFournisseurU").val(json.data.phoneFournisseur);
                $("#modal_edit_fournisseur").modal("show", true);
            }else if((json.success == false)){
                toastr["error"](json.msg, "Erreur");
            }
        },
        error: function (data) {
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
        }
    });
}

$('#form_update_fournisseur').on('submit', function (e) {
    e.preventDefault();

    //let url = $('meta[name=app-url]').attr("content") + "/client/Update";
    let url = BASE_URL + "/fournisseur/Update";
    
    $('#btn-log').prop('disabled', true);
    const formData = new FormData();

    var nameFournisseurU = $('#nameFournisseurU').val();
    var phoneFournisseurU = $('#phoneFournisseurU').val();
    var ligne_update = $('#ligne_update').val();


    if (nameFournisseurU == "" || phoneFournisseurU == ""  || ligne_update == "") {
        $('#btn-log').prop('disabled', false);
        toastr["error"]("Informations Invalides, il se pourrait que vous n\'avez pas tout renseigner les champs obligatoires", "Erreur");

    } else {
        // add data form
        var data_form = $('#form_update_fournisseur')[0];
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
                    rowData[1] = nameFournisseurU.toUpperCase();
                    rowData[2] = phoneFournisseurU;

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



// function Solde_client(idClient){
//     //let url = $('meta[name=app-url]').attr("content") + "/client/Solde_client/"+idClient+"";
//     let url = BASE_URL + "/client/Solde_client/"+idClient+"";
    
//     window.location.href = url;
// }