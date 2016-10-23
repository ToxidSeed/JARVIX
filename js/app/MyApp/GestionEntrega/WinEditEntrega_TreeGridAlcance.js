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

        var myToolGrid = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
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
                //url: 'http://localhost/jarvix/resources/data/tree/treegrid.json'
                url:base_url+'GestionEntregas/Alcance/search'
            }
        });



        Ext.apply(this, {
            tbar:myToolGrid,
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
            }*/],
            viewConfig:{
                plugins:{
                //ptype:'gridviewdragdrop',                
                 ptype:'treeviewdragdrop',
                  ddGroup:'group'
                  //allowContainerDrops: true
                },
                listeners:{
                    'beforedrop':function(){
                        console.log('here');
                    }
                }
            },
            listeners:{
                'beforeitemappend':function(node,childnode){
                    console.log(node);
                    console.log(childnode);
                }
            },
            bbar:[
                { xtype: 'button', text: 'Button 1' }
              ]
        });
        
        
        this.callParent();        
    }
});
