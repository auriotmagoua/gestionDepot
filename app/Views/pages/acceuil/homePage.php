<script>
  if (localStorage.getItem('autorisation') != "true") {
    window.location.href="/";
  }
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
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
          <!-- top tiles -->
          <div class="row" style="display: inline-block;" >
            <div class="tile_count">
              <div class="col-md-12 col-sm-12  tile_stats_count">
                <span class="count_top"><i class="fa fa-users"></i> Total Categorie Produit</span>
                <div class="count" id="idCategorie">...</div>
              </div>
              <div class="col-md-12 col-sm-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-users"></i> Date du Jour</span>
                <div class="count">  <?= date("d-M-Y") ?> </div>
              </div>

              <div id="all_vente" class="col-md-12 col-sm-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-users"></i> Total des ventes</span>
                <div class="count" id="all_vente_show">000 FCFA </div>
              </div>
            </div>
          </div>
          <!-- /top tiles -->

          <!--<br>-->

          <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Total des ventes </h2>
                    <div class="filter">
                      
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 ">
                      <div class="demo-container" style="height:280px">
                        <div id="chart_plot_02" class="demo-placeholder"></div>
                      </div>
                      <div class="tiles">
                        <div class="col-md-4 tile">
                          <span>Formation</span>
                          <h2>231,809</h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                               <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-4 tile">
                          <span>Stages</span>
                          <h2>$231,809</h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-4 tile">
                          <span>Freelance</span>
                          <h2>231,809</h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>

        </div> 
        <!-- /page content -->

        

      </div>
    </div>

    <!-- fonction  -->
    <script src="<?= base_url()?>GestionDepot/function/acceuil.js"></script>

    <!-- script locate to componenents -->
    <?= $this->include('components/js.php') ?>
    <!-- <script>
      let typeUser = localStorage.getItem('typeUser'); 
      if (typeUser != "admin") {
        $("#all_vente").hide(); 
      }
      // statistique
      statistiqueVente();
      function statistiqueVente(){
        let url = BASE_URL + "/produit/StatistiqueVente";

        $.ajax({
          url: url,
          method: "GET",
          dataType: 'json',
          headers: {"Authorization": "Bearer " + localStorage.getItem('token')},
            success: function (data) {
                console.log(data);
                $("#all_vente_show").html(data.totalVente+" FCFA"); 
            },
            error: function (data) {
                console.log(data.responseJSON);
                toastr["error"]("Oousp La connexion au serveur a été perdu", "Erreur");
            }
        });
      }
    </script> -->
  </body>
</html>
