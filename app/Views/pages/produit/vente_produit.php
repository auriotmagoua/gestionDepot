<script>
  if (localStorage.getItem('autorisation') != "true") {
      window.location.href="/";
  }
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS locate component -->
    <?= $this->include('components/css.php') ?>
    <script src="<?= base_url()?>/GestionDepot/function/constant.js"></script>
    <script src="<?= base_url()?>/GestionDepot/function/produit/vente.js"></script>
    
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <!-- sideBar locate component -->
        <?= $this->include('components/sideBar.php') ?>

        <!-- nqvBar locate component -->
        <?= $this->include('components/navBar.php') ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>

                </div>
                <div class="x_content">
                    <div class="row">
                        <form action="" id="form_vente" class="col-12">
                            <!-- filtre -->
                            <div class="mx-2">
                                <h3><b>Le client :</b></h3>
                            </div>
                            <div class="col-sm-12 row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Non du client" name="nameC" id="nameC">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Contact du client" name="phoneC" id="phoneC">
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>

                            <div class="mx-2 mt-4">
                                <h3><b>Les produits :</b></h3>
                            </div>

                            <div class="col-sm-12  mt-3">
                                <div class="row clearfix">
                                    <div class="col-md-12  table-responsive">
                                        <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                            <thead>
                                                <tr id="addr0" data-id="0">
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">
                                                        Nom produit
                                                    </th>
                                                    <th class="text-center">
                                                        Prix Vente
                                                    </th>
                                                    <th class="text-center">
                                                        Quantite
                                                    </th>
                                                    <th class="text-center">
                                                        Total
                                                    </th>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr0' data-id="0" class="hidden">
                                                    <td> 1 </td>
                                                    <td data-name="name">
                                                        <select name='name[]' style="width:35vh"  placeholder='Name' class="form-control" id="name_0">
                                                        </select>
                                                    </td>
                                                    <td data-name="prix">
                                                        <input type="number"  name='prix[]' placeholder='Prix' id="prix_0" class="form-control"/>
                                                    </td>
                                                    <td data-name="quantite">
                                                        <input type="number" name="qte[]" placeholder="quantite" id="quantite_0" class="form-control">
                                                    </td>
                                                    <td data-name="total">
                                                        <input type="number" name="total[]" placeholder="total" id="total_0" class="form-control">
                                                    </td>
                                                    <!-- <td>
                                                        
                                                    </td> -->
                                                    <td data-name="del">
                                                        <button name="del0" type="button" class='btn btn-danger glyphicon glyphicon-remove'><span aria-hidden="true"></span></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row justify-content-end" style="margin-right: 1.5px;">
                                    <a id="add_row" class="btn btn-info mr-0 text-white"><i class="fa fa-plus"></i> Ajouter</a>
                                </div>

                                <div class="row" >
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="" class="float-left"><h4><b>Total :</b></h4></label>
                                            <input type="number" class="form-control" id="totalGlobal">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="float-left"><h4><b>Remise :</b></h4></label>
                                            <input type="number" class="form-control" name="remise" id="remise">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="float-left"><h4><b>Net a Payer :</b></h4></label>
                                            <input type="number" class="form-control" name="netAPayer" id="netAPayer">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="float-left"><h4><b>Mode de paiement :</b></h4></label>
                                            <select name="mode_paiement" class="form-control" id="mode_paiement">
                                                <option value="espece">ESPECE</option>
                                                <option value="orange_money">ORANGE MONEY</option>
                                                <option value="mtn_money">MTN MONEY</option>
                                                <option value="autre">AUTRE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group text-center">
                                    <div class="col-md-6 offset-md-3 mt-4">
                                        <button type='reset' class="btn btn-danger">Annuler</button>
                                        <button type='submit' class="btn btn-success" id="btn-log">Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                  </div>
              </div>
            </div>

          </div>
        </div>

        
        <!-- footer locate to componenents -->
        <?= $this->include('components/footer.php') ?>

      </div>
    </div>
    <script>
        $('#name_0').select2();
    </script>
    <!-- script locate to componenents -->
    <?= $this->include('components/js.php') ?>
    
  </body>
</html>
