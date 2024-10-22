list_client();

function list_client(){

    let url = BASE_URL + "/client/List_client";
    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
        success: function(data) {
            // Ajouter les produits dans le select
            let option = '<option value="0">Choisir un client</option>';
            for (let i = 0; i < data.length; i++) {
                option += '<option value="'+data[i].idClient+'">'+data[i].nameClient.toUpperCase()+' / '+data[i].phoneClient +'</option>';
            }
            $("#idClient").append(option);
  
        },
        error: function() {
            alert('Une erreur s\'est produite lors de la récupération des données.');
        }
    });
};

$(document).ready(function() {
    var count = 0; // Initialiser le compteur de lignes

    // Initialisation du premier produit par défaut via AJAX
    let url = BASE_URL + "/produit/List_produit";

    $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
        headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
        success: function(data) {
            // Ajouter les produits dans le select de la ligne statique
            let option = '<option value="0">Sélectionner un produit</option>';
            for (let i = 0; i < data.length; i++) {
                option += '<option value="'+data[i].idProduit+'">'+data[i].nameProduit.toUpperCase()+'</option>';
            }
            $("#name_0").append(option);

            // Initialiser select2 après avoir ajouté les options
            $('#name_0').select2();

            // Sélectionner automatiquement le premier produit et définir le prix unitaire
            var firstProduct = data[0];
            if (firstProduct) {
                $('#name_0').val(firstProduct.idProduit);  // Utilise idProduit ici
                $('#prix_0').val(firstProduct.prixProduit); // Utilise prix
                $('#total_0').val(firstProduct.prixProduit * 1); // Quantité par défaut 1
                calculateTotal();
            }

            // Mettre à jour le prix si l'utilisateur change de produit dans la ligne statique
            $('#name_0').change(function() {
                updatePriceAndTotal($(this), firstProduct, 0);
            });
        },
        error: function() {
            alert('Une erreur s\'est produite lors de la récupération des données.');
        }
    });

    // Fonction pour ajouter une nouvelle ligne
    $('#add_row').on('click', function() {
        count++; // Incrémenter le compteur de lignes
        var htmlRows = '';

        // Générer le HTML pour la nouvelle ligne
        htmlRows += '<tr id="addr' + count + '" data-id="' + count + '">';
        htmlRows += '<td>' + (count + 1) + '</td>';
        htmlRows += '<td data-name="name">';
        htmlRows += '<select name="name[]" style="width:35vh" class="form-control" id="name_' + count + '"></select>';
        htmlRows += '</td>';
        htmlRows += '<td data-name="prix">';
        htmlRows += '<input type="number" name="prix[]" placeholder="Prix" id="prix_' + count + '" class="form-control"/>';
        htmlRows += '</td>';
        htmlRows += '<td data-name="quantite">';
        htmlRows += '<input type="number" name="qte[]" placeholder="Quantité" id="quantite_' + count + '" class="form-control">';
        htmlRows += '</td>';
        htmlRows += '<td data-name="total">';
        htmlRows += '<input type="number" name="total[]" placeholder="Total" id="total_' + count + '" class="form-control" readonly>';
        htmlRows += '</td>';
        htmlRows += '<td data-name="del">';
        htmlRows += '<button type="button" class="btn btn-danger glyphicon glyphicon-remove row-remove"><span aria-hidden="true"></span></button>';
        htmlRows += '</td>';
        htmlRows += '</tr>';

        // Ajouter la nouvelle ligne au tableau
        $('#tab_logic tbody').append(htmlRows);

        // Effectuer une requête AJAX pour récupérer les données de la base de données et remplir le select
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
            success: function(data) {
                // Ajouter les produits dans le select
                let option = '<option value="0">Sélectionner un produit</option>';
                for (let i = 0; i < data.length; i++) {
                    option += '<option value="'+data[i].idProduit+'">'+data[i].nameProduit.toUpperCase()+'</option>';
                }
                $('#name_' + count).append(option);

                    // // Initialiser select2 après avoir ajouté les options
                    // $('#name_' + count).select2();

                // Mettre à jour le prix lors de la sélection d'un produit
                $('#name_' + count).change(function() {
                    updatePriceAndTotal($(this), data, count);
                });
            },
            error: function() {
                alert('Une erreur s\'est produite lors de la récupération des données.');
            }
        });
    });

    // Fonction pour supprimer une ligne
    $(document).on('click', '.row-remove', function() {
        $(this).closest('tr').remove();
        calculateTotal(); // Mettre à jour le total après la suppression
    });

    // Fonction pour calculer le total global
    function calculateTotal() {
        var total = 0;
        $('#tab_logic tbody tr').each(function() {
            var quantity = $(this).find('input[name^="qte"]').val() || 0;
            var price = $(this).find('input[name^="prix"]').val() || 0;
            total += quantity * price;
            $(this).find('input[name^="total"]').val(quantity * price); // Met à jour le total de la ligne
        });
        
        // Afficher le total global
        $('#totalGlobal').val(total);

        // Calculer la remise et le montant net à payer
        var remise = $('#remise').val() || 0;
        var montantNetAPayer = total - remise;
        montantNetAPayer = montantNetAPayer < 0 ? 0 : montantNetAPayer; // Ne pas permettre des montants négatifs
        $('#netAPayer').val(montantNetAPayer);
    }

    // Recalculer le total lorsqu'on modifie quantité ou prix
    $(document).on('input', 'input[name^="qte"], input[name^="prix"]', function() {
        calculateTotal();
    });

    // Mettre à jour le total et le net à payer lors de la modification de la remise
    $('#remise').on('input', function() {
        calculateTotal(); // Recalculer le total global et le net à payer
    });

    // Fonction pour mettre à jour le prix et le total d'une ligne
    function updatePriceAndTotal(selectElement, data, rowIndex) {
        var selectedProductId = selectElement.val();
        var selectedProduct = data.find(function(product) {
            return product.idProduit == selectedProductId;
        });

        if (selectedProduct) {
            $('#prix_' + rowIndex).val(selectedProduct.prixProduit); // Utilise prix
            $('#total_' + rowIndex).val(selectedProduct.prixProduit * $('#quantite_' + rowIndex).val());
            calculateTotal(); // Mettre à jour le total global
        }
    }

});


//vendre produit
$(document).on("click", "#btn-log", function (e) {
    e.preventDefault();
    
    var idClient = $("#idClient").val();
    if (idClient == "") {
        $('#btn-log').prop('disabled', false);
        if (idClient == "" || idClient == null) {
            toastr["error"]("Veuillez choisir un client", "Attention");
        }
    }

    $('#btn-log').prop('disabled', true);

    var idUser = localStorage.getItem('idUser');
    var data_form = $('#form_vente')[0];
    const formData = new FormData(data_form);

    let url = BASE_URL + "/produit/vente_revendeur/"+ idUser;

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
                $('#form_vente')[0].reset();
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
}) 