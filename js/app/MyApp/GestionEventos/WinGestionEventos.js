
Ext.define('MyApp.GestionEventos.WinGestionEventos',{
  extend:'Ext.panel.Panel' ,
  
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
                     new MyApp.GestionEventos.WinMantGestionEventos({
                         Id:0
                     }).show();
                 }
            }
         ] 
      });
      
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
                     
                     main.GridEventos.load(main.getParams()) 
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
          title:'Buscar Eventos',
          collapsible:true,
          bodyPadding:'10px',
          tbar:main.panelCritTbar,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      });
      
      main.GridEventos = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Eventos',
         src:base_url+'GestionEventos/GestionEventosController/getEventos',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'id'
             },{
                 header:'Nombre',
                 dataIndex:'nombre'
             },{
                 header:'Fecha de Registro',
                 dataIndex:'fechaRegistro'
             }             
         ],
         pagingBar:true
      });
      
      main.GridEventos.on({
          'afterrender':function(){
              main.GridEventos.load(main.getParams());
          },
          'itemdblclick':function(grid,record,item){
              new MyApp.GestionEventos.WinMantGestionEventos({
                  create:false,
                  id:record.get('id')
              }).show();
          }
      })
      
      Ext.apply(this,{            
            layout:'border',
            items:[
              main.panelCriterioBusqueda,
              main.GridEventos
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

