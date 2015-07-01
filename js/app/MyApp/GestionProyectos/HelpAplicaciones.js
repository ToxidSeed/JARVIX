/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProyectos.HelpAplicaciones',{
    extend:'Ext.window.Window', 
    response:{},
    initComponent:function(){
        var help = this;
        
        help.txtNombreAplicacion = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre',
            width:350,
        });
        
        help.toolBar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){
                       help.gridAplicaciones.load(help.getParams());
                   }
               },
               '-',
               {
                   text:'Cancelar',
                   iconCls:'icon-door-out',
                   handler:function(){
                       help.close();
                   }
               }
           ]
        });
        
        help.panelCriterio = Ext.create('Ext.panel.Panel',{
          title:'Criterios',
           tbar:help.toolBar,
           region:'north',
           split:true,
           collapsible:true,
           border:false,
           bodyPadding:'10px',
           items:[
               help.txtNombreAplicacion
           ] 
        });
        
        help.gridAplicaciones = Ext.create('Per.GridPanel',{
           loadOnCreate:false,
           region:'center',
           width:200,
           border:false,
           pageSize:20,
           title:'Lista de Aplicaciones',
           src:base_url+'Helper/HelpAplicaciones/search',
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
        
        help.gridAplicaciones.on({
            'itemdblclick':function(grid,record){                   
                   help.response.id = record.get("id");
                   help.response.nombre = record.get("nombre");
                   help.close();
               },
            'afterrender':function(){
                help.gridAplicaciones.load(help.getParams());
            }
        });
        
        
        Ext.apply(this,{
            title:'Buscar Aplicaciones',
            layout:'border',
            width:450,
            height:600,
            modal:true,
            items:[
                help.panelCriterio,
                help.gridAplicaciones
            ],
            listeners:{
                'resize':function(win,width,height){
                    
                }
            }
        })
        
        this.callParent(arguments);
    },
    getParams:function(){
        var main = this;
        var object = {
            nombre:main.txtNombreAplicacion.getValue()
        }
        return object;
    }
})


