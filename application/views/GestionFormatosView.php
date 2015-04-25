<script type="text/javascript">
      Ext.require('MyApp.GestionFormatos.WinGestionFormatos');
      Ext.require('MyApp.GestionFormatos.WinMantGestionFormatos');
//      Ext.require('MyApp.Helpers.Properties.HelperActiveProperties');
      Ext.require('Per.MessageBox');
      Ext.require('Per.Store');
//      Ext.require('Ext.grid.plugin.RowEditing');
      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionFormatos.WinGestionFormatos();
            WinPrincipal.show();          
      });
</script>    