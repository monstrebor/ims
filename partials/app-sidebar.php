<?php
    $user = $_SESSION['user'];
?>

<div class="dashboard_sidebar" id="dashboard_sidebar">
        <h3 class="dashboard_logo" id="dashboard_logo">I.M.S</h3>
            <div class="dashboard_sidebar_user">
                <img src="img/user.png" alt="User image." id="userImage" />
                <span><?= $user['first_name'] .' '. $user['last_name']?></span>
            </div>
        <div class="dashboard_sidebar_menus">
            <ul class="dashboard_menu_lists">
                <li class="menuActive liMainMenu">
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i><span class="menuTexts">Dashboard</span></a>
                </li>
            <li class="menuActive">
            <a href="javascript:void(0);" class="showHideSubMenu" id="showFormLink">
                    <i class="fa fa-truck showHideSubMenu"></i>
                    <span class="menuTexts showHideSubMenu">Product</span>
                    <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus">
                    <li class="subMenuLink"><a href="product-view.php"><i class="fa fa-circle-o"></i>View Product</a></li>
                    <li class="subMenuLink"><a href="product-add.php"><i class="fa fa-circle-o"></i>Add Product</a></li>
                </ul>
            </li>
            <li class="menuActive">
                <a href="javascript:void(0);" class="showHideSubMenu" id="showFormLink">
                    <i class="fa fa-truck showHideSubMenu"></i>
                    <span class="menuTexts showHideSubMenu">Supplier</span>
                    <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus">
                    <li class="subMenuLink"><a href="supplier-view.php"><i class="fa fa-circle-o"></i>View Supplier</a></li>
                    <li class="subMenuLink"><a href="supplier-add.php"><i class="fa fa-circle-o"></i>Add Supplier</a></li>
                </ul>
            </li>
            <li class="menuActive">
                <a href="javascript:void(0);" class="showHideSubMenu" id="showFormLink">
                    <i class="fa fa-shopping-cart showHideSubMenu"></i>
                    <span class="menuTexts showHideSubMenu">Purchase Order</span>
                    <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus">
                <li class="subMenuLink"><a href="product-order.php"><i class="fa fa-circle-o"></i>Create Order</a></li>
                    <li class="subMenuLink"><a href="view-order.php"><i class="fa fa-circle-o"></i>View order</a></li>
                </ul>
            </li>
            <li class="menuActive showHideSubMenu">
                <a href="javascript:void(0);" class="showHideSubMenu" id="showFormLink">
                    <i class="fa fa-user-plus showHideSubMenu"></i>
                    <span class="menuTexts showHideSubMenu">User</span>
                    <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus">
                    <li class="subMenuLink"><a href="users-view.php"><i class="fa fa-circle-o"></i>View Users</a></li>
                    <li class="subMenuLink"><a href="users-add.php"><i class="fa fa-circle-o"></i>Add Users</a></li>
                </ul>
            </li>
            </ul>
        </div>
    </div>
