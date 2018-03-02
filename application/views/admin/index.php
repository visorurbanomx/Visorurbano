<div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <?php if($this->session->userdata('level') == 2): ?>
                    <h2 class="no-margin-bottom">Listado de Trámites</h2>
                <?php else: ?>
                    <h2 class="no-margin-bottom">Mis Trámites</h2>
                <?php endif; ?>
            </div>
        </header>
        <!-- Projects Section-->
        <section class="projects">
            <div class="container-fluid">
                <?php if (empty($licencias)): ?>
                    <h3><i class="fa fa-frown-o" aria-hidden="true"></i> No se encontraron trámites asociados a este usuario</h3>
                <?php else: ?>
                    <?php foreach($licencias as $licencia): ?>
                        <div class="project">
                            <div class="row bg-white has-shadow">
                                <div class="left-col col-lg-<?php if($licencia->status !='FP'){echo 10;}else{echo 7;}?> d-flex align-items-center justify-content-between">
                                    <div class="project-title d-flex align-items-center">
                                        <div class="text">
                                            <h3 class="h4">Licencia de Giro</h3><small><?=$licencia->predio_calle?> #<?=$licencia->predio_numero_ext?> <?=$licencia->predio_municipio?>, <?=$licencia->predio_estado?></small>
                                        </div>
                                    </div>
                                    <div class="project-date"><span class="hidden-sm-down"><?=$licencia->descripcion_factibilidad?></span></div>
                                </div>
                                <div class="right-col col-lg-<?php if($licencia->status !='FP'){echo 2;}else{echo 5;}?> d-flex align-items-center">
                                    <?php if($licencia->status =='N'): ?>
                                        <a href="<?=base_url()?>nueva-licencia/<?= $this->utils->encode($licencia->id_licencia);?>/<?= $this->utils->encode($licencia->id_usuario);?>" class="mui-btn mui-btn--primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                    <?php endif; ?>
                                    <?php if($licencia->status =='FP'): ?>
                                        <!--<a href="<?=base_url()?>nueva-licencia/<?= $this->utils->encode($licencia->id_licencia);?>/<?= $this->utils->encode($licencia->id_usuario);?>" class="mui-btn mui-btn--primary"><i class="fa fa-eye" aria-hidden="true"></i> Ver Trámite</a>&nbsp;-->
                                        <a href="<?=base_url()?>formatos/orden_pago?lic=<?= $this->utils->encode($licencia->id_licencia);?>&usu=<?= $this->utils->encode($licencia->id_usuario);?>" target="_blank" class="mui-btn mui-btn--primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Propuesta de cobro</a>
                                    <?php endif; ?>
                                    <?php if($licencia->status =='V'): ?>
                                        <span style="color: #F44336;">En Ventanilla</span>
                                    <?php endif; ?>
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
