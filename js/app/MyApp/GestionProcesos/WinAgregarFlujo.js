/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProcesos.WinAgregarFlujo',{
   extend:'Ext.window.Window' ,   
   title:'Agregar Flujo',   
   modal:true,
   internal:{
       ProcesoId:null,
       ProcesoFlujoId:null       
   },
   baseValues:{
       LastSelect:0
   },
   initialValues:{
       TipoFlujoDefaultId:null,       
       FlujoPrincipal:{
           id:1,
           nombre:'Flujo Principal'
       },
       FlujoAlternativo:{
           id:2,
           nombre:'Flujo Alternativo'
       },
       FlujoExcepcion:{
           id:3,
           nombre:'Excepcion'
       }
   },
   initComponent:function(){
       var main = this;              
       
       main.toolgen = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Guardar',
                  iconCls:'icon-disk',
                  handler:function(){
                                                             
                    if(main.internal.ProcesoFlujoId == null){
                       main.saveNew();
                    }else{

                    }                     
                  }
              },{
                  text:'Salir',
                  iconCls:'icon-door-out',
                  handler:function(){
                      main.close();
                  }
              },{
                  text:'Help',
                  iconCls:'icon-help',
                  handler:function(){
                      
                  }
              }
          ] 
       });
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Nombre',
          width:400
       });
       
       main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
           fieldLabel:'Descripcion',
           width:400
       });
       
       main.general = Ext.create('Ext.panel.Panel',{  
           bodyPadding:'10px',
           region:'west',
          items:[
              main.txtNombre,
              main.txtDescripcion
          ] 
       });
       
       main.toolbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add',
                  handler:function(){  
                    if (main.isNew() == true )  {
                        main.saveNew(false,true);
                    }else{
                        main.AddStep();                        
                    }                                                      
                  }
              },{
                  text:'Quitar',
                  iconCls:'icon-delete',
                  handler:function(){
                      
                  }
              },{
                  text:'Insertar',
                  iconCls:'icon-table_row_insert',
                  handler:function(){
                      main.InsertStep();
                  }
              },{
                  text:'Agregar Flujo Alternativo',
                  iconCls:'icon-arrow_switch',
                  handler:function(){
                      main.AddAlternateWorkFlow(); 
                  }
              },{
                  text:'Agregar Excepcion',
                  iconCls:'icon-exception',
                  handler:function(){
                      main.AddException();
                  }
              }
          ] 
       });
              
       main.gridFlujos =  Ext.create('Per.GridPanel',{    
         tbar:main.toolbar,
         border:false,         
         region:'center',
         loadOnCreate:false,
         autoScroll:true,
         width:800,
         height:400,
//         pageSize:20,         
         src:base_url+'GestionProcesos/AddProcesoFlujo/searchSteps',
         syncRowHeight:false,
         groupField: 'Grouper',
         FlowInfo:{
             NumeroFlujoPrincipal:0,
             NumeroFlujoAlternativo:0,
             NumeroExcepcion:0
         },
         WorkFlowInfo:[
             { 
                 TipoFlujoId:1,
                 NumeroFlujo:1,
                 CtdPasos:0,
                 LastIdx:0
             }
         ],
         sorters:[
             {
                 property:'TipoFlujoId',
                 direction:'ASC'
             },
             {
                 property:'NumeroFlujo',
                 directorion:'ASC'
             }
         ],
         sortableColumns:false,
         columns:[ 
              {
                  header:'id',
                  dataIndex:'id',
                  hidden:true
              } ,           
             {
                 header:'Flujo',
                 dataIndex:'Grouper',
                 hidden:true
             },
             {
                 header:'Paso',
                 dataIndex:'numeroPaso'
             },{
                 header:'Tipo Flujo Id',
                 dataIndex:'tipoFlujo.id',
                 hidden:true
             },{
                 header:'Nombre Flujo',
                 dataIndex:'NombreFlujo',
                 hidden:true
             },{
                 header:'Numero de Flujo',
                 dataIndex:'numeroFlujo',
                 hidden:true
             },{
                 header:'Tipo Flujo Id Referencia',
                 dataIndex:'TipoFlujoReferenciaId',
                 hidden:true
             },{
                 header:'Numero de Flujo Referencia',
                 dataIndex:'NumeroFlujoReferencia',
                 hidden:true
             },{
                 header:'Paso Referencia',
                 dataIndex:'PasoReferencia',
                 hidden:true
             },{
                 header:'Nombre Flujo Referencia',
                 dataIndex:'NombreFlujoReferencia',
                 hidden:true
             },{
                 header:'Descripcion',
                 dataIndex:'descripcion',
                 flex:1
             },{
                 header:'',
                 dataIndex:'PasoFlujoReferenciaId',
                 hidden:true
             }             
         ]
         ,
         features: [{ftype:'grouping'}],
         plugins: [Ext.create('Ext.grid.plugin.CellEditing', {clicksToEdit: 1})],
         pagingBar:true      
      });
      
      main.gridFlujos.on({
          'itemcontextmenu':function(grid,record,item,index,e){
                //Menu Example      
                       var Menu = Ext.create('Ext.menu.Menu', {
                           items:[
                               {
                                   text:'Agregar Flujo Alternativo',
                                   handler:function(){
                                      main.AddAlternateWorkFlow(); 
                                   }
                               },{
                                   text:'Agregar Excepcion',
                                   handler:function(){
                                      main.AddException();
                                   }
                               }
                           ]
                       });

                       Menu.showAt(e.xy[0],e.xy[1]);
                       e.stopEvent();
            },
            'itemdblclick':function(grid,record,item,index,e,eOpts){                               
                
                main.openWindowStep({
                  internal:{
                      id:record.get('id'),
                      descripcion:record.get('descripcion')
                  },
                  actions:{
                      Update:true,
                      AddStep:false
                  }
                });                
            },
            'afterrender':function(){
                    if (main.isNew() === false )  {                        
                        //getting information
                        main.findProcesoFlujo();
                        //Load the details
                        main.gridFlujos.getStore().load({
                            params:{
                              ProcesoFlujoId:main.internal.ProcesoFlujoId
                            }
                        });
                        
                        var myStoreFlujo = main.gridFlujos.getStore();
                        myStoreFlujo.on({
                            'load':function(){
                                if (myStoreFlujo.getCount() > 0 ){
                                    var mySelectionModel = main.gridFlujos.getSelectionModel();
                                    mySelectionModel.select(0);
                                }
                            }
                        });
                    }
            }
      });
      
       
      
       
       Ext.apply(this,{
          tbar:main.toolgen,          
          width:1000,
          height:650,
          layout:'border',
          items:[
              main.general,
              //main.gridTest,
              main.gridFlujos
          ]
       });
       
       //Cargamos los valores iniciales
       
       
       this.callParent(arguments);
   },
   saveNew:function(parSuccessMessage,parAddStep){
       var main = this;
       
       var records = main.gridFlujos.getStore().getRange();
       var rows = Per.Store.getDataAsJSON(records);       
       
       Ext.Ajax.request({
          url:base_url+'GestionProcesos/AddProcesoFlujo/Add',
          params:{
              ProcesoId:main.internal.ProcesoId,
              Nombre:main.txtNombre.getValue(),
              Descripcion:main.txtDescripcion.getValue()              
          },
          success:function(response){
              var msg = new Per.MessageBox();  
              msg.data = Ext.decode(response.responseText); 
              main.internal.ProcesoFlujoId = msg.data.extradata.ProcesoFlujoId;            

              main.fireEvent('Guardar');  

              if(parSuccessMessage != false ||  msg.data.success == false){                
                  msg.success();      
              }else{
                  if(parAddStep == true){
                    main.openWindowStep({
                      internal:{
                          procesoFlujoId: main.internal.ProcesoFlujoId,
                          numeroFlujo:1,
                          tipoFlujo:{
                            id:1
                          },
                          numeroPaso:1
                      },
                      actions:{
                          AddStep:true
                      }
                    })
                  }  
              }                         
          }
       });
   },   
   saveModified:function(){
       var main = this;

       var main = this;
       
       var records = main.gridFlujos.getStore().getRange();
       var rows = Per.Store.getDataAsJSON(records);       
       
       Ext.Ajax.request({
          url:base_url+'GestionProcesos/UpdateProcesoFlujo/Update',
          params:{
              ProcesoId:main.internal.ProcesoId,
              ProcesoFlujoId:main.internal.ProcesoFlujoId,
              Nombre:main.txtNombre.getValue(),
              Descripcion:main.txtDescripcion.getValue()              
          },
          success:function(response){
              var msg = new Per.MessageBox();  
              msg.data = Ext.decode(response.responseText); 
              main.internal.ProcesoFlujoId = msg.data.extradata.ProcesoFlujoId;
              msg.success();    
          }
       });

   },
   AddStep:function(){
        var main = this;
        //Obtenemos de la fila seleccionada los valores
        //Tipo de Flujo
        //Numero de Flujo
        //El Numero de Paso Actual
        var internal = {};

        var mySelectionModel = main.gridFlujos.getSelectionModel();
        var myRecord = mySelectionModel.getLastSelected();
        var myStore = main.gridFlujos.getStore();

        if(myStore.getCount() > 0){
            internal = {
              procesoFlujoId:main.internal.ProcesoFlujoId,
              procesoId:main.internal.ProcesoId,
              tipoFlujo:{
                  id:myRecord.get("tipoFlujo.id")
              },
              numeroFlujo:myRecord.get("numeroFlujo"),
              numeroPaso:parseInt(myRecord.get("numeroPaso")),
              PasoFlujoReferenciaId:null
            };
        }
        if(myStore.getCount() == 0){
            internal = {
              procesoFlujoId:main.internal.ProcesoFlujoId,
              procesoId:main.internal.ProcesoId,
              tipoFlujo:{
                  id:main.initialValues.FlujoPrincipal.id
              },
              numeroFlujo:1,
              numeroPaso:1,
              PasoFlujoReferenciaId:null
            };
        }
        
        


        main.openWindowStep({
          internal:internal,
          actions:{
              AddStep:true
          }
        });

   },
   AddAlternateWorkFlow:function(){
      

      var main = this;
        //Obtenemos de la fila seleccionada los valores
        //Tipo de Flujo
        //Numero de Flujo
        //El Numero de Paso Actual

        var mySelectionModel = main.gridFlujos.getSelectionModel();
        var myRecord = mySelectionModel.getLastSelected();

        //Los Valores del numero de paso y el numero de flujo se deberan encontrar en el controlador
        //o en el BO
        
          

        main.openWindowStep({
          internal:{
              procesoFlujoId:main.internal.ProcesoFlujoId,
              procesoId:main.internal.ProcesoId,
              tipoFlujo:{
                  id:main.initialValues.FlujoAlternativo.id
              },
              pasoFlujoReferenciaId: myRecord.get('id'),
              numeroFlujo:0,
              numeroPaso:0
          },
          actions:{
              AddAlternativeWorkFlow:true
          }
        });
           
   },
   AddException:function(){
        

      var main = this;
        //Obtenemos de la fila seleccionada los valores
        //Tipo de Flujo
        //Numero de Flujo
        //El Numero de Paso Actual

        var mySelectionModel = main.gridFlujos.getSelectionModel();
        var myRecord = mySelectionModel.getLastSelected();

        //Los Valores del numero de paso y el numero de flujo se deberan encontrar en el controlador
        //o en el BO
        main.openWindowStep({
          internal:{
              procesoFlujoId:main.internal.ProcesoFlujoId,
              procesoId:main.internal.ProcesoId,
              tipoFlujo:{
                  id:main.initialValues.FlujoExcepcion.id
              },
              pasoFlujoReferenciaId: myRecord.get('id'),
              numeroFlujo:0,
              numeroPaso:0
          },
          actions:{
              AddExceptionWorkFlow:true
          }
        });
   },
   InsertStep:function(){
       var main = this;
        //Obtenemos de la fila seleccionada los valores
        //Tipo de Flujo
        //Numero de Flujo
        //El Numero de Paso Actual

        var mySelectionModel = main.gridFlujos.getSelectionModel();
        var myRecord = mySelectionModel.getLastSelected();

        //Los Valores del numero de paso y el numero de flujo se deberan encontrar en el controlador
        //o en el BO
        
          

        main.openWindowStep({
          internal:{
              procesoFlujoId:main.internal.ProcesoFlujoId,
              procesoId:main.internal.ProcesoId,
              tipoFlujo:{
                  id:myRecord.get('tipoFlujo.id')
              },
              pasoFlujoReferenciaId: myRecord.get('id'),
              numeroFlujo:myRecord.get('numeroFlujo'),
              numeroPaso:myRecord.get('numeroPaso')
          },
          actions:{
              InsertStep:true
          }
        });
       
   },
   
   isNew:function(){
    main = this;
      if(main.internal.ProcesoFlujoId == 0 || main.internal.ProcesoFlujoId == undefined ){
           return true;
      }else{       
          return false;
      }
   },
   openWindowStep:function(config){
    var main = this;
      if (config == null){
          config = {};
      } 


      
      
      var myWinDescription = new MyApp.GestionProcesos.WinGuardarDescripcion(config);       

      myWinDescription.on({
        'close':function(){          
            main.reloadSteps(myWinDescription.internal.id);
        }
      })
      myWinDescription.show();   
   },
   //La carga se tiene que realizar de acuerdo al Flujo del proceso que se ha insertado
   //Para estos resultados no se hace el paginado
   reloadSteps:function(PasoFlujoId){
      var main = this;
      var myStore = main.gridFlujos.getStore();

      myStore.on({
        'load':function(){          
            main.selectRow(PasoFlujoId);
        }
      });
      main.gridFlujos.getStore().load({
        params:{
          ProcesoFlujoId:main.internal.ProcesoFlujoId
        }
      });
   },
   selectRow:function(PasoFlujoId){
      var main = this;
      var myStore = this.gridFlujos.getStore();
      var idx = myStore.find("id",PasoFlujoId)
      var mySelectionModel = this.gridFlujos.getSelectionModel();
      mySelectionModel.select(idx);
   },
   findProcesoFlujo:function(){
       Ext.Ajax.request({
          url:base_url+'GestionProcesos/UpdateProcesoFlujo/Find',
          params:{              
              ProcesoFlujoId:main.internal.ProcesoFlujoId             
          },
          success:function(response){
              
              var jsonResp = Ext.decode(response.responseText);
              main.txtNombre.setValue(jsonResp.data.nombre);
              main.txtDescripcion.setValue(jsonResp.data.descripcion);
              
          }
       });
   }
});