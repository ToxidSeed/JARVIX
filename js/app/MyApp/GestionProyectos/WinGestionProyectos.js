/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProyectos.WinGestionProyectos',{
    extend:'Ext.panel.Panel',
    maximized:true,
    width:0,
    height:0,
    floating:true,
    autorender:true,    
    initComponent:function(){
        var main = this;
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   handler:function(){
                       var WinProyectos = new MyApp.GestionProyectos.WinMantGestionProyectos({
                            title:'Registro de Nuevo Proyecto',
                            mainWindow: main                            
                       });
                       WinProyectos.show();
                       WinProyectos.on({
                            'recordSaved':function(){
                                main.getProyectos();
                            }
                       });
                   }
               }
           ] 
        });
        
        main.txtCodigo = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Codigo'
      });
      
      main.txtNombre = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Nombre'
      })
                  
      main.dtFechaRegistroDesde = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Desde' ,
         format:APPDATEFORMAT
      });
      
      main.dtFechaRegistroHasta = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Hasta' ,
         format:APPDATEFORMAT
      });
      
      main.fieldFechaRegistro = Ext.create('Ext.form.FieldSet',{
         title:'Fecha de Registro' ,
         items:[
             main.dtFechaRegistroDesde,
             main.dtFechaRegistroHasta
         ]
      });
      
      main.dtFechaUltActDesde = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Desde' ,
         format:APPDATEFORMAT
      });
      main.dtFechaUltActHasta = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Hasta' ,
         format:APPDATEFORMAT
      });
      
      main.fieldFechaUltAct = Ext.create('Ext.form.FieldSet',{
          title:'Fecha Ult Act',
          items:[
             main.dtFechaUltActDesde,
             main.dtFechaUltActHasta
          ]
      })
      
      main.panelCritTbar = Ext.create('Ext.toolbar.Toolbar',{
         items:[
             {
                 text:'Buscar',
                 iconCls:'icon-search',
                 handler:function(){
                     
//                     main.GridPropiedades.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 iconCls:'icon-clean',
                 handler:function(){
                     main.limpiarCriterios();
                 }
             },{
                 text:'Ocultar',
                 iconCls:'icon-collapse',
                 handler:function(){
                     main.panelCriterioBusqueda.collapse();
                 }
             }
         ] 
      });
      
      main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{          
          region:'west', 
          title:'Buscar Proyectos',
          bodyPadding:'10px',
          tbar:main.panelCritTbar,
          collapsed:true,
          collapsible:true,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      })
      
      main.GridProyectos = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Proyectos',
         src:base_url+'GestionProyectos/GestionProyectosController/getList',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'id',
                 hidden:true
             },{
                 header:'Nombre',
                 dataIndex:'nombre',
                 flex:1
             },{
                 header:'Fecha de Registro',
                 dataIndex:'fechaRegistro'
             },{
                 header:'Fecha de Actualizacion',
                 dataIndex:'FechaActualizacion'
             }             
         ],
         pagingBar:true
      });
        
        main.GridProyectos.on({
          'afterrender':function(){
              main.getProyectos();
          },
          'itemdblclick':function(grid,record,item){
            var WinProyectos = new MyApp.GestionProyectos.WinMantGestionProyectos({
                            title:'Modificar Proyecto',
                            mainWindow: main,
                            create:false,
                            internal:{
                                Proyecto:{
                                    Id:record.get('id')
                                }                                
                            }
            });
            WinProyectos.show();
          }
      })
        
        Ext.apply(this,{
            layout:'border',
            defaultFocus:main.txtNombre,
            items:[
              main.panelCriterioBusqueda,
              main.GridProyectos
            ]
            
        });
        
        this.callParent(arguments);
    },
    
    getProyectos:function(){
        var main = this;
        var object = {
            id:main.txtCodigo.getValue(),
            nombre: main.txtNombre.getValue(),
            fechaRegistroDesde: main.dtFechaRegistroDesde.getValue(),
            fechaRegistroHasta: main.dtFechaRegistroHasta.getValue(),
            fechaUltActDesde: main.dtFechaUltActDesde.getValue(),
            fechaUltActHasta:main.dtFechaUltActHasta.getValue()
        };
        main.GridProyectos.load(object);
    },    
    limpiarCriterios:function(){
        var main = this;
        main.txtCodigo.setValue(null);
        main.txtNombre.setValue(null);
        main.dtFechaRegistroDesde.setValue(null);
        main.dtFechaRegistroHasta.setValue(null);
        main.dtFechaUltActDesde.setValue(null);
        main.dtFechaUltActHasta.setValue(null);
    }
})