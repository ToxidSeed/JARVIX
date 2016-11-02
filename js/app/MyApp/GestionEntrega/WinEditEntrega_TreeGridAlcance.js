Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance', {
    extend: 'Ext.tree.Panel',
  /*requires: [
        'Ext.data.*',
        'Ext.grid.*',
        'Ext.tree.*',
        'Ext.ux.CheckColumn'
        //'KitchenSink.model.tree.Task'
    ],*/
   xtype: 'tree-grid',
    title: 'Alcance',
    region:'center',
    height: 150,
    split:true,
    //split:true,
    //border:true,    
    useArrows: true,
    //draggable:true,
    //resizable:true,
    rootVisible: false,
    //allowContainerDrops:true,
    //multiSelect: true,
    //singleExpand: true,
    /*setRootNode: function() {
        if (this.getStore().autoLoad) {
            this.callParent(arguments);
        }
    },*/
    initComponent: function() {
        this.width = 500;
        var main = this;

        main.ltbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   id:'btnBuscar',
                   handler:function(){
                     main.fireEvent('btnAgregar_Click');
                   }
               },{
                   text:'Quitar',
                   iconCls:'icon-delete'
               }
           ]
        });

        var mySelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });

        Ext.define('WinEditEntregaModel', {
            extend: 'Ext.data.TreeModel',
            fields: [{
                name: 'nombre',
                type: 'string'
            },{
                name:'user',
                type:'string'
            }]
        });

        main.store = new Ext.data.TreeStore({
            model: WinEditEntregaModel,
            autoLoad:false,
            proxy: {
                type: 'ajax',                
                url:'../GestionEntregas/Alcance/searchxxx'
            }
        });



        Ext.apply(this, {
            tbar:main.ltbar,
            store: main.store,
            selModel:mySelModel,
            columns: [{
                xtype: 'treecolumn', //this is so we know which column will show the tree
                text: 'Proceso',
                flex: 1,
                //sortable: true,
                dataIndex: 'nombre'
            }/*,{
              text: 'Assigned To',
               //flex: 1,
               dataIndex: 'user',
               sortable: true
            }*/]            
        });
        
        
        this.callParent();        
    }
});
