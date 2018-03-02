<div id="jumbotron">
    <div class="container">
        <center>
            <div id="alertas">

            </div>
            <form id="form_correo">
                <div class="row">
                    <div class="col-md-2" style="text-align:left;">
                        <label for="">Nombre completo:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="nombre"  id="nombre">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-2" style="text-align:left;">
                        <label for="">Email:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-2" style="text-align:left;">
                        <label for="">Teléfono o celular:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="telefono"  id="telefono">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12" style="text-align:left;">
                        <label for="">Comentario:</label>
                    </div>
                    <div class="col-md-12">
                        <textarea  id="comentario" name="comentario" class="form-control" rows="8" cols="80"></textarea>
                    </div>
                </div><br>
                <div class="row" style="margin-bottom:11.5%;">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success" id="enviar" name="button" onclick="enviar_correo()">Enviar</button>
                    </div>
                </div>
            </form>
        </center>
    </div>
</div>
