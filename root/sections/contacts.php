<?php date_default_timezone_set('America/Guayaquil'); ?>
<div class="container casi90">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="section-heading">INFORMACIÓN</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="team-member">
                <iframe title="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15947.466338427086!2d-79.92957613022463!3d-2.204076099999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d71e18ae1f6f1%3A0x6953c97827a5956e!2sEmbutidos%20Jossy%20Supermercado%20de%20Carne%20Suburbio!5e0!3m2!1ses-419!2sec!4v1617254345791!5m2!1ses-419!2sec" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                <h4>Supermercado de Carne Suburbio </h4>
                <p class="text-muted">Frigomarket Esquinero, 21ava, y, Guayaquil</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="team-member">
                <iframe title="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15947.124452135004!2d-79.91189243022461!3d-2.235763399999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d6fdfae63052f%3A0x1407a63056623774!2sEmbutidos%20Jossy%20Supermercado%20De%20Carne%20Sur!5e0!3m2!1ses-419!2sec!4v1617254838487!5m2!1ses-419!2sec" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                <h4>Supermercado de Carne Sur</h4>
                <p class="text-muted">Cdla. Coviem Mz 34 Villa 9 - Guayaquil, Ecuador</p>

            </div>
        </div>
        <div class="col-sm-4">
            <div class="team-member">
                <h3>CONTACTO</h3>
                <h4>CELULAR:<em style="margin: 0 10px 0 10px;" class="fa fa-phone"></em><a target="_blank" href="tel:0992853567">0992853567</a></h4>
                <h4>WHATSAPP:<em style="margin: 0 10px 0 10px;" class="fab fa-whatsapp"></em><a target="_blank" href="https://api.whatsapp.com/send?phone=593992853567&fbclid=IwAR3PtLQfS1RzaqN3yIaD1zSt16PveE-Y-V44rvf85aZNFZ6HtjwIxMHiPYw">+593992853567</a></h4>
                <br><br>
                <?php
                $isOpen = '';
                $isOpenSunday = '';
                if (date('N') >= 1 && date('N') <= 6) {

                    $isOpen = date('H:i') >= '08:00' && date('H:i') <= '20:00'
                    ? '<span class="is-success"><em style="margin: 0 10px 0 0;" class="fa fa-clock"></em>Abierto</span>' 
                    : '<span class="is-danger"><em style="margin: 0 10px 0 0;" class="fa fa-clock"></em>Cerrado</span>';
                } else {
                    $isOpenSunday = date('H:i') >= '8:30' && date('H:i') <= '15:00' 
                    ? '<span class="is-success"><em style="margin: 0 10px 0 0;" class="fa fa-clock"></em>Abierto</span>' 
                    : '<span class="is-danger"><em style="margin: 0 10px 0 0;" class="fa fa-clock"></em>Cerrado</span>';
                }


                ?>
                <h3>Horario de Atención</h3>
                <h4>Lunes a Sábados</h4>
                <h5>08:00 - 20:00 </h5>
                <span><?= $isOpen ?></span>
                <h4>Domingos</h4>
                <h5>08:30 - 15:00 <span><?= $isOpenSunday ?></span></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">
            <!--<p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>-->
        </div>
    </div>
</div>
<br><br><br>