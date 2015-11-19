/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('MyApp.GestionProcesos.WinMantProcesosControl',{
    extend:'Ext.window.Window' , 
    internal:{
        Control:{
            id:null,
            nombre:null
        },
        ProcesoControl:{
            id:null
        },
        Proceso:{
            id:null
        }
    },
    editores:{},
    sourceConfig:{},
    comentarios:{},
    retirados:{},
    initComponent:function(){
        var main = this;                                     
        
        main.mainTbar =  Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Guardar',
                    id:'btnGuardarId',
                    iconCls:'icon-disk',
                    handler:function(){
                        main.save();
                    }
                },
                {
                    text:'Cancelar',
                    iconCls:'icon-door-out',
                    handler:function(){
                        main.close();
                    }
                }
            ]
        });             
        
         main.storePicker = new Ext.create('Ext.data.Store',{
            remoteFilter:true,  
//            autoLoad:true,
            fields:[
                'id',
                'nombre'
            ],
            proxy:{
               type:'ajax',
               url: base_url+'Comunes_Control/ControlEstado/getControlesActivos',
               reader:{
                   type:'json',
                   root:'results',
                   totalProperty:'total'
               }
           }
       });
        
        main.txtTipoControl = Ext.create('Ext.form.ComboBox',{
            fieldLabel: 'Control',
            store: main.storePicker,
            typeAhead:true,
            queryMode: 'remote',
            queryParam:'Nombre',
            displayField: 'nombre',
            enableKeyEvents:true,
            minChars:1,
            hideTrigger:true,
            valueField: 'id',
            width:350
        });
        
        
        main.txtTipoControl.on({
            'select':function(combo,records){                
                var mySelectedRecord = records[0];
                main.internal.Control.id = mySelectedRecord.get('id');
                main.internal.Control.nombre = mySelectedRecord.get('nombre');
                //console.log(main.internal.ProcesoControlPropiedad);
                main.getPropiedades();
            }
        });
       
        
        
        main.btnHelpControles = Ext.create('Ext.button.Button',{
            text:'...',            
            handler:function(){
                alert('clicked');
            }
        });  
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre',
            width:350
        });
        
        main.txtComentarios = Ext.create('Ext.form.field.TextArea',{
            fieldLabel:'Comentarios',
            width:350
        });
               
        
        main.gridPropiedades = Ext.create('Ext.grid.property.Grid',{                 
         //width:350,
         height:200,
         border:true,  
         copy:true,
         viewConfig:{        
//           autoRender:true,
//           copy:true,
           plugins:{
               //copy:true,
               ptype:'gridviewdragdrop',
               dropGroup:'myDragZone',
               dragGroup:'myDragZone'
           },
           listeners:{
               'beforedrop':function(node,data,overModel,dropPosition,dropHandlers){
                   var varPropiedadId = data.records[0].get('name');
                   main.gridPropiedadesDisp.removeProperty(varPropiedadId);
                   main.gridPropiedades.sourceConfig[varPropiedadId] = main.sourceConfig[varPropiedadId];
               }
           }
         },
         pagingBar:true
      });
      
       //Ext.util.Observable.capture(main.gridPropiedades, function(){console.log(arguments)});
       //Ext.util.Observable.capture(main.gridPropiedades.getView(), function(){console.log(arguments)});
      
