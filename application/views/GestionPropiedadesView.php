<script type="text/javascript">
      Ext.require('Per.MainWindow');
      Ext.require('MyApp.GestionPropiedades.WinGestionPropiedades');
      Ext.require('MyApp.GestionPropiedades.WinMantGestionPropiedades');      
      Ext.require('Per.MessageBox');
//      
      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionPropiedades.WinGestionPropiedades();
            WinPrincipal.show();          
      });
</script>  