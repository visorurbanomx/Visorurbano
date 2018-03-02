<?php
//var_dump($licencia);
?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Solicitud de Licencia de Giro</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
               <?php if (!$error): ?>
                    <form id="frmSolicitudLicenciaGiro" class="frmAdmin mui-form">
                        <input type="hidden" id="claveCatastral" value="<?=$cuenta?>">
                        <input type="hidden" id="step" value="<?=$licencia->step?>">
                        <input type="hidden" id="tramite" value="<?=$licencia->id_licencia?>">
                        <input type="hidden" id="zncion" value="<?=$zonificacion?>">
                   <div>
                       <h3>Idenficación del Solicitante</h3>
                       <section>
                           <?php if ($this->session->userdata('level') > 1 && $licencia->status != 'V'): ?>
                               <div class="col-md-12">
                                   <div class="form-group">
                                       <label for="exampleInputFile"><b>* Adjuntar Carta Responsiva</b>&nbsp;&nbsp;&nbsp;<small><a  href="" data-toggle="modal" data-target="#responsivaModel"><i class="fa fa-download" aria-hidden="true"></i> Descarga aquí el formato</a></small></label>
                                       <input id="carta_responsiva" type="file" name="st1_carta_responsiva" class="form-control-file no_erase <?php if(!empty($st1_carta_responsiva)){echo 'valid';}?>" onchange="loadFile(this);" id="fleCrataResponsiva" aria-describedby="fileHelp" data-type="st1_carta_responsiva" data-elastic="fleCrataResponsivaElastic" data-text="Carta Responsiva">
                                       <div id="fleCrataResponsivaElastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">El formato requerido del archivo es: .pdf</small>
                                       <?php if(!empty($st1_carta_responsiva)):?>
                                           <a href="<?=$st1_carta_responsiva?>" target="_blank" class="link-to-file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta Responsiva</a>
                                       <?php endif;?>
                                   </div>
                               </div>
                           <?php endif; ?>
                           <div class="form-group seccionTipoSolicitantes">
                               <label><b>* Tipo de Solicitante:</b></label>
                               <br>
                               <input id="rbtPropietario" type="radio" name="st1_tipo_solicitante" value="propietario" <?php if(strtolower($st1_tipo_solicitante) == 'propietario') echo 'checked'; ?> required>
                               <label for="rbtPropietario">Soy Propietario del predio</label>
                               <br>
                               <input id="rbtPromotor" type="radio" name="st1_tipo_solicitante" value="promotor" <?php if(strtolower($st1_tipo_solicitante) == 'promotor') echo 'checked'; ?> required>
                               <label for="rbtPromotor">Soy Representante del propietario/Arrendatario</label>
                               <br>
                               <input id="rbtArrendatario" type="radio" name="st1_tipo_solicitante" value="arrendatario" <?php if(strtolower($st1_tipo_solicitante) == 'arrendatario') echo 'checked'; ?> required>
                               <label for="rbtArrendatario">Soy Arrendatario del predio</label>
                           </div>

                           <div id="seccionPromotor">
                               <div class="form-group">
                                   <label><b>* Tipo de Representante:</b></label>
                                   <br>
                                   <input id="rbtPromotorPropietario" type="radio" name="st1_tipo_representante" value="propietario" <?php if(strtolower($st1_tipo_representante) == 'propietario') echo 'checked'; ?> required>
                                   <label for="rbtPromotorPropietario">Soy Representante de persona física/moral que es dueña del predio</label>
                                   <br>
                                   <input id="rbtPromotorRenta" type="radio" name="st1_tipo_representante" value="arrendatario" <?php if(strtolower($st1_tipo_representante) == 'arrendatario') echo 'checked'; ?> required>
                                   <label for="rbtPromotorRenta">Soy Representante de persona física/moral que está rentando el predio</label>
                                   <br>
                               </div>

                               <div class="form-group">
                                   <label><b>* Tipo Poder:</b></label>
                                   <br>
                                   <input id="rbtCartaPoderSimple" type="radio" name="st1_tipo_carta_poder" value="simple" <?php if(strtolower($st1_tipo_carta_poder) == 'simple' || empty($st1_tipo_representante)) echo 'checked'; ?> required>
                                   <label for="rbtCartaPoderSimple">Carta Poder Simple</label>
                                   <br>
                                   <input id="rbtCartaPoderNotariada" type="radio" name="st1_tipo_carta_poder" value="notariada" <?php if(strtolower($st1_tipo_carta_poder) == 'notariada') echo 'checked'; ?> required>
                                   <label for="rbtCartaPoderNotariada">Carta Poder Notariada/Poder Notarial</label>
                               </div>

                              <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="exampleInputFile"><b>* Adjuntar Carta Poder</b>&nbsp;&nbsp;&nbsp;<small><a href="<?=base_url()?>formatos/carta_poder.docx"><i class="fa fa-download" aria-hidden="true"></i> Descarga aquí el formato</a></small></label>
                                           <input type="file" name="st1_carta_poder" class="form-control-file erase <?php if(!empty($st1_carta_poder)){echo 'valid';}?>" onchange="loadFile(this);" id="fleCrataPoder" aria-describedby="fileHelp" data-type="st1_carta_poder" data-elastic="fleCrataPoderElastic" data-text="Carta poder">
                                           <div id="fleCrataPoderElastic" class="progress-bar-custom"></div>
                                           <small id="fileHelp" class="form-text text-muted">Carta Poder simple firmada por el otorgante y dos testigos.<br>El formato requerido del archivo es: .pdf</small>
                                           <?php if(!empty($st1_carta_poder)):?>
                                            <a href="<?=$st1_carta_poder?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta Poder</a>
                                           <?php endif;?>
                                       </div>
                                   </div>
                                   <div class="col-md-6 ">
                                       <div class="form-group anexoCartaPoder">
                                           <label for="exampleInputFile"><b>* Adjuntar Identificación del Otorgante</b></label>
                                           <input type="file" class="form-control-file erase <?php if(!empty($st1_identificacion_otorgante)){echo 'valid';}?>" id="fleIdentificacionOtorgante" name="fleIdentificacionOtorgante" onchange="loadFile(this);" aria-describedby="fileHelp" data-type="st1_identificacion_otorgante" data-elastic="fleIdentificacionOtorganteElastic" data-text="Identificación del otorgante">
                                           <div id="fleIdentificacionOtorganteElastic" class="progress-bar-custom"></div>
                                           <small id="fileHelp" class="form-text text-muted">puede ser (INE, IFE, Pasaporte); la identicficacón debe estar vigente.<br>El formato requerido del archivo es: .pdf</small>
                                           <?php if(!empty($st1_identificacion_otorgante)):?>
                                               <a href="<?=$st1_identificacion_otorgante?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Identificación del otorgante</a>
                                           <?php endif;?>
                                       </div>
                                   </div>
                               </div>
                               <div class="row anexoCartaPoder">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="exampleInputFile"><b>* Identificación Testigo 1</b></label>
                                           <input type="file" class="form-control-file erase <?php if(!empty($st1_identificacion_testigo1)){echo 'valid';}?>" id="fleTestigo1" onchange="loadFile(this);" name="fleTestigo1" aria-describedby="fileHelp" data-type="st1_identificacion_testigo1" data-elastic="fleTestigo1Elastic" data-text="Identificación del testigo 1">
                                           <div id="fleTestigo1Elastic" class="progress-bar-custom"></div>
                                           <small id="fileHelp" class="form-text text-muted">puede ser (INE, IFE, Pasaporte); la identicficacón debe estar vigente.<br>El formato requerido del archivo es: .pdf</small>
                                           <?php if(!empty($st1_identificacion_testigo1)):?>
                                               <a href="<?=$st1_identificacion_testigo1?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Identificación del testigo 1</a>
                                           <?php endif;?>
                                       </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="exampleInputFile"><b>* Identificación Testigo 2</b></label>
                                           <input type="file" class="form-control-file erase <?php if(!empty($st1_identificacion_testigo2)){echo 'valid';}?>" id="fleTestigo2" onchange="loadFile(this);" name="fleTestigo2" aria-describedby="fileHelp" data-type="st1_identificacion_testigo2" data-elastic="fleTestigo2Elastic" data-text="Identificación del testigo 2">
                                           <div id="fleTestigo2Elastic" class="progress-bar-custom"></div>
                                           <small id="fileHelp" class="form-text text-muted">puede ser (INE, IFE, Pasaporte); la identicficacón debe estar vigente.<br>El formato requerido del archivo es: .pdf</small>
                                           <?php if(!empty($st1_identificacion_testigo2)):?>
                                               <a href="<?=$st1_identificacion_testigo2?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Identificación del testigo 2</a>
                                           <?php endif;?>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div id="seccionArrendatario">
                               <div class="form-group">
                                   <label for="exampleInputFile"><b>* Adjuntar Contrato de arrendamiento</b></label>
                                   <input type="file" class="form-control-file erase <?php if(!empty($st1_contrato_arrendamiento)){echo 'valid';}?>" onchange="loadFile(this);" id="fleContratoArrendamiento" name="fleContratoArrendamiento" aria-describedby="fileHelp" data-type="st1_contrato_arrendamiento" data-elastic="fleContratoArrendamientoElastic" data-text="Contrato arrendamiento">
                                   <div id="fleContratoArrendamientoElastic" class="progress-bar-custom"></div>
                                   <small id="fileHelp" class="form-text text-muted">El formato requerido del archivo es: .pdf</small>
                                   <?php if(!empty($st1_contrato_arrendamiento)):?>
                                       <a href="<?=$st1_contrato_arrendamiento?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Contrato de arrendamiento</a>
                                   <?php endif;?>
                               </div>

                               <div class="form-group">
                                   <label><b>* ¿El contrato de arrendamiento te faculta para abrir un negocio?</b></label>
                                   <br>
                                   <input id="rbtFacultaSi" type="radio" name="st1_faculta" value="s" <?php if(strtolower($st1_faculta) == 's') echo 'checked'; ?> required>
                                   <label for="rbtFacultaSi">Si</label>
                                   <br>
                                   <input id="rbtFacultaNo" type="radio" name="st1_faculta" value="n" <?php if(strtolower($st1_faculta) == 'n') echo 'checked'; ?> required>
                                   <label for="rbtFacultaNo">No</label>
                               </div>
                               <div id="seccionAnuencia">
                                   <div class="form-group">
                                       <label><b>* ¿Cuentas con la anuencia del arrendador para abrir un negocio?</b></label>
                                       <br>
                                       <input id="rbtAnuenciaSi" type="radio" name="st1_anuencia" value="s" <?php if(strtolower($st1_anuencia) == 's') echo 'checked'; ?> required>
                                       <label for="rbtAnuenciaSi">Si</label>
                                       <br>
                                       <input id="rbtAnuenciaNo" type="radio" name="st1_anuencia" value="n" <?php if(strtolower($st1_anuencia) == 'n') echo 'checked'; ?> required>
                                       <label for="rbtAnuenciaNo">No</label>
                                   </div>
                               </div>
                               <div id="seccionCartaAnuencia">
                                   <div class="form-group">
                                       <label for="exampleInputFile"><b>* Adjuntar Carta de Anuencia</b>&nbsp;&nbsp;&nbsp;<small><a href="<?=base_url()?>formatos/carta_anuencia.docx"><i class="fa fa-download" aria-hidden="true"></i> Descarga aquí el formato</a></small></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st1_carta_anuencia)){echo 'valid';}?>" onchange="loadFile(this);" id="fleAnuencia" name="fleAnuencia" aria-describedby="fileHelp" data-type="st1_carta_anuencia" data-elastic="fleAnuenciaElastic" data-text="Carta anuencia">
                                       <div id="fleAnuenciaElastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">El formato requerido del archivo es: .pdf</small>
                                       <?php if(!empty($st1_carta_anuencia)):?>
                                           <a href="<?=$st1_carta_anuencia?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta de anuencia</a>
                                       <?php endif;?>
                                   </div>
                               </div>

                           </div>
                       </section>

                       <h3>Datos del Solicitante</h3>
                       <section>
                           <div id="secRepresentante">
                               <h3>Datos del Representante</h3>
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtNombreRep" type="text" name="st2_nombre_representante" class="input-material" value="<?=$st2_nombre_representante;?>" required>
                                           <label for="txtNombreRep">* Nombre(s) del Representante</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtPApellido" type="text" name="st2_priper_apellido_representante" class="input-material" value="<?=$st2_priper_apellido_representante;?>" required>
                                           <label for="txtPApellido">* Primer Apellido del Representante</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtSApellido" type="text" name="st2_segundo_apellido_representante" class="input-material" value="<?=$st2_segundo_apellido_representante;?>">
                                           <label for="txtSApellido">Segundo apellido del Representante</label>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtCURPRep" type="text" name="st2_curp_representante" class="input-material upercase" value="<?=$st2_curp_representante;?>" maxlength="18" required>
                                           <label for="txtCURPRep">* C.U.R.P.</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtRFCRep" type="text" name="st2_rfc_representante" class="input-material upercase" value="<?=$st2_rfc_representante;?>" maxlength="13" required>
                                           <label for="txtRFCRep">* R.F.C.</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtEmailRep" type="email" name="st2_email_representante"  class="input-material" value="<?=$st2_email_representante;?>" required>
                                           <label for="txtEmailRep">* Correo Electrónico</label>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-8">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtDomicilioRep" type="text" name="st2_domicilio_representante" class="input-material" value="<?=$st2_domicilio_representante;?>" required>
                                           <label for="txtDomicilioRep">* Domicilio</label>
                                       </div>
                                   </div>
                                   <div class="col-md-2">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtNExteriorRep" type="text" name="st2_num_ext_representante" class="input-material" value="<?=$st2_num_ext_representante;?>" required>
                                           <label for="txtNExteriorRep">* No. Exterior</label>
                                       </div>
                                   </div>
                                   <div class="col-md-2">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtNInteriorRep" type="text" name="st2_num_int_representante" class="input-material" value="<?=$st2_num_int_representante;?>">
                                           <label for="txtNInteriorRep">No. Interior</label>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-8">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtColoniaRep" type="text" name="st2_colonia_representante" class="input-material" value="<?=$st2_colonia_representante;?>" required>
                                           <label for="txtColoniaRep">* Colonia</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtCPRep" type="text" maxlength="5" name="st2_cp_representante" class="input-material" value="<?=$st2_cp_representante;?>" required>
                                           <label for="txtCPRep">* Código Postal</label>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-8">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtCiudadRep" type="text" name="st2_ciudad_representante" class="input-material" value="<?=$st2_ciudad_representante;?>" required>
                                           <label for="txtCiudadRep">* Ciudad</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtTelefonoRep" type="text" name="st2_telefono_representante"  class="input-material" value="<?=$st2_telefono_representante;?>" required>
                                           <label for="txtTelefonoRep">* Teléfono</label>
                                       </div>
                                   </div>
                               </div>
                               <br><br>
                               <div class="row">
                                   <div class="form-group">
                                       <label for="fleIFESolicitante"><b>* Adjuntar Identificación Oficial Vigente del representante, puede ser (INE, IFE, Pasaporte) </b></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st2_identificacion_representante)){echo 'valid';}?>" id="fleIFERepresentante" onchange="loadFile(this);" aria-describedby="fileHelp" name="st2_identificacion_representante" data-type="st2_identificacion_representante" data-elastic="fleIFERepresentanteElastic" data-text="Identificación del representante">
                                       <div id="fleIFERepresentanteElastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">La imagen debera contener frente y reverso ademas debe ser escaneada del documento original en formato .pdf.</small>
                                       <?php if(!empty($st2_identificacion_representante)):?>
                                           <a id="id_representante" href="<?=$st2_identificacion_representante?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Identificacón del representante</a>
                                       <?php endif;?>
                                   </div>
                               </div>
                           </div>
                               <br><br>
                               <h3>Datos del Propietario/Arrendatario</h3>
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtNombre" type="text" name="st2_nombre_solicitante" class="input-material" value="<?=$st2_nombre_solicitante;?>" required>
                                           <label for="txtNombre">* Nombre del Propietario/Arrendatario</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtPApellidoSolicitante" type="text" name="st2_primer_apellido_solicitante" class="input-material" value="<?=$st2_primer_apellido_solicitante;?>" required>
                                           <label for="txtPApellidoSolicitante">* Primer Apellido del Propietario/Arrendatario</label>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="mui-textfield mui-textfield--float-label nerror">
                                           <input id="txtSApellidoSolicitante" type="text" name="st2_segundo_apellido_solicitante" class="input-material" value="<?=$st2_segundo_apellido_solicitante;?>">
                                           <label for="txtSApellidoSolicitante">Segundo Apellido del Propietario/Arrendatario</label>
                                       </div>
                                   </div>
                               </div>
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtCURP" type="text" name="st2_curp_solicitante" class="input-material upercase" value="<?=$st2_curp_solicitante;?>" maxlength="18" required>
                                       <label for="txtCURP">* C.U.R.P.</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtRFC" type="text" name="st2_rfc_solicitante" class="input-material upercase" value="<?=$st2_rfc_solicitante;?>" maxlength="13" required>
                                       <label for="txtRFC">* R.F.C.</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtEmail" type="email" name="st2_email_solicitante" class="input-material" value="<?=$st2_email_solicitante;?>" required>
                                       <label for="txtEmail">Correo Electrónico</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtDomicilio" type="text" name="st2_domicilio_solicitante" class="input-material" value="<?=$st2_domicilio_solicitante;?>" required>
                                       <label for="txtDomicilio">* Domicilio</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtNExterior" type="text" name="st2_num_ext_solicitante" class="input-material" value="<?=$st2_num_ext_solicitante;?>" required>
                                       <label for="txtNExterior">* No. Exterior</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtNInterior" type="text" name="st2_num_int_solicitante" value="<?=$st2_num_int_solicitante;?>" class="input-material">
                                       <label for="txtNInterior">No. Interior</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtColonia" type="text" name="st2_colonia_solicitante" class="input-material" value="<?=$st2_colonia_solicitante;?>" required>
                                       <label for="txtColonia">* Colonia</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtCP" type="text" maxlength="5" name="st2_cp_solicitante" class="input-material" value="<?=$st2_cp_solicitante;?>" required>
                                       <label for="txtCP">* Código Postal</label>
                                   </div>
                               </div>
                               <div class="col-md-8">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtCiudad" type="text" name="st2_ciudad_solicitante" class="input-material" value="<?=$st2_ciudad_solicitante;?>" required>
                                       <label for="txtCiudad">* Ciudad</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtTelefono" type="text" name="st2_telefono_solicitante" class="input-material" value="<?=$st2_telefono_solicitante;?>" required>
                                       <label for="txtTelefono">* Teléfono</label>
                                   </div>
                               </div>
                           </div>
                               <br><br>
                          <div class="row cont-identificacion-solicitante">
                              <div class="form-group">
                                  <label for="fleIFESolicitante"><b>* Adjuntar Identificación Oficial Vigente del propietario/Arrendatario, puede ser (INE, IFE, Pasaporte) </b></label>
                                  <input type="file" class="form-control-file erase <?php if(!empty($st2_identidficacion_solicitante)){echo 'valid';}?>" onchange="loadFile(this);" id="fleIFESolicitante" name="st2_identidficacion_solicitante" aria-describedby="fileHelp" data-type="st2_identidficacion_solicitante" data-elastic="fleIFESolicitanteElastic" data-text="Identificación del solicitante">
                                  <div id="fleIFESolicitanteElastic" class="progress-bar-custom"></div>
                                  <small id="fileHelp" class="form-text text-muted">La imagen debera contener frente y reverso ademas debe ser escaneada del documento original en formato .pdf.</small>
                                  <?php if(!empty($st2_identidficacion_solicitante)):?>
                                      <a id="id_solicitante" href="<?=$st2_identidficacion_solicitante?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Identificación del solicitante</a>
                                  <?php endif;?>
                              </div>
                          </div>
                       </section>
                       <h3>Datos del Establecimiento</h3>
                       <section>
                           <div class="row">
                               <div class="col-md-12">
                                   <h3>Clave Catastral: <?=$cuenta?></h3>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <h3>Actividad Especifica: <span id="descActividad"><?=$descripcion_factibilidad?></span></h3>
                               </div>
                           </div>

                           <div class="mui-textfield mui-textfield--float-label nerror">
                               <input id="txtNombreNegocio" type="text" name="st3_nombre_establecimiento"  class="input-material" value="<?=$st3_nombre_establecimiento;?>">
                               <label for="txtNombreNegocio">Nombre comercial del negocio</label>
                           </div>
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtDomicilio_establecimiento" type="text" name="st3_domicilio_establecimiento"  class="input-material" value="<?=$st3_domicilio_establecimiento;?>" required>
                                       <label for="txtDomicilio_establecimiento">* Calle</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtNExterior_establecimiento" type="text" name="st3_num_ext_establecimiento"  class="input-material" value="<?=$st3_num_ext_establecimiento;?>" required>
                                       <label for="txtNExterior_establecimiento">* No. Exterior</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtLExterior" type="text" name="st3_letra_ext_establecimiento" class="input-material" maxlength="1" value="<?=$st3_letra_ext_establecimiento;?>">
                                       <label for="txtLExterior">Letra Exterior</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtColoniaEstablecimiento" type="text" name="st3_colonia_establecimiento" class="input-material" value="<?=$st3_colonia_establecimiento;?>" required>
                                       <label for="txtColoniaEstablecimiento">* Colonia</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtNInterior_establecimiento" type="text" name="st3_num_int_establecimiento" class="input-material" value="<?=$st3_num_int_establecimiento;?>">
                                       <label for="txtNInterior_establecimiento">No. Interior</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtLInterior" type="text" name="st3_letra_int_establecimiento" maxlength="1" class="input-material" value="<?=$st3_letra_int_establecimiento;?>">
                                       <label for="txtLInterior">Letra Interior</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-5">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtCiudadEstablecimiento" type="text" name="st3_ciudad_establecimiento" class="input-material" value="<?=$st3_ciudad_establecimiento;?>" required>
                                       <label for="txtCiudadEstablecimiento">* Ciudad</label>
                                   </div>
                               </div>
                               <div class="col-md-5">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtEstadoEstablecimiento" type="text" name="st3_estado_establecimiento" class="input-material" value="<?=$st3_estado_establecimiento;?>" required>
                                       <label for="txtEstadoEstablecimiento">* Estado</label>
                                   </div>
                               </div>
                               <div class="col-md-2">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtCPEstablecimiento" type="text" maxlength="5" name="st3_cp_establecimiento" class="input-material" value="<?=$st3_cp_establecimiento;?>" required>
                                       <label for="txtCPEstablecimiento">* Código Postal</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row" style="display: <?php echo $st3_asignacion_numero != "" ? 'block' : 'none'; ?>;" id="asignacion_numero">
                               <div class="col-md-12">

                                       <label for="exampleInputFile"><b>* Adjuntar Certificado de Alineamiento y Número Oficial</b></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st3_asignacion_numero)){echo 'valid';}?>" id="fleFotoLocal4" onchange="loadFile(this);" name="st3_asignacion_numero" aria-describedby="fileHelp" data-type="st3_asignacion_numero" data-elastic="fleFotoLocal4Elastic" data-text="Dictamen de lineamiento y número oficial">
                                       <div id="fleFotoLocal4Elastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">Debe ser escaneada del documento original en formato .pdf.</small>
                                       <?php if(!empty($st3_asignacion_numero)):?>
                                           <a id="file_asignacion_numero" href="<?=$st3_asignacion_numero?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Asignación de numero oficial</a>
                                       <?php endif;?>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtEspecificaciones" type="text" name="st3_especificaciones_establecimiento" class="input-material" value="<?=$st3_especificaciones_establecimiento;?>">
                                       <label for="txtEspecificaciones">Referencias del inmueble</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-3">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtEdificioPlaza" type="text" name="st3_edificio_plaza_establecimiento" class="input-material" value="<?=$st3_edificio_plaza_establecimiento;?>" required>
                                       <label for="txtEdificioPlaza">* Edificio, Plaza o Local</label>
                                   </div>
                               </div>
                               <div class="col-md-3">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtLocal" type="text" name="st3_num_local_establecimiento" class="input-material" value="<?=$st3_num_local_establecimiento;?>" required>
                                       <label for="txtLocal">* Número del Local</label>
                                   </div>
                               </div>
                               <div class="col-md-3">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtSupConstruida" type="text" name="st3_sup_construida_establecimiento" class="input-material" value="<?=$st3_sup_construida_establecimiento;?>" required readonly>
                                       <label for="txtSupConstruida">* Sup. Construida mts<sup>2</sup>.</label>
                                   </div>
                               </div>
                               <div class="col-md-3">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtAreaUtilizar" type="text" name="st3_area_utilizar_establecimiento" class="input-material" value="<?=$st3_area_utilizar_establecimiento;?>" required>
                                       <label for="txtAreaUtilizar">* Area a utilizar mts<sup>2</sup>.</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtInversion" type="text" name="st3_inversion_establecimiento"  class="input-material" value="<?=$st3_inversion_establecimiento;?>" required>
                                       <label for="txtInversion">* Inversión Estimada</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <input id="txtEmpleados" type="text" name="st3_empleados_establecimiento"  class="input-material" value="<?=$st3_empleados_establecimiento;?>" required>
                                       <label for="txtEmpleados">* No. Empleados</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="mui-textfield mui-textfield--float-label nerror">
                                       <?php if ($zonificacion == 'H1' || $zonificacion == 'H2' || $zonificacion == 'H3' || $zonificacion == 'H4' || $zonificacion == 'H5'): ?>
                                           <input id="txtCajonesEstacionamiento" type="text" name="st3_cajones_estacionamiento_establecimiento" autocomplete="off" class="input-material" value="0" required>
                                       <?php else: ?>
                                           <input id="txtCajonesEstacionamiento" type="text" name="st3_cajones_estacionamiento_establecimiento" autocomplete="off" class="input-material" value="<?=$st3_cajones_estacionamiento_establecimiento;?>" required>
                                       <?php endif; ?>
                                       <label for="txtCajonesEstacionamiento">* No. Cajones de estacionamiento </label>
                                   </div>
                               </div>
                           </div>
                           <div class="row cont-dictamen-tecnico-movilidad" style="display: <?php echo $st3_dictamen_tecnico_movilidad != "" ? 'block' : 'none'; ?>;" id="dictamen_tecnico">
                               <div class="col-md-12">
                                   <label for="fleDictamenMovilidad"><b>* Adjuntar Dictamen Técnico de movilidad </b></label>
                                   <input type="file" class="form-control-file erase <?php if(!empty($st3_dictamen_tecnico_movilidad)){echo 'valid';}?>" onchange="loadFile(this);" id="fleDictamenMovilidad" name="st3_dictamen_tecnico_movilidad" aria-describedby="fileHelp" data-type="st3_dictamen_tecnico_movilidad" data-elastic="fleIFESolicitanteElastic" data-text="Dictamen Técnico de Movilidad">
                                   <div id="fleDictamenMovilidadElastic" class="progress-bar-custom"></div>
                                   <small id="fileHelp" class="form-text text-muted">Debe ser escaneado del documento original en formato .pdf.</small>
                                   <?php if(!empty($st3_dictamen_tecnico_movilidad)):?>
                                       <a id="file_dictamen_tecnico" href="<?=$st3_dictamen_tecnico_movilidad?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Dictamen Técnico de Movilidad</a>
                                   <?php endif;?>
                               </div>
                           </div>
                           <br>
                           <br>
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="form-group fto-st3">
                                       <label for="exampleInputFile"><b>* Adjuntar Fotografía Panorámica de la fachada completa</b></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st3_img1_establecimiento)){echo 'valid';}?>" id="fleFotoLocal1" onchange="loadFile(this);" name="st3_img1_establecimiento" aria-describedby="fileHelp" data-type="st3_img1_establecimiento" data-elastic="fleFotoLocal1Elastic" data-text="Fotografía fachada">
                                       <div id="fleFotoLocal1Elastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">Debe abarcar las construcciones de la derecha, izquierda y la banqueta.<br><b>No fotos de buscadores de internet</b><br>Formatos permitidos: .png, .jpg, .jpeg, .gif, .pdf<b></b></small>
                                       <?php if(!empty($st3_img1_establecimiento)):?>
                                           <a id="file_img1" href="<?=$st3_img1_establecimiento?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Fotografía fachada</a>
                                       <?php endif;?>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group fto-st3">
                                       <label for="exampleInputFile"><b>* Adjuntar Fotografía Panorámica de la fachada con la puerta o cortina abierta</b></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st3_img2_establecimiento)){echo 'valid';}?>" id="fleFotoLocal2" onchange="loadFile(this);" name="st3_img2_establecimiento" aria-describedby="fileHelp" data-type="st3_img2_establecimiento" data-elastic="fleFotoLocal2Elastic" data-text="Fotografía fachada puerta abierta">
                                       <div id="fleFotoLocal2Elastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">En la fotografía se deberá apreciar el número oficial.<br><b>No fotos de buscadores de internet</b><br>Formatos permitidos: .png, .jpg, .jpeg, .gif, .pdf<b></b></small>
                                       <?php if(!empty($st3_img2_establecimiento)):?>
                                           <a id="file_img2" href="<?=$st3_img2_establecimiento?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Fotografía fachada puerta abierta</a>
                                       <?php endif;?>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group fto-st3">
                                       <label for="exampleInputFile"><b>* Adjuntar Fotografía del Interior del Establecimiento</b></label>
                                       <input type="file" class="form-control-file erase <?php if(!empty($st3_img3_establecimiento)){echo 'valid';}?>" id="fleFotoLocal3" onchange="loadFile(this);" name="st3_img3_establecimiento" aria-describedby="fileHelp" data-type="st3_img3_establecimiento" data-elastic="fleFotoLocal3Elastic" data-text="Fotografía del interior del establecimiento">
                                       <div id="fleFotoLocal3Elastic" class="progress-bar-custom"></div>
                                       <small id="fileHelp" class="form-text text-muted">La fotografía debe ser tomada desde el ingreso al establecimiento porcurando que se aprecie el área a utilizar.<br><b>No fotos de buscadores de internet</b><br>Formatos permitidos: .png, .jpg, .jpeg, .gif, .pdf<b></b></small>
                                       <?php if(!empty($st3_img3_establecimiento)):?>
                                           <a id="file_img3" href="<?=$st3_img3_establecimiento?>" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> Fotografía del interior del establecimiento</a>
                                       <?php endif;?>
                                   </div>
                               </div>
                           </div>
                       </section>

                       <h3>Resumen</h3>
                       <section>
                           <div id="resumen-container"></div>
                           <?php if($this->session->userdata('level') < 2): ?>
                           <div class="card card-body bg-light">
                               <h2>Cadena original a firmar</h2>
                               <div class="cadenaFirmar"></div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <button type="button" class="mui-btn mui-btn--primary" data-toggle="modal" data-target="#firmaModal"><i class="fa fa-lock" aria-hidden="true"></i> Firmar Solicitud</button>
                                   <a href="javascript:continuarVentanilla()" class="mui-btn mui-btn--raised"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No tengo firma electrónica</a>
                               </div>
                           </div>
                           <br>
                           <div class="row">
                               <div class="col-md-12" id="contMSGFirmaError"></div>
                           </div>
                           <br>
                           <div class="card card-body bg-light" id="firmaContainer">
                             <h2>Cadena Firmada</h2>
                             <span id="firma_electronica"><?=$firma?></span>
                           </div>
                           <?php endif; ?>
                           <div class="row">
                               <div class="col-md-12 st4_aviso_privacidad">
                                   <label>
                                       <input  type="checkbox" name="st4_declaratoria" value="1" required="" aria-required="true" <?php if ($st4_declaratoria == 1) echo "checked"; ?>>
                                       <?php if($this->session->userdata('level') > 1): ?>
                                       Bajo protesta de decir verdad manifiesto que todos los datos mencionados y documentos anexos al presente procedimiento administrativo son verdaderos y cotejables con documentación legal.
                                       <?php else: ?>
                                           Bajo protesta de decir verdad manifiesto que corrobore la identidad del solicitante al presente procedimiento administrativo mediante su identificación oficial
                                       <?php endif; ?>
                                   </label>
                               </div>
                           </div>
                           <br>
                           <div class="row">
                               <div class="col-md-12">
                                   <br>
                                   <p style="color: #F35B53; text-align: justify;">
                                       <b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Nota: </b>El municipio de Guadalajara por cualquiera de sus dependencias cuenta con la facultad de realizar cuantas inspecciones considere necesarias para verificar la autenticidad de los datos y documentos que fueron entregados por el solicitante, teniendo la potestad de revocar la licencia en caso de que los instrumentos fundatorios del trámite hayan sido falsificados y/o apócrifos, independientemente de las sanciones administrativas y penales que pudieran incurrir.
                                   </p>
                               </div>
                           </div>
                       </section>
                       <h3>Pago</h3>
                       <section>
                           <h3>Opciones de pago:</h3>
                           <br><br><br>
                           <div class="row">
                               <div class="col-md-12">
                                   <center>
                                       <a href="<?=base_url()?>formatos/orden_pago?lic=<?= $this->utils->encode($licencia->id_licencia);?>&usu=<?= $this->utils->encode($licencia->id_usuario);?>" target="_blank" class="btn btn-lg btn-secondary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Propuesta de Cobro</a>
                                       <?php if($this->session->userdata('level') < 2): ?>
                                       <a id="btnPagoLinea" onclick="pago_linea()" class="btn btn-lg btn-secondary"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Pagar en  linea</a>
                                       <?php endif; ?>

                                   </center>
                               </div>
                           </div>
                       </section>
                    </form>

           <?php else: ?>
               <div class="alert alert-danger" role="alert">
                   <?=$msg?>
               </div>
           <?php endif; ?>
        </div>
    </section>
