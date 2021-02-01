<?php

    ?>
  </div>
                </div>
            </div>
        </div>

        <footer class="Footer bg-dark dker">
            <p><?php echo date("Y"); ?> &copy; <?php echo Config::getNotaAlPie(); ?></p>
        </footer>

        <!-- #helpModal -->
        <div id="divModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo Config::getTituloModal(); ?></h4>
                    </div>
                    <div id="contenidoDivModal" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div id="divModalIframe" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo Config::getTituloModal(); ?></h4>
                    </div>
                    <div id="contenidoDivModal" class="modal-body">
                        <iframe id="iframeModal" src="#"   style="border:none;display: block;min-height: 100%;min-width: 100%;"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div id="divModalAlerta" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo Config::getTituloModal(); ?>></h4>
                    </div>
                    <div id="contenidoAlerta" class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            //Importo el javascript agregado.
            echo Campos::$cssAImportar;
        ?>
        
        <script src="/core/assets/lib/jquery/jquery.js"></script>
        <script src="/core/assets/js/prism.min.js"></script>
        <script src="/core/assets/lib/bootstrap/js/bootstrap.js"></script>
        <script src="/core/assets/lib/metismenu/metisMenu.js"></script>
        <script src="/core/assets/lib/onoffcanvas/onoffcanvas.js"></script>
        <script src="/core/assets/lib/screenfull/screenfull.js"></script>
        <script src="/core/assets/js/template.js"></script>
        <script src="/core/assets/lib/inputlimiter/jquery.inputlimiter.js"></script>
        <script src="/core/assets/lib/validVal/js/jquery.validVal.min.js"></script>
        <script src="/core/assets/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="/core/assets/js/moment.min.js"></script>
        <script src="/core/assets/js/jquery.uniform.min.js"></script>
        <script src="/core/assets/js/chosen.jquery.min.js"></script>
        <script src="/core/assets/js/jquery.tagsinput.min.js"></script>
        <script src="/core/assets/js/jquery.autosize.min.js"></script>
        <script src="/core/assets/js/jasny-bootstrap.min.js"></script>
        <script src="/core/assets/js/bootstrap-switch.min.js"></script>
        <script src="/core/assets/js/bootstrap-datepicker.min.js"></script>
        <script src="/core/assets/js/bootstrap-colorpicker.min.js"></script>
        <script src="/core/assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="/core/assets/js/bootstrap-datepicker.es.js"></script>
        <script src="/core/assets/js/bootstrap3-wysihtml5.all.min.js"></script>
        
        <script src="/core/assets/js/dataTables.js"></script>
        <script src="/core/assets/js/dataTablesExtensions.js"></script>
        <script src="/core/assets/js/extensions.js"></script>

        <script src="/core/assets/js/bootstrap-select.min.js"></script>
        <!-- 
            Antes de este comentario deben ir colocados todos los scripts a librerias 
        
            Luego pueden colocarse los scripts normales de la pagina
        -->
        <script src="/core/assets/js/core.js"></script>
        
        <?php
            //Importo el javascript agregado.
            echo Campos::$javascriptAImportar;
        ?>
        <script>
        <?php
            echo Campos::$javascript;
        ?>
        </script>
    <?php
            //Importo el javascript customizado de cada pagina.
            echo Campos::$javascriptFinal;
        ?>
    </body>
</html>
    <?php
$conexion->finalizar();
?>