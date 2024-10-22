<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <img src="<?= base_url() ?>/GestionDepot/components/images/logo_reduit.png" alt="Logo Sm@rtDiso" style="width: 50px" class="img-circle profile_img">
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
        <img src="<?= base_url() ?>/GestionDepot/components/images/shopping.png" alt="" class="img-circle profile_img">
        </div>
        <div class="profile_info">
        <span>Bienvenue,</span>
        <h2 id="login"> </h2>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <h3>Options</h3>
        <ul class="nav side-menu">
            <li class="">
                <a href="<?= base_url()?>/view/HomePage"><i class="fa fa-home"></i> Acceuil </a>
                <ul class="nav child_menu">
                </ul>
            </li>

            <li class="">
                <a href="<?= base_url()?>/view/Vente_produit"><i class="fa fa-money"></i> Vente </a>
                <ul class="nav child_menu">
                </ul>
            </li>

            <li class="">
                <a href="<?= base_url()?>/view/Historique_vente"><i class="fa fa-list"></i> Historique Vente </a>
                <ul class="nav child_menu">
                </ul>
            </li>

            <!-- <li class="option-admin"><a><i class="fa fa-circle"></i> Stock <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?= base_url()?>/view/Save_sortie">Sortie</a></li>
                    <li><a href="<?= base_url()?>view/SaveFrais_stagiaire">Avarie</a></li>
                </ul>
            </li> -->

            <hr>
            <h3>configuration</h3>
            <hr>

            <!-- <li class="option-admin">
                <a href="<?= base_url()?>/view/Save_produit"><i class="fa fa-plus"></i> Produits </a>
                <ul class="nav child_menu">
                </ul>
            </li> -->

            <li class="option-admin"><a><i class="fa fa-circle"></i>Produit<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?= base_url()?>/view/Save_produit">Ajouter Produit </a></li>
                    <li><a href="<?= base_url()?>/view/Save_categorie">Ajouter Categorie</a></li>
                    <li><a href="<?= base_url()?>/view/Save_entree">Entree </a></li>
                    <li><a href="<?= base_url()?>view/SaveFrais_stagiaire">Avarie </a></li>
                </ul>
            </li>

            <li class="">
                <a href="<?= base_url()?>/view/Save_client"><i class="fa fa-user"></i> Clients </a>
                <ul class="nav child_menu">
                </ul>
            </li>

            <li class="">
                <a href="<?= base_url()?>/view/Save_fournisseur"><i class="fa fa-user"></i> Fournisseurs </a>
                <ul class="nav child_menu">
                </ul>
            </li>

            <li class="option-admin">
                <a href="<?= base_url()?>/view/Save_user"><i class="fa fa-users"></i> Utilisateurs </a>
                <ul class="nav child_menu">
                </ul>
            </li>
          
        </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Déconnexion" href="<?= base_url() ?>/user/LogOut">
            <span class="fa fa-sign-out" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
    </div>
</div>

<script>
    // initialisation de la session
    let token = localStorage.getItem('token');
    let id_user = localStorage.getItem('idUser');
    let login = localStorage.getItem('login');
    let type_user = localStorage.getItem('typeUser');
    $("#login").html(localStorage.getItem('login'));
    if (type_user == "user") {
        $(".option-admin").hide();
    }
    
</script>