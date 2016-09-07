/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEditEntrega_TreeGridDefAlcance', {
    extend:'Ext.tree.Panel',
    requires:[
        
    ],
    xtype:'tree-grid',
    title:'Procesos',
    height:300,
    initComponent:function(){
        this.width = 300;
        
        var myToolGrid = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add'
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
            }]
        });
        
        var store = new Ext.data.TreeStore({
            model: WinEditEntregaModel,
            proxy: {
                type: 'ajax',
                //url: 'http://localhost/jarvix/resources/data/tree/treegrid.json'
                url:base_url+'GestionEntregas/Alcance/search'
            }           
        });
        
        Ext.apply(this, {
            tbar:myToolGrid,
            store: store,
            selModel:mySelModel,
            columns: [{
                xtype: 'treecolumn', //this is so we know which column will show the tree
                text: 'Proceso',
                flex: 1,
                //sortable: true,
                dataIndex: 'nombre'
            }]
        });
        this.callParent();
    }
});

