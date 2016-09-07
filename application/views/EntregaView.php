<script type="text/javascript">
      Ext.require('Per.GridPanel');
      Ext.require('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance');
      Ext.require('MyApp.GestionEntrega.WinEditEntrega_TreeGridProcesosDisp');            
      Ext.require('MyApp.GestionEntrega.WinEditEntrega');
      Ext.require('MyApp.GestionEntrega.WinEntrega');

      Ext.onReady(function () {
            var WinPrincipal = new MyApp.GestionEntrega.WinEntrega();
            WinPrincipal.show();
      });
</script>
