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
                        <!-- filtre -->
                        <div class="col-sm-12 row">

                            <!-- <div class="col-md-3 col-sm-6 col-xs-12">
                                <div>
                                    <h4><b>Date du jour :</b></h4>
                                    <select class="form-control" name="formation" id="formation" onchange="getHistorique()">
                                        <option value="0">Toutes les dates</option>
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div>
                                    <h4><b>Numero Facture :</b></h4>
                                    <select class="form-control" name="facture" id="facture" onchange="getHistorique()">
                                        <option value="0">Toutes les factures</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="printf" style="width: 100%">

                        </div>
                        
                        <div class="col-sm-12 col-md-12 mt-3">
                          <div class="card-box table-responsive">
                          <table id="datatable-buttons" class="table table-bordered mt-5" style="width:100%" >
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Nom client</th>
                                <th>Contact</th>
                                <th>Num Fact</th>
                                <th>Produits</th>
                                <th>Date vente</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

          </div>
        </div>

        <!-- modal -->
        
        <!-- footer locate to componenents -->
        <?= $this->include('components/footer.php') ?>

      </div>
    </div>
    <script>
      $('#facture').select2();
    </script>
    <!-- script locate to componenents -->
    <?= $this->include('components/js.php') ?>
    <script src="<?= base_url()?>/GestionDepot/function/produit/historique.js"></script>
    <script>
      $('#datatable-buttons').DataTable();
    </script>
  </body>
</html>
