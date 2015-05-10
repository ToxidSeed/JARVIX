/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionRequerimientos.WinGestionRequerimientos',{
   extend:'Ext.panel.Panel',
   maximized:true,
   width:0,
   height:0,
   floating:true,
   autorender:true,
   initComponent:function(){
       var main = this;
       
       main.toolbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Nuevo',
                  handler:function(){
                      var WinNewRequerimiento = new MyApp.GestionRequerimientos.WinMantGestionRequerimientos({
                          title:'Nuevo Requerimiento Funcional'
                      });
                      WinNewRequerimiento.show();
                      WinNewRequerimiento.on({
                        'saved':function(){                            
                            main.fnGetRequerimientos();
                        }
                    });
                  }
              }
          ] 
       });
       
       main.txtCodigo = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Codigo'
       })
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre' 
       });
       
       main.dtFechaRegistroDesde = Ext.create('Ext.form.field.Date',{
          fieldLabel:'Desde',
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
                 handler:function(){
                     
//                     main.GridPropiedades.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 handler:function(){
                     main.limpiarCriterios();
                 }
             },{
                 text:'Ocultar',
                 handler:function(){
                     main.panelCriterioBusqueda.collapse();
                 }
             }
         ] 
      });
      
      main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{          
          region:'west', 
          title:'Buscar Requerimientos',
          bodyPadding:'10px',
          collapsible:true,
          collapsed:true,
          tbar:main.panelCritTbar,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      });
      
      main.GridRequerimientos = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Requerimientoss',
         src:base_url+'GestionRequerimientos/GestionRequerimientosController/search',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'codigo'
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
      
      
      main.GridRequerimientos.on({
          'afterrender':function(){
              main.fnGetRequerimientos();
          },
          'itemdblclick':function(grid,record,item){
            var WinRequerimientos = new MyApp.GestionRequerimientos.WinMantGestionRequerimientos({
                            title:'Modificar Requerimientos',
                            mainWindow: main,
                            create:false,
                            internal:{
                                id:record.get('id')
                            }
            });
            //Ext.util.Observable.capture(WinRequerimientos, function(evname) {console.log(evname, arguments);})
            WinRequerimientos.show();
            WinRequerimientos.on({
                        'saved':function(){                            
                            main.fnGetRequerimientos();
                        }
                    });
            
          }
      });
      
      Ext.apply(this,{
          tbar: main.toolbar,
         layout:'border' ,
         items:[
             main.panelCriterioBusqueda,
             main.GridRequerimientos
         ]
      });
       this.callParent(arguments);
   },
   getParams:function(){
       var main = this;
       var object = {
           nombre: main.txtNombre.getValue()
       }
       return object;
   },
   limpiarCriterios:function(){
       var main = this;
   },
   fnGetRequerimientos:function(){
       var main = this;
       main.GridRequerimientos.load(main.getParams());
   }
});

