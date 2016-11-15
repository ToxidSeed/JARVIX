Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance', {
    extend: 'Ext.tree.Panel',
     internal:{
        id:null
     },
     requires: [
         'Ext.data.*',
         'Ext.grid.*',
         'Ext.tree.*',
         'Ext.ux.CheckColumn'
         //'KitchenSink.model.tree.Task'
     ],
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
            },{
                name:'tipo',
                type:'string'
            },{
                name:'AlcanceId',
                type:'number'
            }]
        });

        main.store = new Ext.data.TreeStore({
            model: WinEditEntregaModel,
            autoLoad:false,
            proxy: {
                type: 'ajax',
                url:'../GestionEntregas/Alcance/SearchAsignados'
            },
            listeners:{
              'beforeload':function(store){
                if(main.internal.id === null){
                  return false;
                }else{
                  store.getProxy().extraParams = {
                    EntregaId:main.internal.id
                  };
                }
            },
            'load':function(store){
                main.setRootNode(main.store.getRootNode());
            }
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
                dataIndex: 'nombre'
            }],
            listeners:{
                'checkchange':function(node, checked, eOpts){
                     main.checkChildrens(node, checked, eOpts);
                },
                'afterrender':function(){
                  main.setRootNode(main.store.getRootNode());
                }
            }
        });


        this.callParent();
    },
    setInternal:function(parInternal){
      var main = this;
      main.internal = parInternal;
    },
    checkChildrens:function(node, checked, eOpts){
        node.eachChild(function(n) {
            node.cascadeBy(function(n){
                n.set('checked', checked);
            });
        });

        //check parent node if child node is check
        p = node.parentNode;
        var pChildCheckedCount = 0;
        p.suspendEvents();
        p.eachChild(function(c) {
            if (c.get('checked')) pChildCheckedCount++;
                if(p.parentNode !== null){
                    p.parentNode.set('checked', !!pChildCheckedCount);
                    p.set('checked', !!pChildCheckedCount);
                }
            });
        p.resumeEvents();
    }
});
