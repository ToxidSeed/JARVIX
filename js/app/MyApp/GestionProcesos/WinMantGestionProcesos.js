
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProcesos.WinMantGestionProcesos',{
   extend:'Ext.panel.Panel',
   width:1,
   height:1,
   maximized:true,
   title:'Registro de Nuevo Proceso',
   floating:true,//Importante sin esto no se muestra el panel
   internal:{
       id:null
   },
   initComponent:function(){
       var main = this;
//              
      main.txtCodigo = Ext.create('Ext.form.field.Text',{
          name:'Codigo',
          fieldLabel:'Codigo',
          disabled:true
      });
       
      main.txtNombre = Ext.create('Ext.form.field.Text',{
          name:'nombre',
          fieldLabel:'Nombre',
          width:350
      });
      
      main.uploadImage = Ext.create('Ext.form.field.File',{
          name:'prototypeUpload',
          fieldLabel:'Prototipo',
          width:350
      });
      
      main.Descripcion = Ext.create('Ext.form.field.TextArea',{
          fieldLabel:'Descripcion' ,
          width:350,
          height:300
      });
      
      main.toolbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Guardar',
                  iconCls:'icon-disk',
                  handler:function(){                      
                      main.panelMainData.submit({
                          success:function(response,action){                              
                              var data = Ext.decode(action.response.responseText);                              
                              main.internal.id = data.extradata.ProcesoId;
                              main.loadGeneralData();
                          },
                          failure:function(){
                              alert('Failure');
                          }
                      });
                  }
              }
          ]
      });
      
      main.panelMainData = Ext.create('Ext.form.Panel',{
          url:base_url+'GestionProcesos/GestionProcesosController/add',
          tbar:main.toolbar,   
          border:false,
          bodyPadding:'10px',
          items:[
              main.txtCodigo,
              main.txtNombre,
              main.uploadImage,
              main.Descripcion
          ]
      })    
      
      
      
      main.toolbarFlujo = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add',
                  handler:function(){
                      
                      var WinAgregarFlujo = new MyApp.GestionProcesos.WinAgregarFlujo({
                          internal:{
                              ProcesoId:main.internal.id
                          }
                      });
                      WinAgregarFlujo.on({
                            'close':function(){
                                main.refreshFlujos();
                            }
                        })
                      WinAgregarFlujo.show();
                  }
              },{
                  text:'Quitar',
                  iconCls:'icon-delete',
                  handler:function(){
                      main.quitarFlujos();
                  }
              }
          ]
      });
      
      
      
      main.gridFlujoProceso = Ext.create('Per.GridPanel',{         
         border:false,                      
         loadOnCreate:false,
         width:350,
         height:200,
         pageSize:20,         
         src:base_url+'GestionProcesos/GestionProcesosController/getFlujos',
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
             }             
         ],
         pagingBar:true
      });
      
      main.gridFlujoProceso.on({
          'afterrender':function(){
             
             main.refreshFlujos();
          },
          'itemdblclick':function(grid,record){
              //var ProcesoFlujoId = record.get('id');
              var WinAgregarFlujo = new MyApp.GestionProcesos.WinAgregarFlujo({
                    internal:{
                        ProcesoId:main.internal.id,
                        ProcesoFlujoId:record.get('id')
                    }
                });
                WinAgregarFlujo.on({
                    'close':function(){
                        main.refreshFlujos();
                    }
                })
                WinAgregarFlujo.show();
          }
      });
      
       main.panelMainFlujo = Ext.create('Ext.panel.Panel',{
          tbar:main.toolbarFlujo,
          border:false,             
          items:[
              main.gridFlujoProceso
          ]
      });
      
      main.gridControles =  Ext.create('Per.GridPanel',{         
         loadOnCreate:false,
         width:250,
         height:200,
//         pageSize:20,         
         src:base_url+'GestionProcesos/ProcesoControl/getControls',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Id',
                 dataIndex:'id',
                 width:'50'
             },{
                 header:'Nombre',
                 dataIndex:'nombre',
                 flex:1
             },{
                 header:'Tipo',
                 dataIndex:'control.nombre'
             }             
         ]      
      });
      
      main.gridControles.on({
          'itemdblclick':function(grid,record){
               var myWin = new MyApp.GestionProcesos.WinMantProcesosControl();  
                myWin.internal.Proceso.id = main.internal.id;
                myWin.internal.ProcesoControl.id = record.get('id');
                myWin.show();
          }
      })
      
      main.toolbarControles = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add',
                  handler:function(){                      
                      var myWin = new MyApp.GestionProcesos.WinMantProcesosControl();  
                      myWin.internal.Proceso.id = main.internal.id;  
                      myWin.internal.ProcesoControl.id = null
                      myWin.show();
                  }
              },{
                  text:'Quitar',
                  iconCls:'icon-delete',
                  handler:function(){
                      
                  }
              }
          ]
      });
      
      main.panelControles = Ext.create('Ext.panel.Panel',{
          tbar:main.toolbarControles,
          border:false,
          items:[
              main.gridControles
          ]
      });
      
      var myChkSelector = Ext.create('Ext.selection.CheckboxModel');
      
      
      main.gridRequerimientosFuncionales =  Ext.create('Per.GridPanel',{         
         border:false,
         resizable:true,    
         loadOnCreate:false,
         width:250,
         height:200,
         pageSize:20,         
         src:base_url+'GestionProcesos/GestionProcesosController/getRequerimientos',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'requerimientoFuncional.codigo'
             },{
                 header:'Nombre',
                 dataIndex:'requerimientoFuncional.nombre',
                 flex:1
             }             
         ],
         pagingBar:true,
         selModel:myChkSelector
      });
      
      main.toolbarReqFunc = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add',
                  handler:function(){
                      var winAddRequerimiento = Ext.create('MyApp.GestionProcesos.WinAddRequerimiento');
                      //console.log(main.internal);
                      winAddRequerimiento.internal.proceso.id = main.internal.id
                      winAddRequerimiento.show();
                      winAddRequerimiento.on({
                          'save':function(){
                              main.refreshReqs();
                          }
                      });
//                      winAddRequerimiento.gridRequerimientos.on({
//                          'load':
//                      })
                  }
              },{
                  text:'Quitar',
                  iconCls:'icon-delete',
                  handler:function(){
                      main.removeRequerimientos();                      
                  }
              }
          ]
      });
      
      main.panelRequerimientosFuncionales = Ext.create('Ext.panel.Panel',{
          tbar:main.toolbarReqFunc,
          border:false,
          items:[
              main.gridRequerimientosFuncionales
          ]
      });
      
      main.panelData = Ext.create('Ext.panel.Panel',{
         region:'west',
         title:'Informacion Relacionada',
         width:400,
         split:true,
         collapsible:true,
         border:false,
         //bodyPadding:'10px',
         layout:'accordion',
         items:[
             {
               title:'Datos Generales',
               items:[
                   main.panelMainData
               ]
             }
             ,
             {
                 title:'Flujos',
                 items:[
                     main.panelMainFlujo
                 ],
                 listeners:{
                     'expand':function(){
                         main.resizePanels();                         
                     }
                 }
             }
             ,{
                 title:'Controles',
                 items:[
                     main.panelControles
                 ],
                 listeners:{
                     'expand':function(){
                         main.refreshControls();
                         main.resizePanelControl();
                     }
                 }
             },{
                 title:'Requerimientos Funcionales',
                 items:[
                     main.panelRequerimientosFuncionales
                 ],
                 listeners:{
                     'expand':function(){
                         main.refreshReqs();
                         main.resizeRequerimientos();
                              //refreshReqs
                     }
                 }
             }
         ]
      });
      
        main.protoImage = Ext.create('Ext.Img', {
//            src: 'http://localhost/requerimentsManager/uploads/GestionProcesos.png'
        });
      
      main.tbarEspecificacion = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar'
              },{
                  text:'Insertar'
              },{
                  text:'Agregar Flujo Alternativo'
              },{
                  text:'Agregar Excepcion'
              }
          ] 
      });
      
      main.gridFlujos =  Ext.create('Per.GridPanel',{             
         border:false,         
         region:'center',
         loadOnCreate:false,
         autoScroll:true,
         width:800,
         height:400,
//         pageSize:20,     
        resizable:true,
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
      
      main.panelPrototype = Ext.create('Ext.panel.Panel',{          
          title:'Prototipo',
          region:'center',
          width:200,
          items:[
              main.protoImage
          ]
          
      });
           
       Ext.apply(this,{
            layout:'border',
            width:200,
            border:false,
            height:200,
            items:[
               main.panelData,
               main.panelPrototype
            ]
            
            
        });
        
        main.on({
            'show':function(){
                main.loadGeneralData();
            }
        })                            
       
       this.callParent(arguments);
   },
   loadGeneralData:function(){
       var main = this;              
       
       Ext.Ajax.request({
          url:base_url+'GestionProcesos/GestionProcesosController/find',
          params:{
              id:main.internal.id
          },
          success:function(response){
              var data = Ext.decode(response.responseText);
              main.protoImage.setSrc(data.data.rutaPrototipo);
              main.txtCodigo.setValue(data.data.id);
//              main.uploadImage.setValue('data.data.rutaPrototipo');
              
          }
       });
   },resizePanels:function(){
       var main = this;
       
       
       
       //Resizing Height Panel
       var myComponent = main.panelMainFlujo.findParentByType('panel');    
       var newHeight = myComponent.getHeight() - myComponent.header.getHeight();       
       main.panelRequerimientosFuncionales.setHeight(newHeight);
       //Getting width
       var myContainerWidth = myComponent.getWidth();
       
       //Resizing Grid
       var newHeightGrid = newHeight - main.toolbarFlujo.getHeight();
       main.gridFlujoProceso.setHeight(newHeightGrid);
       main.gridFlujoProceso.setWidth(myContainerWidth);
       
       
       
       
   },refreshFlujos:function(){
      var main = this;
        main.gridFlujoProceso.load({
            ProcesoId:main.internal.id
        }); 
   },quitarFlujos:function(){
      
      var main = this;
      
      var mySelectionModel = main.gridFlujoProceso.getSelectionModel();
      var records = mySelectionModel.getSelection();
      
      Ext.Ajax.request({
          url:base_url+'GestionProcesoFlujo/QuitarProcesoFlujo/Quitar',
          params:{
              flujosEliminar: Per.Store.getDataAsJSON(records)
          },
          success:function(response){
                  main.refreshFlujos();       
          }
       });
   },refreshControls:function(){
      var main = this;
       main.gridControles.load({
            ProcesoId:main.internal.id
        }); 
      
   },refreshReqs:function(){
        var main = this;
        
        main.gridRequerimientosFuncionales.load({
           ProcesoId: main.internal.id 
        });
        
   },resizePanelControl:function(){
       var main = this;
       
       
       
       //Resizing Height Panel
       var myComponent = main.panelControles.findParentByType('panel');    
       var newHeight = myComponent.getHeight() - myComponent.header.getHeight();       
       main.panelControles.setHeight(newHeight);
       //Getting width
       var myContainerWidth = myComponent.getWidth();
       
       //Resizing Grid
       var newHeightGrid = newHeight - main.toolbarControles.getHeight();
       main.gridControles.setHeight(newHeightGrid);
       main.gridControles.setWidth(myContainerWidth);
   },resizeRequerimientos:function(){
      var main = this;
      
       var myComponent = main.panelRequerimientosFuncionales.findParentByType('panel');    
       var newHeight = myComponent.getHeight() - myComponent.header.getHeight();       
       main.panelRequerimientosFuncionales.setHeight(newHeight);
       //Getting width
       var myContainerWidth = myComponent.getWidth();
       
       //Resizing Grid
       var newHeightGrid = newHeight - main.toolbarReqFunc.getHeight();
//      console.log(newHeightGrid);
//      console.log(myContainerWidth);
       main.gridRequerimientosFuncionales.setHeight(newHeightGrid);
        main.gridRequerimientosFuncionales.setWidth(myContainerWidth);
   },removeRequerimientos:function(){
       var main = this;
        var mySelModel  = main.gridRequerimientosFuncionales.getSelectionModel();         
        var records = mySelModel.getSelection();
        var columns = ['id'];
        var data = Per.Store.getDataAsJSON(records,columns);
        
        //Save Records
        
        Ext.Ajax.request({
           url:base_url+'GestionProcesos/ProcesoRequerimientoFuncional/Quitar',
           params:{
               Requerimientos: data
           },
           success:function(response){
                //main.winHelper = Ext.create('Per.DebugHelperWindow');
                //main.winHelper.showMsg(response.responseText);
                main.refreshReqs();
           },
           failure:function(){
               
           }
        });
   }   
});

