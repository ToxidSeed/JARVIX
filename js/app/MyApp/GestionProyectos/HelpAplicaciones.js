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
            fieldLabel:'Nombre'
        })
        
        help.toolBar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   handler:function(){
                       help.gridAplicaciones.load(help.getParams());
                   }
               },
               {
                   text:'Cancelar',
                   handler:function(){
                       help.close();
                   }
               }
           ]
        });
        
        help.panelCriterio = Ext.create('Ext.panel.Panel',{
           tbar:help.toolBar,
           region:'west',
           bodyPadding:'10px',
           items:[
               help.txtNombreAplicacion
           ] 
        });
        
        help.gridAplicaciones = Ext.create('Per.GridPanel',{
           loadOnCreate:false,
           region:'center',
           width:200,
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
               }
        })
        
        
        Ext.apply(this,{
            title:'Buscar Aplicaciones',
            layout:'border',
            width:713,
            height:300,
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


