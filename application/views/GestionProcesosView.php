<script type="text/javascript">
//      Ext.require('MyApp.GestionProyectos.HelpAplicaciones');
      Ext.require('MyApp.GestionProcesos.WinGestionProcesos');
      //Ext.require('MyApp.GestionProcesos.WinMantGestionProcesos');
      Ext.require('Per.MessageBox');
//      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionProcesos.WinGestionProcesos();
            WinPrincipal.show();          
      });
</script>  

