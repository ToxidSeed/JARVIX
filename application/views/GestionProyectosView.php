<script type="text/javascript">    
      Ext.require('Per.Store');            
      Ext.require('MyApp.GestionProyectos.HelpAplicaciones');
      Ext.require('MyApp.GestionProyectos.WinAddParticipantes');
      Ext.require('MyApp.GestionProyectos.WinGestionProyectos');
      Ext.require('MyApp.GestionProyectos.WinMantGestionProyectos');
      Ext.require('Per.MessageBox');
//      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionProyectos.WinGestionProyectos();
            WinPrincipal.show();          
      });
</script>  

