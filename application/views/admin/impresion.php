<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Impresión de Licencias</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <?php if (empty($licencias)): ?>
                <h3><i class="fa fa-frown-o" aria-hidden="true"></i> Aún no existen licencias para imprimir</h3>
            <?php else: ?>
                <div class="row">
                    <table id="tblImpresionLicencia" class="display table-striped dataTableVU" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No. Licencia</th>
                            <th>Usuario revisor</th>
                            <th>Solicitante</th>
                            <th>Giro</th>
                            <th>Clave Catastral</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($licencias as $licencia): ?>
                            <tr role="row">
                                <td><b><?= $licencia->folio_licencia ?></b></td>
                                <td>
                                    <?= (empty($licencia->usuario_ventanilla)?ucwords($licencia->usuario):ucwords($licencia->usuario_ventanilla))?>
                                </td>
                                <td>
                                    <?= ucwords($licencia->st2_nombre_solicitante).' '.ucwords($licencia->st2_primer_apellido_solicitante).' '.ucwords($licencia->st2_segundo_apellido_solicitante);?>
                                </td>
                                <td>
                                    <?= $licencia->descripcion_factibilidad ?>
                                </td>
                                <td>
                                    <?= $licencia->clave_catastral ?>
                                </td>
                                <td style="text-align: right">
                                    <a href="<?=base_url()?>formatos/licencia_pdf?lic=<?= $this->utils->encode($licencia->id_licencia);?>&usu=<?= $this->utils->encode($licencia->id_usuario);?>" target="_blank" class="mui-btn mui-btn--primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Licencia</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
</div>
</div>
