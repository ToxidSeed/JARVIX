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
    initComponent:function(){
        var main = this;             
        
        main.myTextAreaEditor = Ext.create('Ext.form.field.TextArea',{
            width:350,
            height:150
        });
        main.myWinEditor = Ext.create('Ext.window.Window',{
             width:350,
             height:200,  
             closeAction:'hide',
             closable:false,
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
                         main.addValor(main.myWinEditor.params);
                     }
                 },
                 {
                     text:'Cancelar',
                     handler:function(){
                         main.myWinEditor.close();
                     }
                 }
             ]
        });
        
        
        
//        Ext.util.Observable.capture(myWinEditor, function(evname) {console.log(evname, arguments);})
        main.myWinEditor.on({
            'deactivate':function(){
                main.myWinEditor.close();
            }
        });
             
        
        
        main.mainTbar =  Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Guardar',
                    id:'btnGuardarId',
                    iconCls:'icon-disk',
                    handler:function(){
                        main.save();
//                        console.log(main.txtTipoControl.getHeight());
//                            console.log('xxx');
//                            main.txtTipoControl.expand();
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
        
        main.gridPropiedades = Ext.create('Per.GridPanel',{         
         border:false,                      
         loadOnCreate:false,
         width:350,
         height:400,
         pageSize:20,         
         src:base_url+'/GestionProcesos/ProcesoControl/getPropiedades',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Nombre',
                 dataIndex:'propiedad.nombre'
             },{
                 header:'Valor',
                 dataIndex:'valor',
                 flex:1
             },{
                 header:'PropiedadId',
                 dataIndex:'propiedad.id',
                 hidden:true
             },{
                 header:'ControlPropiedad',
                 dataIndex:'controlPropiedad.id',
                 hidden:true
             }             
         ],
         pagingBar:true
      });
      
      main.gridPropiedades.on({
         'itemdblclick':function(grid,record,item,index,event){
             var propiedadName = record.get('propiedad.nombre');             
             main.myWinEditor.setTitle(propiedadName);     
             main.myTextAreaEditor.setValue(record.get('valor'));
             main.myWinEditor.params = {
                 method:'propiedad',
                 data:{
                     id:record.get('id'),
                     propiedadId:record.get('propiedad.id'),
                     controlId: main.internal.Control.id,
                     ControlPropiedadId:record.get('controlPropiedad.id')
                 }
             };
             main.myWinEditor.showAt(event.getX(),event.getY());
         } 
      });
      
      main.gridEventos = Ext.create('Per.GridPanel',{         
         border:false,                      
         loadOnCreate:false,
         width:350,
         height:400,
         pageSize:20,         
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
         ],
         pagingBar:true
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
                    Ext.getCmp('btnGuardarId').disable();
                }
            }
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
                main.myWinEditor.close();
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
                    }
                },{
                    text:'Ocultar',
                    iconCls:'icon-collapse',
                    handler:function(){
                        
                    }
                }
            ]
        });
        
        main.txtPropiedad = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Propiedad' 
        });
        
        main.gridPropiedades = Ext.create('Ext.grid.property.Grid', {
            title: 'Properties Grid',
            width: 300,
            renderTo: Ext.getBody(),
            source: {
                "(name)": "My Object",
                "Created": Ext.Date.parse('10/15/2006', 'm/d/Y'),
                "Available": false,
                "Version": .01,
                "Description": "A test object"
            }
        });
        
        main.panelSearchPropiedades = Ext.create('Ext.form.Panel',{
              title:'Buscar Propiedades',    
               bodyPadding:'10px',  
               region:'west',
              hidden:true,
              tbar:main.tbarSearchPropiedades,
              items:[
                  main.txtPropiedad,
                  main.gridPropiedades
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
                main.gridPropiedades.setHeight(newh-90);
                main.gridEventos.setHeight(newh-90);
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
        
        main.gridPropiedades.load(params);
    },
    getEventos:function(){
        var main = this;
        
        var params = {
            ControlId:main.internal.Control.id,
            ProcesoControlId:main.internal.ProcesoControl.id
        };
        
        main.gridEventos.load(params)
                
    },
    save:function(){
        var main = this;
        var msg = true;
        if (main.internal.ProcesoControl.id == null) {
            main.saveNew(msg);
        } 
        if (main.internal.ProcesoControl.id != null) {
            main.modify(msg);
        }
        
    },
    loadControl:function(){
        var main = this;
        if (main.internal.ProcesoControl.id != null){
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
    addValor:function(params){
        var main = this;
          if (params.method === 'propiedad'){
              main.addValorPropiedad(params);
          }
          if (params.method === 'evento'){
              main.addValorEvento(params);
          }
    },
    addValorPropiedad:function(params){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionProcesos/ProcesoControl/writePropiedad',
            params:{
                ProcesoControlPropiedadId: params.data.id,
                ControlId: params.data.controlId,
                PropiedadId: params.data.propiedadId,
                ProcesoControlId:main.internal.ProcesoControl.id,
                Valor: main.myTextAreaEditor.getValue(),
                ControlPropiedadId: params.data.ControlPropiedadId
            },
            success:function(response){      
                main.myWinEditor.close();
                main.txtTipoControl.disabled = true;
                //main.winHelper = Ext.create('Per.DebugHelperWindow');
                //main.winHelper.showMsg(response.responseText);
                
//                console.log(response);
                //Loading Properties
                main.getPropiedades();
            }
        });
    },
    addValorEvento:function(params){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionProcesos/ProcesoControl/writeEvento',
            params:{
                ProcesoControlEventoId:params.data.id,
                ControlId: params.data.controlId,
                EventoId: params.data.eventoId,
                ProcesoControlId: main.internal.ProcesoControl.id,
                Valor: main.myTextAreaEditor.getValue(),
                ControlEventoId: params.data.ControlEventoId
            },
            success:function(response){
                main.myWinEditor.close();                
                main.getEventos();
            }
        });
        
    },
    winEditorClose:function(){
        var main = this;
        main.myWinEditor.close();
    },
    getPropiedadesSeleccionar:function(){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionProcesos/ProcesoControl/getPropiedadesActivas',
            params:{
                nombre:main.txtPropiedad.getValue()
            },
            success:function(response){
                var data = Ext.decode(response.responseText);
                console.log(data);
            }
        });
    }
});