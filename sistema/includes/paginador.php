<div class="pagina">
    <ul>
        <?php
        //debug_to_console($pagina);

        if ($pagina != 1) {

        ?>
            <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">|<< </a>
            </li>
            <li><a href="?pagina=<?php echo $pagina - 1;  ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">
                    << </a>
            </li>

        <?php
        }
        for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
                echo '<li class="pageSelected">' . $i . '</li>';
            } else {
                echo '<li><a href="?pagina=' . $i . '&busqueda=' . $busqueda . '&start_date='. $fecha1 . '&end_date='. $fecha2 .' ">' . $i . '</a></li>';
            }
        }
        if ($pagina != $total_paginas && $total_paginas > 1) {

        ?>
            <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">>></a></li>
            <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">>|</a></li>
        <?php } ?>

    </ul>

</div>