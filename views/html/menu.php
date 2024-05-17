<?php
require_once("../../models/Rol.php");
$rol = new Rol();

$datos = $rol->get_menu_x_rol($_SESSION["rol_id"]);
?>
<div class="vertical-menu">

    <div data-simplebar="" class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>


            <?php

                $firstIteration = true;

                foreach ($datos as $row) {
                    if ($_SESSION["rol_id"] == 1 || $_SESSION["rol_id"] == 2) {
                    ?>
                        <li>
                            <a href="<?php echo  $row["menu_ruta"] ?>">
                                <i data-feather="<?php echo  $row["menu_icon"] ?>"></i>
                                <span data-key="t-dashboard"><?php echo  $row["menu_nombre_vista"] ?></span>
                            </a>
                        </li>

                    <?php

                    } elseif ($_SESSION["rol_id"] == 3) {

                        if ($firstIteration) {
                        ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="grid"></i>
                                    <span data-key="t-apps">Mantenimiento</span>
                                </a>

                                <ul class="sub-menu" aria-expanded="false">

                                <?php
                                $firstIteration = false;
                                }


                                ?>

                                <li>
                                    <?php
                                    if ($row["menu_nombre_vista"] == "Inicio") {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?php echo  $row["menu_ruta"] ?>">
                                        <i data-feather="<?php echo  $row["menu_icon"] ?>"></i>
                                        <span data-key="t-chat"><?php echo  $row["menu_nombre_vista"] ?></span>
                                    </a>
                                </li>
                        <?php
                        
                        }
                    }
                    if ($_SESSION["rol_id"] == 3) {
                        ?>
                                        </ul>
                                    </li>
                        <?php
                    }

            ?>
            </ul>

            <?php
            if ($_SESSION["rol_id"] == 3 || $_SESSION["rol_id"] == 2 || $_SESSION["rol_id"] == 1) {
            ?>
                <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-3">
                    <div class="card-body">
                        <img src="<?php echo BASE_URL . 'assets/picture/gitfbox1.png'; ?>" width="130px">
                        <div class="mt-2">
                            <h5 class="alertcard-title font-size-16">DRE - ICA</h5>
                            <p class="font-size-13">El Futuro de la Educación es Ahora.</p>
                            <a href="https://www.gob.pe/institucion/regionica-dre/institucional" target="_blank" class="btn btn-primary mt-2">Saber Más</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Sidebar -->
    </div>
</div>