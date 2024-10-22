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

                    <div class="row x_panel">
                        <div class="">
                            <div class="x_title row justify-content-end">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i> Ajouter une Categorie</button>
                            </div>
                            <div class="card-box table-responsive">
                                <table id="datatable-buttons" class="table table-bordered mt-5" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom categorie</th>
                                        <th>Nombre bouteille</th>
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
            <!-- /page content -->

           <!-- footer locate to componenents -->
            <?= $this->include('components/footer.php') ?>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade bs-example-modal-lg" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Enregistrer une Categorie</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                <form class="" id="form_categorie" method="post">
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nom Categorie<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="nameCategorie" id="nameCategorie" placeholder=""/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre Bouteilles<span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="number" min="0" name="nombreBouteille" id="nombreBouteille" placeholder="" />
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group text-center">
                            <div class="col-md-6 offset-md-3 mt-4">
                                <button type='reset' class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                <button type='submit' class="btn btn-success" id="btn-log">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        </div>
    </div>


    <!-- modal to update-->
    <div class="modal fade bs-example-modal-lg" id="modal_edit_categorie" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modifier une Categorie</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                <form class="" id="form_update_categorie" method="post">
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nom Categorie<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="nameCategorieU" id="nameCategorieU" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre Bouteille<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="number" min="0" name="nombreBouteilleU" id="nombreBouteilleU"/>
                            <input type="hidden" class="form-control" name="idCategorieU" id="idCategorieU" placeholder="" />
                            <input type="hidden" class="form-control" id="ligne_updateU"/>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group text-center">
                            <div class="col-md-6 offset-md-3 mt-4">
                                <button type='reset' class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                <button type='submit' class="btn btn-success" id="btn-log">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        </div>
    </div>
    
    <!-- script locate to componenents -->
    <!-- <script>
        $('#parent_save').select2();
        $('#parent_edit').select2();
    </script> -->
    <?= $this->include('components/js.php') ?>
    
    <script src="<?= base_url()?>/GestionDepot/function/categorie/list.js"></script>
    <script src="<?= base_url()?>/GestionDepot/function/categorie/save.js"></script>
    <script>
        $('#datatable-buttons').DataTable();
    </script>

</body>

</html>
