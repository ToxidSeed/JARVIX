Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance', {
    extend: 'Ext.tree.Panel',
    requires: [
        'Ext.data.*',
        'Ext.grid.*',
        'Ext.tree.*',
        'Ext.ux.CheckColumn'
        //'KitchenSink.model.tree.Task'
    ],
    xtype: 'tree-grid',
    title: 'Core Team Projects',
    height: 300,
    useArrows: true,
   rootVisible: false,
   resizable:true,
    //multiSelect: true,
    //singleExpand: true,
    /*setRootNode: function() {
        if (this.getStore().autoLoad) {
            this.callParent(arguments);
        }
    },*/
    initComponent: function() {
        this.width = 500;

        var myToolGrid = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar'
               },{
                   text:'Quitar'
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
            }]
        });

        var store = new Ext.data.TreeStore({
            model: WinEditEntregaModel,
            proxy: {
                type: 'ajax',
                //url: 'http://localhost/jarvix/resources/data/tree/treegrid.json'
                url:base_url+'GestionEntregas/Alcance/search'
            }//,
            //folderSort: true
        });

        Ext.apply(this, {
            tbar:myToolGrid,
            store: store,
            selModel:mySelModel,
            columns: [{
                xtype: 'treecolumn', //this is so we know which column will show the tree
                text: 'task',
                flex: 1,
                //sortable: true,
                dataIndex: 'nombre'
            }]
        });
        this.callParent();
    }
});
