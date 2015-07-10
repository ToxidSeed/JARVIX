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
   config:{},
   initComponent:function(){
       var main = this;
               
        var frameId = Ext.id(window.frameElement);
        var currentFrame = window.parent.Ext.getCmp(frameId);
        
        main.config = currentFrame.initialConfig.autoEl.object.data;
        //console.log(main.config)
       
         main.txtSetProject = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Proyecto',
            width:350
         });
         
         
         
         
         
         main.btnSetProject = {                              
                                iconCls:'icon-arrow_refresh',
                                handler:function(){
                                    var winProyectos = new MyApp.Helpers.Proyectos.HelperProyectosUsuario();
                                    winProyectos.show();
                                }
                           };
                           
         //     main.tbar.add(main.txtSetProject);
         //main.tbar.add(main.btnSetProject);
       
       main.toolbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add',
                  handler:function(){
                      var WinNewRequerimiento = new MyApp.GestionRequerimientos.WinMantGestionRequerimientos({
                          title:'Nuevo Requerimiento Funcional',
                          internal:{
                              orden:main.fnGetNextOrden(),
                              ProyectoId: main.config.proyectoId
                          }                                    
                      });
                      WinNewRequerimiento.show();
                      WinNewRequerimiento.on({
                        'saved':function(){                            
                            main.fnGetRequerimientos();
                        }
                    });
                  },                  
              },{
                  text:'Insertar',
                   iconCls:'icon-table_row_insert',
                  handler:function(){
                      
                  }
              },
              '-'
              ,main.txtSetProject
              ,main.btnSetProject
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
          hidden:true,   
         sortableColumns:false,
         pageSize:20,
//         title:'Lista de Requerimientoss',
         src:base_url+'GestionRequerimientos/GestionRequerimientosController/search',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'id'
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
        if (main.config.proyectoId != undefined) {
           main.txtSetProject.setValue(main.config.nombreProyecto);
           main.fnGetRequerimientos();
        }
              
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
      
      main.dispRequerimientos = Ext.create('Ext.form.field.Display',{
            width:'100%',
            padding:10,
            height:'100%',
            hidden:true,            
            value:'Seleccione un Proyecto para Gestionar los requerimientos'
        });
       
       if (main.config.proyectoId != undefined) {
         main.GridRequerimientos.show();
         main.dispRequerimientos.hide();
       }else{
         main.GridRequerimientos.hide();
         main.dispRequerimientos.show();
       }
       
      
      Ext.apply(this,{
          tbar: main.toolbar,
         layout:'border' ,
         items:[
             main.panelCriterioBusqueda,
             main.GridRequerimientos,
             main.dispRequerimientos
         ]
      });
      this.callParent(arguments);
      
   },
   getParams:function(){
       var main = this;             
       
       var object = {
           nombre: main.txtNombre.getValue(),
           ProyectoId: main.config.proyectoId
       };
       return object;
   },
   limpiarCriterios:function(){
       var main = this;
   },
   fnGetRequerimientos:function(){
       var main = this;
       main.GridRequerimientos.load(main.getParams());
   },
   fnGetNextOrden:function(){
       var main = this;
       var nextOrden = 0;
       //Check whether the store have rows
       var myCtdRecords = main.GridRequerimientos.getStore().getCount();
       nextOrden++
       return nextOrden;
   }
});

