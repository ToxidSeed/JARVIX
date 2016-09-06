/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionControles.WinMantGestionControles',{
    extend:'Ext.window.Window',    
    create:true, //parametro que utilizamos para determinar si es un nuevo registro un la edicion de uno ya existente
    internal:{
        id:null
    },
    width:500,
    height:150,
    modal:true,
    frame:false,
    pendingAddEvent:false,
    showSavingEvent:null,    
    initComponent:function(){
        var main = this;       
        
        Ext.define('Evento', {
            extend: 'Ext.data.Model',
            fields: [
                {name:'id'},
                {name: 'nombre'}
            ]
        });
        
        if (main.create == true){
            main.title = 'Nuevo Tipo de Control';
        }else{
            main.title = 'Modificar Tipo de Control';
            //Load Parameters
         
        }
        
        Ext.define('MyAppPickerModel', {
            extend: 'Ext.data.Model',            
            fields: [
                { name: 'id'},
                { name: 'nombre'}
             ]
        });
        
        main.storePicker = new Ext.create('Ext.data.Store',{
            remoteFilter:true,  
            model:'MyAppPickerModel',
//            autoLoad:true,
            /*fields:[
                'id',
                'nombre'
            ],*/
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
                                    main.saveNewTipoControl('Guardar');
                                }else{
                                    main.saveModifiedTipoControl('Guardar');
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
                               }
                            }
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
        main.panelGeneral = Ext.create('Ext.form.Panel',{
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
                    text:'Agregar Propiedad',
                    iconCls:'icon-add',
                    handler:function(){
                        //console.log(main.create);
                        if(main.create === true){
                            main.saveNewTipoControl('AddPropiedad');
                        }else{
                            main.saveModifiedTipoControl('AddPropiedad');
                        }                                                
                    }
                }
            ] 
        });
        
        main.chkSelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });
        
        main.rownumbererprop = new Ext.grid.RowNumberer();
        
        main.gridProperties = Ext.create('Per.GridPanel',{    
           loadOnCreate:false,
           //tbar:main.toolbarSelectProp,            
           width:'100%',
           pageSize:20,
           src:base_url+'GestionControles/GestionControlesController/GetLinkedProperties',
           split:true,           
           region:'west',
           selModel:main.chkSelModel,           
           viewConfig: {               
                plugins: {                      
                    ptype: 'gridviewdragdrop'
                }
            },
           columns:[
               main.rownumbererprop,{
                   header:'id',
                   dataIndex:'id',
                   hidden:true
               },{
                   header:'Nombre',
                   dataIndex:'nombre',
                   flex:1
               }
           ]
        });
        
        //Ext.util.Observable.capture(main.gridProperties, function(evname) {console.log(evname, arguments);})
//        Ext.util.Observable.capture(main.gridProperties.getView(), function(evname) {console.log(evname, arguments);})
        
        main.gridProperties.on({
            'itemdblclick':function(grid,record){
                //var varPropiedadId = 
                var varPropiedadId = record.get('id');
                main.AbrirVentanaPropiedad('Modificar Propiedad',main.internal.id,varPropiedadId);
            }
        });                           
        
        
        //@properties end
        //@events
        main.tbarEventsSel = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar Evento',
                   iconCls:'icon-add',
                   handler:function(){                           
                       //console.log('AddEvent');
                       if(main.create === true){                           
                           main.saveNewTipoControl('AddEvento');
                       }else{                           
                           main.saveModifiedTipoControl('AddEvento');
                       }
//                       main.addRowEvent();        
                       
                   }
               }
           ] 
        });
        
        main.chkEvent = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });
        
        main.rownumberereve = new Ext.grid.RowNumberer({
            header:'Fila',
            width:35    
        });
        
        main.gridEvents = Ext.create('Per.GridPanel',{
            //tbar:main.tbarEventsSel,
            loadOnCreate:false,
            selModel:main.chkEvent,
            src:base_url+'GestionControles/GestionControlesController/GetLinkedEvents',
            width:350,
            region:'center',
            pageSize:20,         
            columns:[
                {
                    xtype:'rownumberer',
                    renderer: function (v, p, record, rowIndex) {
                             //if (this.rowspan) {
                             //    p.cellAttr = 'rowspan="' + this.rowspan + '"';
                             //}
                             return rowIndex + 1;
                 }
                },
                {
                    header:'Id',
                    dataIndex:'id',
                    hidden:true
                },{
                    header:'Nombre',
                    dataIndex:'nombre',
                    flex:1,
                   editor:{
                       xtype:'textfield'
                   }
                }
            ],
            plugins:[
               Ext.create('Ext.grid.plugin.CellEditing',{clicksToEdit:1, pluginId: 'cellediting'})
            ]
        });
        //@events end
        main.gridEvents.on('edit', function(editor, e) {
//            // commit the changes right after editing finished
//            e.record.commit();            
            main.AgregarEvento(e.value);
        });
        
        var myStoreEvent = main.gridEvents.getStore();
        myStoreEvent.on({
            'load':function(){
                if(main.pendingAddEvent === true){
                    main.addRowEvent();
                }
            }
        });
        
