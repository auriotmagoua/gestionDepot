list_produit();
list_categorie_select2();

// imprimer la liste des produits dans le select 2
function list_categorie_select2() {
    
    let url = BASE_URL + "/categorie/List_categorie";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            let ligne = '<option value="0">Auccune categorie</option>';
            for (var i = 0; i < json.length; i++) {
                ligne += "";
                ligne = '<option value="'+json[i].idCategorie+'">'+json[i].nameCategorie.toUpperCase()+'</option>';
                // append select
                
            }
            
            $('#idCategorie').append(ligne);
            $('#idCategorieU').append(ligne);
            // $('#parent_edit').append(ligne);
            // $('#idProduit').append(ligne);

        },
        error: function(response){
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            Swal.close();
        }
    });
}


function list_produit() {
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
    let url = BASE_URL + "/produit/List_produit";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function(json){
            console.log(json);
            var tableau = new Array(json.length);
            
            for (var i = 0; i < json.length; i++) {
                // let status = '';
                let   modifier = '<button class="btn btn-outline-primary" onClick="select_data(' + json[i].idProduit + ','+(i)+');">Modifier</button>';
                let   supprimer = '<button class="btn btn-outline-danger" onClick="delete_row(' + json[i].idProduit + ','+i+')">Supprimer</button>';

                tableau[i] = new Array(5);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].nameProduit.toUpperCase()); 
                tableau[i][2] = (json[i].nameCategorie);
                tableau[i][3] = (json[i].prixProduit);
                tableau[i][4] = (modifier  +' '+ supprimer);

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
    let url = BASE_URL + "/produit/delete/"+id+"";
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
        text: "Êtes-vous sûr de vouloir supprimer ce produit définitivement ?",
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

function select_data(idProduit, ligne){
    
    let url = BASE_URL + "/produit/getOneProduit/"+idProduit+"";
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
        success: function (json) {
            if (json.success == true) {
                $('#ligne_update').val(ligne);
                $('#idProduitU').val(idProduit);
                $("#nameProduitU").val(json.data.nameProduit);
                $("#idCategorieU").val(json.data.idCategorieU);
                $("#prixProduitU").val(json.data.prixProduit);
                $("#modal_edit_produit").modal("show", true);
            }else if((json.success == false)){
                toastr["error"](json.msg, "Erreur");
            }
        },
        error: function (data) {
            toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
        }
    });

}

$('#form_update_produit').on('submit', function (e) {
    e.preventDefault();

    let url = BASE_URL + "/produit/update";
    $('#btn-log').prop('disabled', true);
    const formData = new FormData();

    var nameProduitU = $('#nameProduitU').val();
    var idCategorieU = $('#idCategorieU').val();
    var prixProduitU = $('#prixProduitU').val();
    var ligne_updateU = $('#ligne_update').val();
        // alert (ligne_updateU);

    if (nameProduitU == "" || idCategorieU == ""  || prixProduitU == "" || ligne_updateU == "") {
        $('#btn-log').prop('disabled', false);
        toastr["error"]("Informations Invalides, il se pourrait que vous n\'avez pas tout renseigner les champs obligatoires", "Erreur");

    } else {
        // add data form
        var data_form = $('#form_update_produit')[0];
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

                    let rowData = table.row(ligne_updateU).data();
                    // alert(rowData)
                    rowData[1] = nameProduitU.toUpperCase();
                    rowData[2] = nameCategorie;
                    rowData[3] = prixProduitU;
                    table.row(ligne_updateU).data(rowData).draw();
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
