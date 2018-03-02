<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Mis Licencias</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <?php if (empty($licencias)): ?>
                <h3><i class="fa fa-frown-o" aria-hidden="true"></i> No se encontraron Licencias</h3>
            <?php else: ?>
                <?php foreach($licencias as $licencia): ?>
                    <div class="project">
                        <div class="row bg-white has-shadow">
                            <div class="left-col col-lg-9 d-flex align-items-center justify-content-between">
                                <div class="project-title d-flex align-items-center">
                                    <div class="text">
                                        <h3 class="h4">Licencia de Giro</h3><small><?=$licencia->predio_calle?> #<?=$licencia->predio_numero_ext?> <?=$licencia->predio_municipio?>, <?=$licencia->predio_estado?></small>
                                    </div>
                                </div>
                                <div class="project-date"><span class="hidden-sm-down"><?=$licencia->descripcion_factibilidad?></span></div>
                            </div>
                            <div class="right-col col-lg-3 d-flex align-items-center">
                              <a href="<?=base_url()?>formatos/licencia_pdf?lic=<?= $this->utils->encode($licencia->id_licencia);?>&usu=<?= $this->utils->encode($licencia->id_usuario);?>" target="_blank" class="mui-btn mui-btn--primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Licencia</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
</div>
</div>
