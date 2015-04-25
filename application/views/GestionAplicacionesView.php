<script type="text/javascript">    
      Ext.require('MyApp.GestionAplicaciones.WinGestionAplicaciones');      
      Ext.require('MyApp.GestionAplicaciones.WinMantGestionAplicaciones');

      Ext.require('Per.MessageBox');

      
      Ext.onReady(function () {          
            var WinAplicaciones = new MyApp.GestionAplicaciones.WinGestionAplicaciones();
            
            WinAplicaciones.show();          
      });
</script>    