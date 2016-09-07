/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridProcesosDisp', {
    extend:'Ext.tree.Panel',
    region:'west',
    hidden:true,
    xtype:'tree-grid',
    title:'Procesos',
    height:300,
    width:300,
    rootVisible: false,
    useArrows: true,
    initComponent:function(){
        this.width = 300;
        var main = this;

        main.myToolGrid = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               /*{
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){

                   }
               },*/{
                   text:'Ocultar',
                   iconCls:'icon-collapse'
               }
           ]
        });

         var mySelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });

        Ext.define('WinProcesosModel', {
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
            model: WinProcesosModel,
            autoLoad:false,
            proxy: {
                type: 'ajax',
                //url: 'http://localhost/jarvix/resources/data/tree/treegrid.json'
                url:base_url+'GestionEntregas/Alcance/search'
            }
        });


        Ext.apply(this, {
            tbar:main.myToolGrid,
            store: main.store,
            selModel:mySelModel,
            columns: [{
                xtype: 'treecolumn', //this is so we know which column will show the tree
                text: 'Proceso',
                flex: 1,
                //sortable: true,
                dataIndex: 'nombre'
            }],
            viewConfig:{
              //draggable:true,
              plugins:{
                //ptype:'gridviewdragdrop',
                ptype:'treeviewdragdrop',
                ddGroup:'AlcanceDragDrop'
                //enableDrop: false
              }
            }
        });
        this.callParent();
    }
});
