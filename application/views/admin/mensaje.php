<div class="content-inner">
    <?php if ($error): ?>
        <section class="projects">
            <div class="container-fluid">
                <div class="alert alert-danger" role="alert">
                    <strong>Error.</strong> El mensaje que estas intentando acceder no existe ó no tienes los permisos suficientes para acceder a el.
                    <a href="<?=base_url()?>admin/mis-mensajes"> Ir a mi buzón</a>
                </div>
            </div>
        </section>
    <?php else: ?>
    <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom">
                    Visor Urbano
                    <small>
                        <?php
                        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
                        echo iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime($mensaje->fecha)));
                        ?>
                    </small>
                </h2>
            </div>
        </header>
        <!-- Projects Section-->
        <section class="projects">
            <div class="container-fluid">
                <div class="alert alert-warning">
                    <strong>Visor Urbano:</strong>
                    <br>
                    <?=$mensaje->mensaje?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>
</div>
</div>