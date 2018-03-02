<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Mis Mensajes</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <table id="tblMensajes" class="display table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($mensajes as $mensaje): ?>
                        <tr role="row">
                            <td>
                                <b>Visor Urbano</b>
                                <?php if($mensaje->leido == 0): ?>
                                <span class="badge badge-success">Nuevo</span>
                                <?php endif; ?>
                            </td>
                            <td><?=$mensaje->mensaje?></td>
                            <td>
                                <?php
                                setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
                                echo iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime($mensaje->fecha)));
                                ?>
                            </td>
                            <td>
                                <a href="<?=base_url()?>admin/mis-mensajes/<?=$this->utils->encode($mensaje->id_mensaje) ?>"><i class="fa fa-envelope-open" aria-hidden="true"></i> Leer Mensaje</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
</div>
</div>