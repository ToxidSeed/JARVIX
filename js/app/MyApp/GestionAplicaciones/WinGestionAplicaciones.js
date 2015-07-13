Ext.define('MyApp.GestionAplicaciones.WinGestionAplicaciones',{
    extend:'Ext.panel.Panel',
    maximized:true,    
     width:0,
    height:0,
    floating:true,
    autoRender:true,
    initComponent:function(){
        var main = this;
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Agregar',
                    iconCls:'icon-add',
                    handler:function(){
                        var myWinPrincipal = new MyApp.GestionAplicaciones.WinMantGestionAplicaciones({
                            title:'Registro de Nueva Aplicacion',
                            mainWindow: main                            
                        })
                        myWinPrincipal.show();
                    }
                }
            ]
        })
        
        main.txtCodigo = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Codigo'
      })
      
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
                     main.GridAplicaciones.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 iconCls:'icon-clean',
                 handler:function(){
//                     main.limpiarCriterios();
                 }
             },{
                 text:'Ocultar',
                 iconCls:'icon-collapse',
                 handler:function(){
                     
                 }
             }
         ] 
      });
      
       main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{                     
          region:'west',
          bodyPadding:'10px',
          title:'Criterios de Busqueda',
          collapsible:true,
          collapsed:true,
          tbar:main.panelCritTbar,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      })
      
      main.GridAplicaciones = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Aplicaciones',
         src:base_url+'GestionAplicaciones/GestionAplicacionesController/getAplicaciones',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'id'
             },{
                 header:'Estado',
                 dataIndex:'estado.nombre'
             },{
                 header:'Nombre',
                 dataIndex:'nombre'
             },{
                 header:'Ruta Publicacion',
                 dataIndex:'rutaPublicacion'
             },{
                 header:'Servidor',
                 dataIndex:'servidor'
             },{
                 header:'Base de Datos',
                 dataIndex:'baseDatos'
             },{
                 header:'Usuario',
                 dataIndex:'username'
             },{
                 header:'Fecha de Registro',
                 dataIndex:'fechaRegistro'
             },{
                 header:'Fecha de Modificacion',
                 dataIndex:'fechaModificacion'
             }             
         ],
         pagingBar:true
      });
      
      main.GridAplicaciones.on({
          'afterrender':function(){
              main.GridAplicaciones.load(main.getParams());
          },
          'itemdblclick':function(grid,record,item){
              var myMantGestionApp = new MyApp.GestionAplicaciones.WinMantGestionAplicaciones({
                  title:'Modificacion de Aplicaciones',
                  create:false,            
                  recordId:record.get('id')
              });
              myMantGestionApp.show();
              myMantGestionApp.on({
                  'close':function(){
                      main.GridAplicaciones.load(main.getParams());
                  }
              })
          }
      })
      
       Ext.apply(this,{
            layout:'border',
            items:[
              main.panelCriterioBusqueda,
              main.GridAplicaciones
            ]
            
        });
        
        this.callParent(arguments);
    },  
    getParams:function(){
        var main = this;
        var object = {
            id:main.txtCodigo.getValue(),
            nombre: main.txtNombre.getValue(),
            fechaRegistroDesde: main.dtFechaRegistroDesde.getValue(),
            fechaRegistroHasta: main.dtFechaRegistroHasta.getValue(),
            fechaUltActDesde: main.dtFechaUltActDesde.getValue(),
            fechaUltActHasta:main.dtFechaUltActHasta.getValue()
        };
        return object;
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