</div>
<form style="display:none" name='form-pago' id='form-pago' action='url_pago_en_linea' method='POST'>
    <input type='text' id='tipo_tramite_form' name='tipo_tramite' value='13' readonly>
    <input type='text' id='scian_form' name='scian' readonly>
    <input type='text' id='x_form' name='x' value='0' readonly>
    <input type='text' id='y_form' name='y' value='0' readonly>
    <input type='text' id='zona_form' name='zona' readonly>
    <input type='text' id='sub_zona_form' name='sub_zona' readonly>
    <input type='text' id='actividad_form' name='actividad' readonly>
    <input type='text' id='cvecuenta_form' name='cvecuenta' readonly>
    <input type='text' id='propietario_form' name='propietario' readonly>
    <input type='text' id='primer_ap_form' name='primer_ap' readonly>
    <input type='text' id='segundo_ap_form' name='segundo_ap' readonly>
    <input type='text' id='rfc_form' name='rfc' readonly>
    <input type='text' id='curp_form' name='curp' readonly>
    <input type='text' id='telefono_prop_form' name='telefono_prop' readonly>
    <input type='text' id='email_form' name='email' readonly>
    <input type='text' id='cvecalle_form' name='cvecalle' value='0' readonly>
    <input type='text' id='calle_form' name='calle' readonly>
    <input type='text' id='num_ext_form' name='num_ext' readonly>
    <input type='text' id='let_ext_form' name='let_ext' readonly>
    <input type='text' id='num_int_form' name='num_int' readonly>
    <input type='text' id='let_int_form' name='let_int' readonly>
    <input type='text' id='colonia_form' name='colonia' readonly>
    <input type='text' id='cp_form' name='cp' readonly>
    <input type='text' id='espubic_form' name='espubic' value='' readonly>
    <input type='text' id='sup_autorizada_form' name='sup_autorizada' readonly>
    <input type='text' id='num_cajones_form' name='num_cajones' readonly>
    <input type='text' id='num_empleados_form' name='num_empleados' readonly>
    <input type='text' id='aforo_form' name='aforo' value='0' readonly>
    <input type='text' id='inversion_form' name='inversion' readonly>
    <input type='text' id='licencia_form' name='licencia' readonly>
    <input type='text' id='importe_form' name='importe' readonly>
    <input type='text' id='origen_form' name='origen' value='102' readonly>
    <input type='text' id='tipo_form' name='tipo' value='A' readonly>
    <input type='text' id='entre_form' name='entre' value='' readonly>
    <input type='text' id='id_usuario_form' name='id_usuario' readonly>
    <input type='text' id='usuario_form' name='email_usuario' readonly>
    <input type='text' id='contra_form' name='pass' readonly>
    <button type='submit' id="enviar_form">enviar</button>
