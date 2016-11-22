/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridProcesosDisp', {
    extend:'Ext.tree.Panel',
    internal:{
        id:null,
        proyecto:{
            id:null
        }
    },
    requires: [
        'Ext.data.*',
        'Ext.grid.*',
        'Ext.tree.*',
        'Ext.ux.CheckColumn'
        //'KitchenSink.model.tree.Task'
    ],
    region:'west',
    hidden:true,
    xtype:'tree-grid',
    title:'Procesos',
    height:150,
    width:300,
    border:true,
    bodyBorder:true,
    split:true,
    rootVisible: false,
    useArrows: true,
   // singleExpand: true,
    draggable:true,
    initComponent:function(){
        this.width = 300;
        var main = this;


        main.Toolbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   id:'btnAgregar',
                   handler:function(){
                        var records = main.selectRecords();
                        main.agregarAlcance(records);
                   }
               },{
                   text:'Ocultar',
                   iconCls:'icon-collapse',
                   id:'btnOcultar',
                   handler:function(){
                       main.fireEvent('btnOcultar_Click');
                   }
               }
           ]
        });

        /* var mySelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });*/

        Ext.define('WinProcesosModel', {
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

        //console.log(main.internal);

        main.store = new Ext.data.TreeStore({
            autoLoad:false,
            model: WinProcesosModel,
            //autoLoad:false,
            proxy: {
                type: 'ajax',
                //url: 'http://localhost/jarvix/resources/data/tree/treegrid.json'
                url:'../GestionEntregas/Alcance/search'
            },
            listeners:{
                'beforeload':function(store){
                    if(main.internal.proyecto.id === null){
                        return false;
                    }else{
                        //console.log(main.internal);
                        store.getProxy().extraParams = {
                           ProyectoId:main.internal.proyecto.id,
                           EntregaId: main.internal.id
                        };
                    }
                }
            }
        });


        Ext.apply(this, {
            tbar:main.Toolbar,
            //store: main.store,
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
                    //Reload Node when show
                    //console.log('xx');
                    main.setRootNode(main.store.getRootNode());
                }
            }
        });


        this.callParent();
    },
    selectRecords:function(){
        var main = this;
        var records = main.getView().getChecked();
        var varAlcanceDetalle = [];
        Ext.Array.each(records, function(rec){
            //var varIdAlcance =
            var varTipo         = rec.get('tipo');
            if(varTipo !== 'CNT'){
                var varDetalle = {
                    tipo:varTipo,
                    AlcanceId:rec.get('AlcanceId')
                };
                varAlcanceDetalle.push(varDetalle);
            }
        });
        return Ext.encode(varAlcanceDetalle);
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
    },
    agregarAlcance:function(parAlcance){
        var main = this;

        Ext.Ajax.request({
          url:base_url+'GestionEntregas/Alcance/Add',
          params:{
              EntregaId:main.internal.id,
              ProyectoId:main.internal.proyecto.id,
              Alcance:parAlcance
          },
          success:function(response){
              //main.store.load();
              main.fireEvent('AfterAgregarAlcanceSuccess');
          }
       });
    },
    setInternal:function(parInternal){
        var main = this;
       //console.log(parInternal);
        main.internal = parInternal;

    }
});