//       main.gridPropiedades.store.addSorted(rec);
      
      main.gridPropiedades.on({
         'itemdblclick':function(grid,record,item,index,event){
             var var_propiedad_id = record.get('name');      
             var var_params = {
                 propiedadId: var_propiedad_id
             };
             main.openWinEditor(var_params);
         },
         'itemmouseleave':function(view){
             //view.refresh();
         }
      });
      
      main.gridEventos = Ext.create('Ext.grid.property.Grid',{         
        /* border:false,                      
         loadOnCreate:false,*/
         width:350,
         height:400//,
         /*pageSize:20,         
         src:base_url+'/GestionProcesos/ProcesoControl/getEventos',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Nombre',
                 dataIndex:'evento.nombre'
             },{
                 header:'Valor',
                 dataIndex:'valor',
                 flex:1
             },{
                 header:'eventoId',
                 dataIndex:'evento.id',
                 hidden:true
             },{
                 header:'controlEventoId',
                 dataIndex:'controlEvento.id',
                 hidden:true
             }
         ],*/
         //pagingBar:true
      });
      
      
       main.gridEventos.on({
         'itemdblclick':function(grid,record,item,index,event){
             var eventoName = record.get('evento.nombre');             
             main.myWinEditor.setTitle(eventoName);                          
             main.myTextAreaEditor.setValue(record.get('valor'));
             main.myWinEditor.params = {
                 method:'evento',                 
                 data:{
                     id:record.get('id'),
                     eventoId:record.get('evento.id'),
                     controlId: main.internal.Control.id,      
                     ControlEventoId: record.get('controlEvento.id')
                 }
             };
             main.myWinEditor.showAt(event.getX(),event.getY());
         } 
      });
      
      
     main.tbarPropiedades = Ext.create('Ext.toolbar.Toolbar',{
        items:[
            {
                text:'Agregar Propiedad',
                iconCls:'icon-add',
                handler:function(){
                    var w = main.mainPanel.getWidth();
                    main.mainPanel.hide();
                    main.panelSearchPropiedades.setWidth(w);
                    main.panelSearchPropiedades.show();                                          
                }
            }
        ] 
     });
      
        main.txtSearchPropiedades = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre'
        });
        
        main.panelSearchPropiedades = Ext.create('Ext.panel.Panel',{
           height:120,
           autoScroll:true,
           items:[
               main.txtSearchPropiedades
           ] 
        });
        

      
        main.mainTab = Ext.create('Ext.tab.Panel',{
            region:'center',
           items:[
               {
                   id:'tabPropiedades',
                   title:'Propiedades',
                   tbar:main.tbarPropiedades,                   
                   items:[
                       main.gridPropiedades 
                   ]
               },{
                   id:'tabEventos',
                   title:'Eventos',
                   items:[
                        main.gridEventos
                   ]
               }
           ] 
        });
        
        //Codificando cambio de tab
        main.mainTab.on({
            tabChange:function(tabPanel,newCard,oldCard){
                //main.myWinEditor.close();
                if (newCard.id === 'tabEventos'){
                    main.getEventos();
                }
                if (newCard.id === 'tabPropiedades'){
                    main.getPropiedades();
                }
            }
        });
        
//        main.gridHelpControles = Ext.create('Per.GridPanel',{
//            loadOnCreate:false,
//            width:400,
//            height:400,
//             src:base_url+'',                         
////            floating:true,
//            columns:[
//                {
//                    header:'Text',
//                    dataIndex:'ControlId'
//                }
//            ] 
//        });    
        
       
        
//        main.mainPanel = Ext.create('Ext.panel.Panel',{
//            bodyPadding:'10px',
//            layout:'column',
//            items:[
//                main.txtTipoControl,
//                main.btnHelpControles,
//                main.txtDescripcion
//            ]
//        });
        
        main.mainPanel = Ext.create('Ext.panel.Panel',{
            bodyPadding:'10px',    
            region:'west',
            items: [main.txtTipoControl,
                main.txtNombre,
                main.txtComentarios]
        });
        
        main.tbarSearchPropiedades = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Buscar',
                    iconCls:'icon-search',
                    handler:function(){
                        main.getPropiedadesSeleccionar();
                        console.log(main.gridPropiedades.getXY());
                    }
                },{
                    text:'Ocultar',
                    iconCls:'icon-collapse',
                    handler:function(){
                        main.panelSearchPropiedades.hide();
                        main.mainPanel.show();
                        
                    }
                }
            ]
        });
        
        main.txtPropiedad = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Propiedad' 
        });
        
        
        
        
        main.store_propiedades_disp = Ext.create('Ext.data.Store',{            
            fields:[
                'PropiedadId',
                'Nombre',
                'Valor'
            ],
            proxy:{
                type:'ajax',
                url: base_url+'GestionProcesos/ProcesoControl/getPropiedadesActivas',
                reader:{
                    type:'json',
                    root:'results',
                    totalProperty:'total'
                }
            }
        });
        
        
        
        
        main.gridPropiedadesDisp = Ext.create('Ext.grid.Panel', {
            title: 'Listado',            
            width: 300,  
            store:main.store_propiedades_disp,
            columns:[
                {
                    text:'Nombre',
                    dataIndex:'Nombre'                    
                },{
                    text:'Valor',
                    dataIndex:'Valor',
                    getEditor:function(record){
                        console.log(record);
                    }
                }
            ],
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1
                })
            ],
            viewConfig: {
//                //copy:false,
//                plugins: {
//                    ptype: 'gridviewdragdrop',                    
//                    dragText:'Moviendo',
//                    dragGroup:'myDragZone',
//                    dropGroup:'myDragZone'
//                },
//                listeners:{
//                    'beforedrop':function(node,data,overModel,dropPosition,dropHandlers){
//                        var varPropiedadId = data.records[0].get('name');                                                
//                        main.gridPropiedades.removeProperty(varPropiedadId);
//                        //main.gridPropiedades.sourceConfig[varPropiedadId] = main.sourceConfig[varPropiedadId];
//                    }
//                }
            }
        });
        
