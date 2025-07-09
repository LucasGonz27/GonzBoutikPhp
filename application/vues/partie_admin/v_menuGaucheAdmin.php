<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" data-key="t-menu">Menu</li>

            <li>
                <a href="index.php?controleur=Admin&action=afficherClient&display=minimal" class="liensMenu">
                    <i data-feather="home"></i>
                    <span data-key="t-dashboard">Tableau de bord</span>
                </a>
            </li>



            <li>
                <a href="javascript: void(0);" class="liensMenu">

                    <i data-feather="users"></i>
                    <span data-key="t-authentication">Tables</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index.php?controleur=Admin&action=afficherClient&display=minimal" class="liensMenu" data-key="t-login">Clients</a></li>
                        <li><a href="index.php?controleur=Admin&action=afficherProduit&display=minimal" class="liensMenu" data-key="t-register">Produits</a></li>
                        <li><a href="index.php?controleur=Admin&action=afficherFournisseur&display=minimal" class="liensMenu" data-key="t-register">Fournisseurs</a></li>
                        <li><a href="index.php?controleur=Admin&action=afficherCommande&display=minimal"  class="liensMenu" data-key="t-register">Commandes</a></li>
                        <li><a href="index.php?controleur=Admin&action=afficherMarque&display=minimal"  class="liensMenu" data-key="t-register">Marques</a></li>
                        <li><a href="index.php?controleur=Admin&action=afficherCategorie&display=minimal"  class="liensMenu" data-key="t-register">Catégorie</a></li>

                    </ul>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="liensMenu">
                    <i data-feather="file-text"></i>
                    <span data-key="t-pages">Pages</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="pages-starter.html" data-key="t-starter-page">Starter Page</a></li>
                    <li><a href="pages-404.html" data-key="t-error-404">Error 404</a></li>

                </ul>
            </li>

        </ul>


    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->