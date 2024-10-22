// $(document).ready(function() {
//     let url = BASE_URL + "/produit/numberProduit";
//     $.ajax({
//         url: url,
//         type: "GET",
//         headers: {"Authorization": "Bearer " +localStorage.getItem('token')},
//         success: function (data) {
//             $("#idCategorie").html(data);
//         },
//         error: function (data) {
//             $('#btn-log').prop('disabled', false);
//             toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
//         }
//     });
// });