//        main.gridPropiedadesDisp.on({
//            'afterrender':function(){
//                main.store_propiedades_disp.load(
//                   {
//                       params:{
//                        ControlId: main.txtTipoControl.getValue(),
//                        nombre:main.txtPropiedad.getValue()
//                        }
//                    }
//                );
//            }
//        });
        
        
        
        main.panelSearchPropiedades = Ext.create('Ext.form.Panel',{
              title:'Propiedades Disponibles',    
               bodyPadding:'10px',  
               region:'west',
              hidden:true,
              tbar:main.tbarSearchPropiedades,
              items:[
                  main.txtPropiedad,
                  main.gridPropiedadesDisp
              ]
        });
        
        main.panelSearchPropiedades.on({
            'show':function(){
                //Ajax Request
            }
        })
        
//        var map = new Ext.util.KeyMap(document,[
//            {
//                key:"abc",
//                fn:function(){
//                     main.openHelpControlsWindow();
//                }
//            }
//        ]);
        
        Ext.apply(this,{            
           width:800,
           tbar:main.mainTbar,
           height:600,
           title:'Controles',
           modal:true,
           layout:'border',
           defaultFocus:main.txtTipoControl,
           items:[
                main.mainPanel,
                main.panelSearchPropiedades,
               main.mainTab               
           ]
        });       
        
        main.on({
            'resize':function(win,neww,newh){                
//                main.gridPropiedades.setHeight(newh-90);
//                main.gridEventos.setHeight(newh-90);
            },
            'show':function(){
                main.loadControl();
            }
        });
        
          this.callParent(arguments);
    },
    loadPicker:function(){
        var main = this;
        
    },
    saveNew:function(msg){
        var main = this;       
        Ext.Ajax.request({
          url:base_url+'GestionProcesos/ProcesoControl/add',
          params:{
              ControlId:main.internal.Control.id,
              nombre:  main.txtNombre.getValue(),   
              ProcesoId: main.internal.Proceso.id,
              comentarios:main.txtComentarios.getValue()              
          },
          success:function(response){
              var msg = new Per.MessageBox();               
              msg.data = Ext.decode(response.responseText);
              //console.log(msg.data);
              main.internal.ProcesoControl.id = msg.data.extradata.ProcesoControlId;
//              console.log(main.internal);
              if (msg === true){
                  msg.success();
              }                                              
          },
          failure:function(response){
              var msg = new Per.MessageBox();               
              msg.data = Ext.decode(response.responseText);
              msg.failure();
          }
       });
    },
    modify:function(msg){
        var main = this;
        Ext.Ajax.request({
          url:base_url+'GestionProcesos/ProcesoControl/upd',
          params:{
              ControlId:main.internal.Control.id,
              nombre:  main.txtNombre.getValue(),   
              ProcesoId: main.internal.Proceso.id,
              comentarios:main.txtComentarios.getValue(),
              ProcesoControlId: main.internal.ProcesoControl.id
              
          },
          success:function(response){
              var msgbox = new Per.MessageBox();  
              msgbox.data = Ext.decode(response.responseText);
              //console.log(msg.data);
              //main.internal.ProcesoControl.id = jsonResponse.extradata.ProcesoControlId;
//              console.log(main.internal);
              if (msg === true){
                  msgbox.success();
              }                                              
          },
          failure:function(response){
              var msg = new Per.MessageBox();               
              msg.data = Ext.decode(response.responseText);
              msg.failure();
          }
       });
        
    },
    openHelpControlsWindow:function(){
        console.log('now');
        var main = this;       
    },
    loadControls:function(){
        var main = this;
        main.storePicker.load({
            params:{
                Nombre:main.txtTipoControl.getRawValue()
            }
        });
    },
    getPropiedades:function(){
        var main = this;
        
        var params = {
            ControlId:main.internal.Control.id,
            ProcesoControlId: main.internal.ProcesoControl.id
        };
        
        //main.gridPropiedades.load(params);
    },
    getEventos:function(){
        var main = this;
        
        var params = {
            ControlId:main.internal.Control.id,
            ProcesoControlId:main.internal.ProcesoControl.id
        };
        
        main.gridEventos.load(params)
                
    },
    loadControl:function(){
        var main = this;
        if (main.internal.ProcesoControl.id !== null){
            Ext.Ajax.request({
                url:base_url+'GestionProcesos/ProcesoControl/find',
                params:{
                    id:main.internal.ProcesoControl.id
                },
                success:function(response){
                    var object = Ext.decode(response.responseText);                    
                    main.txtTipoControl.setValue(object.data.control.nombre);
                    main.txtNombre.setValue(object.data.nombre);
                    main.internal.Control.id = object.data.control.id
                    //Loading Properties
                    main.getPropiedades();
                }
            });
        }
    },
