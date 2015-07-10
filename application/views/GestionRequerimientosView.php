<script type="text/javascript">     
    Ext.require('MyApp.Helpers.Proyectos.HelperProyectosUsuario');
      Ext.require('MyApp.GestionRequerimientos.WinGestionRequerimientos');
      Ext.require('MyApp.GestionRequerimientos.WinMantGestionRequerimientos');
      Ext.require('Per.MessageBox');
//      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionRequerimientos.WinGestionRequerimientos();
            WinPrincipal.show();          
      });
</script>  