</form>

<div class="modal fade" id="firmaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-lock" aria-hidden="true"></i> Firmar Solicitud</h3>
            </div>
            <div class="modal-body">
                <form id="frmFirmar">
                    <input type="hidden" id="txtFirmaTramite" value="<?=$licencia->id_licencia?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="uploaded_file1"><b>Archivo .cer</b></label>
                                <input type="file" name="firmaCER" class="form-control-file" id="fleCER" aria-describedby="fileHelp">
                            </div>
                            <div class="form-group">
                                <label for="uploaded_file"><b>Archivo .key</b></label>
                                <input type="file" name="firmaKEY" class="form-control-file" id="fleKEY" aria-describedby="fileHelp">
                            </div>
                            <div class="mui-textfield mui-textfield--float-label modalFirmar">
                                <input id="txtPassFIEL" name="firmaPass" type="password" class="input-material" required>
                                <label for="txtPassFIEL" class="label-material">Contraseña SAT</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnFirmar" type="button" class="mui-btn mui-btn--primary"><i class="fa fa-lock" aria-hidden="true"></i> Firmar Solicitud</button>
                <button class="mui-btn mui-btn--danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="responsivaModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-file" aria-hidden="true"></i> Carta responsiva</h3>
            </div>
            <div class="modal-body">
                <form id="FormCartaModel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombreCompletoSuscrita"><b>Nombre completo de suscrita</b></label>
                                <input type="text" name="nombreCompletoSuscrita" class="form-control" id="nombreCompletoSuscrita" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="documentoIdentificacion"><b>Documento de identificación</b></label>
                                <input type="text" name="documentoIdentificacion" class="form-control" id="documentoIdentificacion" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="numeroIdentificacion"><b>Número de identificación</b></label>
                                <input type="text" name="numeroIdentificacion" class="form-control" id="numeroIdentificacion" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="domicilioPredio"><b>Domicilio del predio</b></label>
                                <input type="text" name="domicilioPredio" class="form-control" id="domicilioPredio" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label for="claveCatastral"><b>Clave catastral</b></label>
                                <input type="text" name="claveCatastral" class="form-control" id="claveCatastralModal" maxlength="20">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="generarCarta" type="button" class="mui-btn mui-btn--primary" onclick="generar_carta()"><i class="fa fa-file" aria-hidden="true"></i> Generar carta</button>
                <button class="mui-btn mui-btn--danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
