/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionControles.WinMantGestionControles',{
    extend:'Ext.window.Window',    
    create:true, //parametro que utilizamos para determinar si es un nuevo registro un la edicion de uno ya existente
    id:null,
    width:500,
    height:150,
    modal:true,
    frame:false,
    internal:{
       id:null  
    },
    constructor:function(parameter){                       
        var main = this;     
        main.internal.id = parameter;
        //Just do whether parameter is setted
        if(parameter != undefined){
            if(parameter.id != null && parameter.create == false){
              Ext.MessageBox.show({
                title:'Titulo',
                msg:'Obteniendo Datos',
                icon:Ext.MessageBox.INFO,
                progress:true
             });
             //Loading data
             Ext.Ajax.request({
                url:base_url+'GestionControles/GestionControlesController/find',
                params:{
                    id: parameter.id                               
                },
                success:function(response){         
                    Ext.MessageBox.close();
                    var data = Ext.decode(response.responseText);
                    main.txtNombre.setValue(data.data.nombre);
                    main.dtFechaRegistro.setValue(data.data.fechaRegistro);
                    main.dtFechaUltAct.setValue(data.data.fechaUltAct);
                    main.txtEstado.setValue(data.data.estado.nombre);
                },
                failure:function(response){
                    Ext.MessageBox.close();
                }
             });
                                        
          }                     
        }
        
          
      
      this.callParent(arguments);
    },
    initComponent:function(){
        var main = this;
        
        if (main.create == true){
            main.title = 'Nuevo Tipo de Control';
        }else{
            main.title = 'Modificar Tipo de Control';
            //Load Parameters
         
        }
        
        main.storePicker = new Ext.create('Ext.data.Store',{
            remoteFilter:true,  
//            autoLoad:true,
            fields:[
                'id',
                'nombre'
            ],
            proxy:{
               type:'ajax',
               url: base_url+'GestionControles/GestionControlesController/getTecnologias',
               reader:{
                   type:'json',
                   root:'results',
                   totalProperty:'total'
               }
           }
       });
        
        main.txtTecnologia = Ext.create('Ext.form.ComboBox',{
            fieldLabel: 'Tecnologia',
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
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar');
              
        //main.tbar.add(main.btnNuevo);
        
        main.btnGuardar = {
                            text:'Guardar',
                            iconCls:'icon-disk',
                            handler:function(){
                                if(main.create === true){
                                    main.saveNewTipoControl();
                                }else{
                                    main.saveModifiedTipoControl();
                                }                                
                           }
                       }
        main.tbar.add(main.btnGuardar);
        main.btnInactivar = {
                            text:'Inactivar',
                            handler:function(){
                            if(main.create == false){
                                main.suspendTipoControl();
                            }
                           }}
        if(main.create == false){
            main.tbar.add(main.btnInactivar);
        }
        
        main.btnClose = {
            text:'salir',
            iconCls:'icon-door-out',
            handler:function(){
                main.close();
            }
        };
        main.tbar.add(main.btnClose);

        /*main.txtTecnologia = Ext.create('Ext.form.field.Text',{
            width:350,
            fieldLabel:'Tecnologia'
        })*/
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
            width:350,
            fieldLabel:'Nombre'
        });
        main.dtFechaRegistro = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha De Registro',
           disabled:true
        });
        main.dtFechaUltAct = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Ult. Act.',
           disabled:true
        });
        
        main.txtEstado = Ext.create('Ext.form.field.Date',{
            fieldLabel:'Estado',
            disabled:true
        });
        
        //Hide Controls when New
        if(main.create == true){
            main.dtFechaUltAct.hide();
            main.txtEstado.hide();
        }
        
        //@
        main.panelGeneral = Ext.create('Ext.panel.Panel',{
            bodyPadding:'10px',
            split:true,
            region:'west',
            width:400,
           items:[
               main.txtTecnologia,
               main.txtNombre,
               main.dtFechaRegistro,
               main.dtFechaUltAct,
               main.txtEstado
           ] 
        });
        //
        
        //@section creating tab control to link properties and events
        //@avaiable properties
        main.toolbarSelectProp = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Agregar',
                    iconCls:'icon-add',
                    handler:function(){
                        if(main.create === true){
                            main.saveNewTipoControl(true);
                        }else{
                            main.saveModifiedTipoControl(true);
                        }                                                
                    }
                }
            ] 
        });
        
        main.chkSelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        })
        
        main.gridPropertiesSelect = Ext.create('Per.GridPanel',{            
            tbar:main.toolbarSelectProp,
            //title:'Propiedades Disponibles',
            width:'100%',
           pageSize:20,
           src:base_url+'GestionControles/GestionControlesController/GetActiveProperties',
           split:true,           
           region:'west',
           selModel:main.chkSelModel,
           columns:[
               {
                   xtype:'rownumberer'
               },{
                   header:'Nombre',
                   dataIndex:'nombre',
                   flex:1
               }
           ]
            });
        
        
   
        //@avaiable properties end
        //@properties
        main.tbarProperties = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Quitar',
                   iconCls:'icon-delete',
                   handler:function(){
                      main.DropLinkedProperty();
                   }
               }
           ] 
        });
        
        
        main.chkSelModelDrop  = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });
        
        main.gridProperties = Ext.create('Per.GridPanel',{
            title:'Propiedades Asociadas',
            loadOnCreate:false,
            tbar:main.tbarProperties,
            src:base_url+'GestionControles/GestionControlesController/GetLinkedProperties',
            region:'center',
            width:'50%',
            pageSize:20,         
            selModel:main.chkSelModelDrop,
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Nombre',
                    dataIndex:'propiedad.nombre',
                    flex:1
                }
            ]
        });
        //@properties end
        //@events
        main.tbarEventsSel = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   handler:function(){
                       //main.AddLinkedEvent();
                   }
               }
           ] 
        });
        
        main.chkSelModelEvent = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        })
        
        main.gridEventsSels = Ext.create('Per.GridPanel',{
            tbar:main.tbarEventsSel,            
            src:base_url+'GestionControles/GestionControlesController/getActiveEvents',
            region:'west',            
            width:350,
            pageSize:20,  
            selModel:main.chkSelModelEvent,
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Nombre',
                    dataIndex:'nombre'
                }
            ]
        });
        
        
        main.tbarEvents = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Quitar',
                    iconCls:'icon-remove',
                    handler:function(){
                        main.DropLinkedEvent();
                    }
                }
            ]
        });
        
        main.chkEvent = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });
        
        main.gridEvents = Ext.create('Per.GridPanel',{
            tbar:main.tbarEvents,
            loadOnCreate:false,
            selModel:main.chkEvent,
            src:base_url+'GestionControles/GestionControlesController/GetLinkedEvents',
            width:350,
            region:'center',
            pageSize:20,         
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Nombre',
                    dataIndex:'evento.nombre',
                    flex:1
                }
            ]
        });
        //@events end
        
        
        main.tabPanel = Ext.create('Ext.tab.Panel',{
            width:400,
            height:400,
            region:'center',
            items:[{
                    title:'Propiedades',
                    xtype:'panel',
                    layout:'border',
                    items:[
                        main.gridPropertiesSelect/*,
                        main.gridProperties*/
                    ]
                   }                
                    ,{
                    title:'Eventos',
                    xtype:'panel',
                    layout:'border',
                    items:[
                        main.gridEventsSels,
                        main.gridEvents
                    ]                
                }]
        });
        
        //end @section
        
        Ext.apply(this,{
            width: 900, 
            height: 600,
            layout:'border',
            items:[
                main.panelGeneral,
                main.tabPanel
            ],
            listeners:{
                'resize':function(x,y,width,height){
//                    console.log(x);
//                    console.log(y);
//                    console.log(width);
//                    console.log(height);
                }
            }
        });
        
        //After all definition load parameters
        if(main.create == false){               
            main.gridProperties.load({                  
                   ControlId:main.internal.id                   
            })  
            main.gridEvents.load({
                ControlId:main.internal.id
            })            
        }
        
        
         this.callParent(arguments);
    },
    resetToNew:function(){
        var main = this;
        main.txtNombre.setValue('');
    },
    saveNewTipoControl:function(openWindow){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionControles/GestionControlesController/add',
            params:{
                nombre: main.txtNombre.getValue(),
                TecnologiaId: main.txtTecnologia.getValue()
            },
            success:function(response){           
                var msg = new Per.MessageBox();                  
                msg.data = Ext.decode(response.responseText); 
                main.fireEvent('saved');
                if(msg.data.success == true){
                    if(openWindow != 'undefined' && openWindow == true ){
                        main.AbrirVenetanaPropiedad('Agregar Propiedad');
                    }else{
                        
                        msg.success();    
                        msg.on({
                            'okButtonPressed':function(){
                                //Preparar Nuevo Registro
                                main.resetToNew();
                            }
                        });
                    }
                }                                
            }
        })
    },
    saveModifiedTipoControl:function(openWindow){
        var main = this;        
        
        Ext.Ajax.request({
            url:base_url+'GestionControles/GestionControlesController/update',
            params:{
                nombre: main.txtNombre.getValue(),                               
                id: main.id,
                TecnologiaId: main.txtTecnologia.getValue()
            },
            success:function(response){                                                     
                var msg = new Per.MessageBox();  
                main.fireEvent('saved');                
                if(openWindow != 'undefined' && openWindow == true ){
                    main.AbrirVenetanaPropiedad('Agregar Propiedad');
                }else{                    
                    msg.data = Ext.decode(response.responseText); 
                    msg.success();    
                    msg.on({
                        'okButtonPressed':function(){
                            //Preparar Nuevo Registro
                            main.resetToNew();
                        }
                    });
                }
            },
            failure:function(response){                                
                var msg = new Per.MessageBox();
                msg.data = Ext.decode(response.responseText);
                msg.failure();
                msg.on({
                   'okButtonPressed':function(){
                       //Set Acction Here
                   }
                });
                main.fireEvent('saved');
            }
        })
    },
    suspendTipoControl:function(){
        var main = this;
        var rsp = true;
        
        Ext.Ajax.request({
           url:base_url+'GestionControles/GestionControlesController/inactivate',
           params:{
               nombre:main.txtNombre.getValue(),
               id:main.id
           },
            success:function(response){    
                if(showMessage == true){
                    var msg = new Per.MessageBox();  
                    msg.data = Ext.decode(response.responseText); 
                    msg.success();  
                }
                
                //Colocar el ID en la ventana.
                
//                msg.on({
//                    'okButtonPressed':function(){
//                        //Preparar Nuevo Registro
////                        main.resetToNew();
//                    }
//                })
            },
            failure:function(response){                
                var msg = new Per.MessageBox();
                msg.data = Ext.decode(response.responseText);
                msg.failure();
                msg.on({
                   'okButtonPressed':function(){
                       //Set Acction Here
                   }
                });
            }
        });
    },
    AddProperty:function(){
        var main = this;
                       
        //Si el dato aun no se ha guardado, es necesario validar y luego guardarlo
        //Por cada fila seleccionada, y cuando se presione el boton agregar
        //se debe agregar a las propiedades asociadas
        var mySelectionModel  = main.gridPropertiesSelect.getSelectionModel(); 
        
        
        
        var records = mySelectionModel.getSelection();
        var columns = Per.Store.getDataAsJSON(records);
        
        //
        Ext.Ajax.request({
           url:base_url+'GestionControles/AddProperties/Add',
           params:{               
               ControlId:main.internal.id,
               nombre:main.txtNombre.getValue(),
               records:columns
           },
           success:function(response){
               var msg = new Per.MessageBox();  
               msg.data = Ext.decode(response.responseText); 
               msg.success();  
               main.internal.id = msg.data.extradata.ControlId; 
               
               //Refresh
               main.gridProperties.load({                  
                       ControlId:main.internal.id                   
               })
               main.fireEvent('saved');
           },
           failure:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.failure();
               main.fireEvent('saved');
           }
        })        
    },
    DropLinkedProperty:function(){
        var main = this;
        
        var mySelectionModel  = main.gridProperties.getSelectionModel();        
        var records = mySelectionModel.getSelection();
        var columns = Per.Store.getDataAsJSON(records);
        
        Ext.Ajax.request({
           url:base_url+'GestionControles/DropLinkedProperty/Drop',
           params:{               
               ControlId:main.internal.id,
               nombre:main.txtNombre.getValue(),
               records:columns
           },
           success:function(response){
               var msg = new Per.MessageBox();  
               msg.data = Ext.decode(response.responseText); 
               msg.success();  
               //Refresh
               main.gridProperties.load({                  
                       ControlId:main.internal.id                   
               })                                
           },
           failure:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.failure();
           }
        })                        
    },
    AddLinkedEvent:function(){
        var main = this;
        var mySelectionModel  = main.gridEventsSels.getSelectionModel();        
        var records = mySelectionModel.getSelection();
        var columns = Per.Store.getDataAsJSON(records);
        
        Ext.Ajax.request({
           url:base_url+'GestionControles/AddLinkedEvent/Add',
           params:{               
               ControlId:main.internal.id,
               nombre:main.txtNombre.getValue(),
               records:columns
           },
           success:function(response){
               var msg = new Per.MessageBox();  
               msg.data = Ext.decode(response.responseText); 
               msg.success();  
               main.internal.id = msg.data.extradata.ControlId; 
               
               //Refresh
               main.gridProperties.load({                  
                       ControlId:main.internal.id                   
               })                                
           },
           failure:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.failure();
           }
        })
        
    }
    ,
    DropLinkedEvent:function(){
        var main = this;
        
        var mySelectionModel  = main.gridEvents.getSelectionModel();                          
        var records = mySelectionModel.getSelection();
        var columns = Per.Store.getDataAsJSON(records);
        
        Ext.Ajax.request({
           url:base_url+'GestionControles/DropLinkedEvent/Drop',
           params:{     
               state:null,
               ControlId:main.internal.id,
               nombre:main.txtNombre.getValue(),
               records:columns
           },
           success:function(response){
               var msg = new Per.MessageBox();  
               msg.data = Ext.decode(response.responseText); 
               msg.success();  
               //Refresh
               main.gridProperties.load({                  
                       ControlId:main.internal.id                   
               })                                
           },
           failure:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.failure();
           }
        }) 
    },
    AbrirVenetanaPropiedad:function(title){
        var main = this;
        
        var myWin = new MyApp.GestionControles.WinMantPropiedades({
            title:title
        });
        myWin.show();
    }
})  