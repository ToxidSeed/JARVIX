<style>
.x-grid-row .x-grid-cell-inner {
    white-space: pre-line;
}
.x-grid-row-over .x-grid-cell-inner {
    font-weight: bold;
    white-space: pre-line;
}
</style>
<script type="text/javascript">
      Ext.require('Per.Store');
      Ext.require('Per.MessageBox');
      Ext.require('Per.DebugHelperWindow');
//      Ext.require('MyApp.GestionProyectos.HelpAplicaciones');
      Ext.require('MyApp.GestionProcesos.WinMantGestionProcesos');
      Ext.require('MyApp.GestionProcesos.WinAgregarFlujo');
      Ext.require('MyApp.GestionProcesos.WinGuardarDescripcion');  
      Ext.require('MyApp.GestionProcesos.WinMantProcesosControl');
      Ext.require('MyApp.GestionProcesos.WinHelpControls');      
      Ext.require('MyApp.GestionProcesos.WinAddRequerimiento');      
      
//      Ext.require('MyApp.GestionProcesos.WinMantGestionProcesos');
      

      Ext.onReady(function () {         
          //El parametro $id, se pasa como parametro cuando se carga la vista
            var ProcesoId = <?php echo $id;?>;
            var ProyectoId = <?php echo $proyecto_id;?>;
            var NombreProyecto = <?php echo "'".$nombre_proyecto."'";?>;
            var AplicacionId = <?php echo $aplicacion_id;?>;
            
            var WinPrincipal = new MyApp.GestionProcesos.WinMantGestionProcesos({
                internal:{
                    id: ProcesoId,
                    ProyectoId:ProyectoId,
                    NombreProyecto: NombreProyecto,
                    AplicacionId: AplicacionId
                }
            });
        
            WinPrincipal.show();          
      });
</script>  