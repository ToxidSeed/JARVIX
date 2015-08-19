<script type="text/javascript">    
    Ext.require('Per.GridPanel');
      Ext.require('MyApp.GestionControles.WinMantPropiedades');
      Ext.require('MyApp.GestionControles.WinGestionControles');
      Ext.require('MyApp.GestionControles.WinMantGestionControles');
      Ext.require('MyApp.Helpers.Properties.HelperActiveProperties');
      Ext.require('Per.MessageBox');
      Ext.require('Per.Store');
      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionControles.WinGestionControles();
            WinPrincipal.show();          
      });
</script>    