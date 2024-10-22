list_user();

function list_user() {
    let url = BASE_URL + "/user/List_user";
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
                let buttonStyle = 'style="padding: 2px 2px; font-size: 16px;"'; // Ajuster la hauteur avec padding et diminuer la taille de la police
                let   supprimer = '<button class="btn btn-outline-danger" ' + buttonStyle + ' onClick="delete_row(' + json[i].idUser + ','+i+')">Supprimer</button>';
                let   reinitialiser = '<button class="btn btn-outline-success" ' + buttonStyle + ' onClick="reinitialiser_row(' + json[i].idUser + ','+(i)+');"><i class="fa fa-refresh"></i> Reinitialiser</button>';
                let password='******';
                if (json[i].login == "user") {
                    password = 'user'+json[i].idUser+'23';
                }
                
                tableau[i] = new Array(10);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].login.toUpperCase());
                tableau[i][2] = (password);
                tableau[i][3] = (reinitialiser  +' '+ supprimer);

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
    

}


function delete_row(id, ligne) {
    let url = BASE_URL + "/user/Delete/"+id+"";
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
        text: "Êtes-vous sûr de vouloir supprimer cet utilisateur definitivement ?",
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

function reinitialiser_row(id, ligne) {
    let url = BASE_URL + "/user/Reinitialiser_password/"+id+"";

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    
    swalWithBootstrapButtons.fire({
        title: 'Attention !!!',
        text: "Êtes-vous sûr de vouloir réinitialiser les identifiants de cet utilisateur ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, Réinitialiser',
        cancelButtonText: 'Annuler',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // reinitialisation du password
            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
                success: function (data) {
                    if (data.success == true) {
                        swalWithBootstrapButtons.fire(
                            data.msg,
                            data.data,
                            'success'
                        )
                        list_user(); 
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
                'L\'opération de réinitialisation a été annulée.',
                'error'
            )
        }
    })
}