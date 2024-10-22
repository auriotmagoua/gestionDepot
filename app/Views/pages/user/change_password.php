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
                            <div class="x_title row justify-content-start">
                                <h4>Changer Mes Informations</h4>
                            </div>
                            <div class="card-box table-responsive">
                                <form class="" id="form_password" method="post">
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Login</label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" name="login2" id="login2"/>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Ancien Mot de passe <span class="required"></span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" type="password" id="passwd1" name="passwd1"/>
                                            <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
                                            <i id="slash" class="fa fa-eye-slash"></i>
                                            <i id="eye" class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nouveau Mot de passe <span class="required"></span></label>
                                        <div class="col-md-6 col-sm-6 position-relative">
                                            <input class="form-control" type="password" id="passwd2" name="passwd2" />
                                            <span style="position: absolute; right: 15px; top: 7px; cursor: pointer;" onclick="hideshowConfirm()">
                                                <i id="slashConfirm" class="fa fa-eye-slash" style="display: none;"></i>
                                                <i id="eyeConfirm" class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ln_solid">
                                        <div class="form-group text-center">
                                            <div class="col-md-6 offset-md-3 mt-4">
                                                <button type='reset' class="btn btn-danger">Annuler</button>
                                                <button type='submit' class="btn btn-success" id="btn-log">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <?= $this->include('components/js.php') ?>
    <script src="<?= base_url()?>/GestionDepot/function/user/changePasse.js"></script>
    <script>
        function hideshow(){
            var password = document.getElementById("passwd1");
            var slash = document.getElementById("slash");
            var eye = document.getElementById("eye");
            
            if(password.type === 'password'){
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
            }
            else{
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
            }
        }
        function hideshowConfirm() {
            var confirmPassword = document.getElementById("passwd2");
            var slashConfirm = document.getElementById("slashConfirm");
            var eyeConfirm = document.getElementById("eyeConfirm");

            if (confirmPassword.type === 'password') {
                confirmPassword.type = "text";
                slashConfirm.style.display = "block";
                eyeConfirm.style.display = "none";
            } else {
                confirmPassword.type = "password";
                slashConfirm.style.display = "none";
                eyeConfirm.style.display = "block";
            }
        }

        //afficher le login de lutilisateur le  champs login
        $('#login2').val(localStorage.getItem('login'));

    </script>

</body>

</html>
