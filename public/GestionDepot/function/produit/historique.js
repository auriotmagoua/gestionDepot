historique_vente(0);
list_facture();
function historique_vente(numAcheter) {
    let url = "";

    if (numAcheter == 0) {
        url = BASE_URL +  "/produit/historique_vente/0";
    }else{
        url = BASE_URL +  "/produit/historique_vente/"+numAcheter+"";
    }
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
        success: function(json){
            var tableau = new Array(json.length);
            // let nameProd = new Array()
            for (var i = 0; i < json.length; i++) {
                let buttonStyle = 'style="padding: 2px 2px; font-size: 16px;"'; // Ajuster la hauteur avec padding et diminuer la taille de la police
                let detail = '<button class="btn btn-outline-info" ' + buttonStyle + ' onClick="select_data(' + json[i].numAcheter + ','+(i)+');">Detail</button>';
                let modifier = '<button class="btn btn-outline-primary" ' + buttonStyle + ' onClick="modify_row(' + json[i].numAcheter + ','+i+')">Modifier</button>';
                let annuler = '';
                let typeUser = localStorage.getItem('typeUser'); 
               
                if (typeUser == "admin") {
                    annuler = '<button class="btn btn-outline-danger" ' + buttonStyle + ' onClick="annuler_row(\'' + json[i].numAcheter + '\','+ i +')">Annuler</button>';
                }
                let Imprimer = '<button class="btn btn-outline-secondary" ' + buttonStyle + ' onClick="print_row(' + json[i].numAcheter + ','+i+')">Imprimer</button>';
            
                // Encapsuler les boutons dans un div avec display:flex
                let buttonGroup = '<div style="display: flex; gap: 5px;">' + ' ' + annuler + ' ' + Imprimer + '</div>';
            
                tableau[i] = new Array(7);
                tableau[i][0] = (i + 1);
                tableau[i][1] = (json[i].nameAcheter ? json[i].nameAcheter.toUpperCase() : '');
                tableau[i][2] = (json[i].phone);
                tableau[i][3] = (json[i].numAcheter);
                tableau[i][4] = (json[i].nameProduit.toUpperCase());
                tableau[i][5] = new Date(json[i].created_at).toLocaleDateString();  
                tableau[i][6] = buttonGroup;
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
        },
        error: function(response){
            toastr["error"]("Oups, la connexion au serveur a été perdue", "Erreur");
        }
    });
    
    
}
function getHistorique(){
    let numAcheter = $("#facture").val();
    historique_vente(numAcheter);
}

function annuler_row(numAcheter, ligne) {
    let url = BASE_URL + "/produit/annuler/"+numAcheter+"";
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
        text: "Êtes-vous sûr de vouloir annuller cette facture définitivement ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, annuler',
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
                        list_facture();
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


function list_facture(){

    let url = BASE_URL + "/produit/getAllNumFact";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
        success: function(data) {
            // Ajouter les produits dans le select
            for (let i = 0; i < data.length; i++) {
                $('#facture').append('<option value="'+data[i].numAcheter+'">'+data[i].numAcheter.toUpperCase()+'</option>');
            }
  
        },
        error: function() {
            alert('Une erreur s\'est produite lors de la récupération des données.');
        }
    });
};