//    addValor:function(params){
//        var main = this;
//          if (params.method === 'propiedad'){
//              main.addValorPropiedad(params);
//          }
//          if (params.method === 'evento'){
//              main.addValorEvento(params);
//          }
//    },
//    addValorPropiedad:function(params){
//        var main = this;
//        Ext.Ajax.request({
//            url:base_url+'GestionProcesos/ProcesoControl/writePropiedad',
//            params:{
//                ProcesoControlPropiedadId: params.data.id,
//                ControlId: params.data.controlId,
//                PropiedadId: params.data.propiedadId,
//                ProcesoControlId:main.internal.ProcesoControl.id,
//                Valor: main.myTextAreaEditor.getValue(),
////                ControlPropiedadId: params.data.ControlPropiedadId
//            },
//            success:function(response){      
//                main.myWinEditor.close();
//                main.txtTipoControl.disabled = true;              
//                //main.getPropiedades();
//                main.gridPropiedadesDisp.removeProperty(params.data.propiedadId);
//                params.dropHandlers.processDrop();
//                
//            },
//            failure:function(){
//                params.dropHandlers.cancelDrop();
//            }
//        });
//    },
//    addValorEvento:function(params){
//        var main = this;
//        Ext.Ajax.request({
//            url:base_url+'GestionProcesos/ProcesoControl/writeEvento',
//            params:{
//                ProcesoControlEventoId:params.data.id,
//                ControlId: params.data.controlId,
//                EventoId: params.data.eventoId,
//                ProcesoControlId: main.internal.ProcesoControl.id,
//                Valor: main.myTextAreaEditor.getValue(),
//                ControlEventoId: params.data.ControlEventoId
//            },
//            success:function(response){
//                main.myWinEditor.close();                
//                main.getEventos();
//            }
//        });
//        
//    },
//    winEditorClose:function(){
//        var main = this;
//        main.myWinEditor.close();
//    },
    getPropiedadesSeleccionar:function(){
        var main = this;
//        Ext.Ajax.request({
//            url:base_url+'GestionProcesos/ProcesoControl/getPropiedadesActivas',
//            params:{
//                ControlId: main.txtTipoControl.getValue(),
//                nombre:main.txtPropiedad.getValue()
//            },
//            success:function(response){
//                var data = Ext.decode(response.responseText);
////                console.log(data);
//                main.crearSourceConfig(data);
//                
////                main.gridPropiedades.setSource(data);
//            }
//        });

            main.store_propiedades_disp.load(
                {
                    params:{
                     ControlId: main.txtTipoControl.getValue(),
                     nombre:main.txtPropiedad.getValue()
                     }
                 }
             );
    },
    crearSourceConfig:function(data){
        var main = this;        
        var source = {};
        var records = data.results;
        for (var idx in records){

            var PropiedadId = records[idx]["id"];
            var varNombrePropiedad = records[idx]["nombre"];
            
            source[PropiedadId] = "";            
            var editor = main.crearComboBoxPropiedad(PropiedadId);                                                
            
            main.sourceConfig[PropiedadId] = {
                editor:editor,
                displayName:varNombrePropiedad,
                renderer:function(v,metadata,record){                     
                    var store = main.editores["cm"+record.get('name')];                    
                    store.findBy(function(record){                           
                        if (record.get('id') === v) {                            
                            v = record.get('valor');
                            return true; // findby
                        } 
                    });
                    return v;
                }
            };                        
        }
        main.gridPropiedadesDisp.setSource(source,main.sourceConfig);  
        var mySelectionModel = main.gridPropiedadesDisp.getSelectionModel();
        mySelectionModel.select(0);
    },
    crearComboBoxPropiedad:function(parPropiedadId){
        var main = this;
        //main.editores[""] = 
         main.editores["cm"+parPropiedadId] =  Ext.create('Ext.data.Store', {   
            id:"cm"+parPropiedadId,
            fields: ['id', 'valor'],
            proxy:{
                 type:'ajax',
                 url:base_url+'GestionProcesos/ProcesoControl/getValores',
                 reader:{
                     type:'json',
                     root:'results'
                 }
            },
            listeners:{
                'beforeload':function(store,operation,eOpts){
                    store.getProxy().extraParams = {
                        PropiedadId:parPropiedadId  
                    };
                }
            }
        });
        
//        console.log(main.editores);
        
        // Create the combo box, attached to the states data store
        return Ext.create('Ext.form.ComboBox', {           
            store:  main.editores["cm"+parPropiedadId],                          
            queryMode: 'remote',
            selectOnFocus: true,
            queryParam:'valor',
            displayField: 'valor',
            valueField: 'id'          
        });
    },
    openWinEditor:function(object){
        var main = this;
        
        main.myTextAreaEditor = Ext.create('Ext.form.field.TextArea',{
            width:350,
            height:150
        });
        main.myWinEditor = Ext.create('Ext.window.Window',{             
             width:350,
             height:200,  
             title:'Comentarios',
             //closeAction:'hide',
//             closable:false,
             modal:true,
             params:{
                method:null,
                data:{}
             },
             defaultFocus: main.myTextAreaEditor,
             items:[
                 main.myTextAreaEditor
             ],
             buttons:[
                 {
                     text:'Aceptar',
                     handler:function(){                         
                         main.comentarios[object.propiedadId] = main.myTextAreaEditor.getValue();                         
                         console.log(main.comentarios);
                     }
                 },
                 {
                     text:'Cancelar',
                     handler:function(){
                         main.myWinEditor.hide();
                     }
                 }
             ]
        });
        
        main.myWinEditor.show();
    },
    save:function(){
        var main = this;
        main.gridPropiedades.getView().refresh();
        
        
        
        Ext.Ajax.request({
          url:base_url+'GestionProcesos/ProcesoControl/xxx',
          params:{
                control_id:main.internal.Control.id,
                nombre:  main.txtNombre.getValue(),  
                proceso_id: main.internal.Proceso.id,
                propiedades_guardar:main.get_propiedades_guardar()
          }
       });
        
    },
    get_propiedades_guardar:function(){
        var main = this;
        
        var records = main.gridPropiedades.getStore().getRange();      
        
        console.log(records);
        
        var var_propiedad_id;
        var var_propiedades = "[";
        for(var idx in records){         
            var_propiedad_id = records[idx].get('name');
            var_propiedades+='{"PropiedadId":"'+var_propiedad_id+'",';
            var_propiedades+='"Valor":"'+records[idx].get('value')+'",';
            var_propiedades+='"Comentarios":"'+main.comentarios[var_propiedad_id]+'"},';
            
            //console.log(records[idx].getId());
        }
        var_propiedades = var_propiedades.slice(0,-1);
        var_propiedades+="]";
        return var_propiedades;
    }
});