//        main.gridEvents.on('load',function(){
//            console.log('load');
//           
//        });
//        
        
        main.tabPanel = Ext.create('Ext.tab.Panel',{
            width:400,
            height:400,
            region:'center',
            items:[{
                    title:'Propiedades',
                    xtype:'panel',
                    layout:'border',                    
                    tbar:main.toolbarSelectProp,
                    items:[                        
                        main.gridProperties/*,
                        main.gridProperties*/
                    ]
                   }                
                    ,{
                    title:'Eventos',
                    xtype:'panel',
                    layout:'border',
                    tbar:main.tbarEventsSel,
                    items:[
                        main.gridEvents
                    ]                
                }]
        });
        
        //end @section
        
        Ext.apply(this,{
            width: 900, 
            height: 600,
            layout:'border',
            defaultFocus:main.txtTecnologia,
            items:[
                main.panelGeneral,
                main.tabPanel
            ],
            listeners:{
                'afterrender':function(){
                    main.loadForm();
                }
            }
        });
        
        //After all definition load parameters
        if(main.create == false){               
            main.gridProperties.load({                  
                   ControlId:main.internal.id                   
            });
            main.gridEvents.load({
                ControlId:main.internal.id
            });      
            
        }
        
   
        
         this.callParent(arguments);
    },
    resetToNew:function(){
        var main = this;
        main.txtNombre.setValue('');
    },
    saveNewTipoControl:function(type){
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
                //setting the data
                //console.log(msg.data.extradata.ControlId);                                
                main.fireEvent('saved');
                if(msg.data.success == true){
                    main.internal.id = msg.data.extradata.ControlId     
                    main.create = false;
                    
                    if(type == 'AddEvento' ){
                        main.addRowEvent(); 
                    }
                    
                    if(type == 'AddPropiedad'){
                        main.getPropiedades();       
                        main.AbrirVentanaPropiedad('Agregar Propiedad',main.internal.id);
                    }
                    
                    if(type == 'Guardar'){
                        msg.success();                           
                    }
                }else{
                    //El metodo debe ser show
                    msg.success();
                }                                
            }
        });
    },
    saveModifiedTipoControl:function(type){
        var main = this;        
        
        Ext.Ajax.request({
            url:base_url+'GestionControles/GestionControlesController/update',
            params:{
                nombre: main.txtNombre.getValue(),                               
                id: main.internal.id,
                TecnologiaId: main.txtTecnologia.getValue()
            },
            success:function(response){                                                     
                var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                main.fireEvent('saved');   
                
                if(msg.data.success == true){
            //        main.internal.id = msg.data.extradata.ControlId     
                    main.create = false;
                    
                    if(type == 'AddEvento' ){
                        main.addRowEvent(); 
                    }
                    
                    if(type == 'AddPropiedad'){
                        main.getPropiedades();       
                        main.AbrirVentanaPropiedad('Agregar Propiedad',main.internal.id);
                    }
                    
                    if(type == 'Guardar'){
                        msg.success();                           
                    }
                }else{
                    //El metodo debe ser show
                    msg.success();
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
    AbrirVentanaPropiedad:function(title,ControlId,PropiedadId){
        var main = this;
        
        var myWin = new MyApp.GestionControles.WinMantPropiedades({
            title:title,
            internal:{
                id:PropiedadId,
                ControlId:ControlId
            }
        });
        
        myWin.on({
           'saved':function(){                              
               main.getPropiedades();
           }
        });
        myWin.show();
    },
    getPropiedades:function(){
        var main = this;
        
        main.gridProperties.load({
           ControlId:  main.internal.id,
           Nombre:''
        });
    },
    getEventos:function(){
        var main = this;
        
        main.gridEvents.load({
           ControlId:  main.internal.id,
           Nombre:''
        });
    },
    addRowEvent:function(){
        var main = this; 
      
        var myEvento = Ext.create('Evento',{
           id:null,
           nombre:null 
        });
        
        var myStore = main.gridEvents.getStore();
         if(myStore.isLoading() == false){
             myStore.insert(0,myEvento);
       
        
            var myEditing = main.gridEvents.getPlugin('cellediting');        
             myEditing.startEdit(myEvento,2);  

            var mySelModel = main.gridEvents.getSelectionModel();
            mySelModel.deselectAll();
            main.gridEvents.getView().refresh(); 
            main.pendingAddEvent = false;
         }else{
             main.pendingAddEvent = true;
         }                               
    },
    AgregarEvento:function(nombre){        
        var main = this;        
//        main.showSavingEvent = new Ext.LoadMask(main.tabPanel, {msg:"Guardando..."});
//        main.showSavingEvent.show();
        Ext.Ajax.request({
            url:base_url+'GestionControles/AddLinkedEvent/Add',
           params:{     
               ControlId:main.internal.id,
               Nombre:nombre
           },
           success:function(response){
               var msg = new Per.MessageBox();  
               msg.data = Ext.decode(response.responseText); 
               main.getEventos();
                              
           }
        });      
    },
    loadForm:function(){
        var main = this;
        main.panelGeneral.load({
            url:base_url+'GestionControles/GestionControlesController/find',
            params:{
                id: main.internal.id
            },
            success:function(form,action){                
                var data = Ext.decode(action.response.responseText);
                main.txtNombre.setValue(data.data.nombre);
                   
                var varTecnologia = Ext.create('MyAppPickerModel',{
                   id:data.data.tecnologia.id,
                   nombre:data.data.tecnologia.nombre
                });                
                main.txtTecnologia.setValue(varTecnologia);                
                //Cargar propiedades
                main.getPropiedades();
            }
        });                     
    }
});