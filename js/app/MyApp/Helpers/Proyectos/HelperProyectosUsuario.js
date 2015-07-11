/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('MyApp.Helpers.Proyectos.HelperProyectosUsuario',{
    extend:'Ext.window.Window',
    response:{
        
    },
    initComponent:function(){
        var main = this;
        
        main.txtNombreProyecto = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Proyecto',
           width:350
        });
        
        main.toolBar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){
                       main.buscar();
                   }
               },
               '-',
               {
                   text:'Salir',
                   iconCls:'icon-door-out',
                   handler:function(){
                       main.close();
                   }
               }
           ]
        });
        
        main.panelCriterio = Ext.create('Ext.panel.Panel',{
          title:'Criterios',
           tbar:main.toolBar,
           region:'north',
           split:true,
           collapsible:true,
           border:false,
           bodyPadding:'10px',
           items:[
               main.txtNombreProyecto
           ] 
        });
        
        main.grid = Ext.create('Per.GridPanel',{
           loadOnCreate:false,
           region:'center',
           width:200,
           border:false,
           pageSize:20,
           title:'Proyectos',
           src:base_url+'Helper/HelperProyectosUsuario/search',
           columns:[
               {
                   xtype:'rownumberer'
               },{
                   header:'Codigo',
                   dataIndex:'id'
               },{
                   header:'Nombre',
                   flex:'1',
                   dataIndex:'nombre'
               }
           ],
           pagingBar:true
        });
        
        main.grid.on({
            'afterrender':function(){
                main.buscar(); 
            },
            'itemdblclick':function(){
                main.seleccionar();
            }
        });
        
        Ext.apply(this,{
            title:'Buscar Proyectos',
            layout:'border',
            width:400,
            height:500,
            modal:true,
            items:[
                main.panelCriterio,
                main.grid
            ],
            listeners:{
                'resize':function(win,width,height){
                    
                }
            }
        });
        this.callParent(arguments);
    },
    buscar:function(){
        var main = this;
        main.grid.load({
           NombreProyecto:main.txtNombreProyecto.getValue() 
        });
    },
    seleccionar:function(){
        var main = this;
        var selModel = main.grid.getSelectionModel();
        var record = selModel.getSelection();
        main.response.Proyecto = record[0].data;   
//        console.log(main.response.Proyecto);
        main.fireEvent('seleccion');
        main.close();
    }
});
