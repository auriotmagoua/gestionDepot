<div class="top_nav">
  <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
            <img src="<?= base_url() ?>/GestionDepot/components/images/shopping.png" alt=""><b id="nav-person"></b> 
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="<?= base_url() ?>/user/LogOut"><i class="fa fa-sign-out pull-right"></i> Déconnexion</a>
            <a class="dropdown-item"  href="<?= base_url() ?>/user/Change_password"><i class="fa fa-user pull-right"></i> Mon compte</a>
          </div>
        </li>
        <li class="nav-item mr-4">
          <i>Temps restant </i>[ <b class="mb-0 mt-2 text-danger" id="timer"></b> ]
        </li>
      </ul>
    </nav>
  </div>
</div>

<script>
  $("#nav-person").html(localStorage.getItem('login'));
</script>
