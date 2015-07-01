/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProyectos.WinMantGestionProyectos',{
    extend:'Ext.window.Window',
   create:true,
       id:null,
    width:500,
    height:150,
    modal:true,
    frame:false,
    internal:{
        Proyecto:{
            Id:null
        }
    },
    constructor:function(parameter){
        var main = this;
        
        //console.log(window.parent.document.getElementById('IDPanelCentral'))
        //
        //var principalTabPanel = window.parent.document.getElementById('IDPanelCentral')
        // principalTabPanel.add({
        //    xtype:'panel',
        //    id:'xxx',
        //    title:'title',
        //    border:false,
        //    frame:false,                       
        //    closable:true,
        //    layout:'border',
        //    items:[
        //        
        //    ]                       
        //})
        //principalTabPanel.setActiveTab('xxx');
        //
        //var mainParent = main.up()
        //console.log(mainParent)
        //
        //var comp = window.parent.Ext.getCmp('IDPanelCentral')
        //
        //comp.add({
        //    xtype:'panel',
        //    id:'xxx',
        //    title:'title',
        //    border:false,
        //    frame:false,                       
        //    closable:true,
        //    layout:'border',
        //    items:[
        //        
        //    ]                       
        //})
        //
        //comp.setActiveTab('xxx');
        
       
        
        if(parameter != undefined){
            if(parameter.id != null && parameter.create == false ){
                Ext.MessageBox.show({
                   title:'titulo' ,
                   msg:'Obteniendo Datos',
                   icon: Ext.MessageBox.INFO,
                   progress:true
                });
            }
        }
                
        this.callParent(arguments);
    },
    initComponent:function(){
        var main = this;
        main.txtNombre = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre',
            width:350
        });
        
        main.txtAplicacion = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Aplicacion',
            width:350
        });
        
        main.btnBuscarAplicacion = Ext.create('Ext.Button',{
            text:'...',
            handler:function(){                
                var HelpAplicaciones = new MyApp.GestionProyectos.HelpAplicaciones();                
                var btnXYPosition = main.btnBuscarAplicacion.getXY();
                //HelpAplicaciones.setPosition(0,0,true);
                HelpAplicaciones.show();
                HelpAplicaciones.setX(btnXYPosition[0]);
                HelpAplicaciones.on({
                    'close':function(){
                        main.txtAplicacion.setValue(HelpAplicaciones.response.nombre);
                        main.internal.AplicacionId = HelpAplicaciones.response.id;                       
                    }
                    
                })
            }
        })
        
        main.txtDescripcion = Ext.create('Ext.form.field.HtmlEditor',{
            fieldLabel:'Descripcion',
            width:350,
            height:200,
            anchor:'100%'
        });
        
        
        
        
        main.dtFechaRegistro = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Registro' ,
           value:new Date(),
           format:APPDATEFORMAT,
           disabled:true
        });
        
        main.dtFechaUltAct = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Ult. Act.',
           format:APPDATEFORMAT,
           disabled:true
        });
        
        main.txtEstado = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Estado',
            disabled:true
        });
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Guardar',
                    iconCls:'icon-disk',
                    handler:function(){
                    if(main.create == true){
                        main.saveNew();
                    }else{
                        main.saveModified();
                    }
                   }
                },
                '-',
                {
                    id:'IdBtnInactivar',
                    text:'Inactivar',
                    iconCls:'icon-stop',
                    handler:function(){
                        if(main.create == false){
                            main.ChangeStatus();
                        }
                    }
                },
                {
                    id:'IdBtnInactivarSep',
                    xtype:'tbseparator'
                },
                {
                    text:'Salir',
                    iconCls:'icon-door-out',
                    handler:function(){
                        main.close();
                    }
                }
                
            ]
        });
         
        
        
        
        main.panelProyectos = Ext.create('Ext.form.Panel',{            
            bodyPadding:'10px',
            region:'west',
            frame:false,
            width:500,
            border:false,                        
            bodyStyle:{
                 background:'transparent'
            },
            items:[
               main.txtNombre,
               main.txtEstado,               
               {
                   layout:'column',
                   frame:false,
                   border:false,                                           
                    bodyStyle:{
                         background:'transparent',
                         padding:'0px 0px 5px 0px'
                    },
                   items:[                    
                        main.txtAplicacion,
                        main.btnBuscarAplicacion
                   ]                                          
               },
               main.txtDescripcion,
               main.dtFechaRegistro,
               main.dtFechaUltAct
            ]
        });
        
        main.tbarParticipantes = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    id:'IdBtnTbarPAgregar',
                    text:'Agregar',
                    iconCls:'icon-add',
                    handler:function(){
                        main.openWinAddParticipantes();
                    }   
                },
                '-',
                {
                    id:'IdBtnTbarPQuitar',
                    text:'Quitar',
                    iconCls:'icon-delete'
                }
            ]
        });
        
        main.gridParticipantes =  Ext.create('Per.GridPanel',{            
            border:true,
            width:'100%',
            height:'100%',            
            hidden:true,            
            loadOnCreate:false,
            src:'',
            columns:[
                {
                    header:'Nombres y Apellidos',
                    flex:1
                }
            ]
        });
        
        main.dispParticipantes = Ext.create('Ext.form.field.Display',{
            width:'100%',
            padding:10,
            height:'100%',
            hidden:true,            
            value:'Para poder Agregar/Quitar Participantes primero se tiene que CREAR UN PROYECTO.'
        });
        
        main.panelMainData = Ext.create('Ext.form.Panel',{          
          tbar:main.tbarParticipantes,
          border:false,
          
//          bodyPadding:'10px',
          items:[
             main.gridParticipantes,
             main.dispParticipantes
          ]
      });
        
        
        main.panelInfAdicional = Ext.create('Ext.panel.Panel',{
             region:'center',
             width:500,
             //title:'Informacion de Proyecto',
             border:true,
             layout:'accordion',
             items:[
                    {
                        title:'Participantes',
                        items:[
                            main.panelMainData
                        ]
                    },{
                        title:'Requerimientos Funcionales',
                        items:[]
                    }
                    ]
        });
                     
        //Hide Controls when New
        if(main.create == true){
            /*main.dtFechaUltAct.hide();
            main.txtEstado.hide();*/
            main.showNewOptions();
        }                     
                        
        Ext.apply(this,{
           width:1000,
           height:420,
           layout:'border',
           defaultFocus:main.txtNombre,
           items:[
             main.panelProyectos,
             main.panelInfAdicional
           ],
           listeners:{
               'show':function(){                   
                   if(main.create === false){         
                       main.loadInitValues();
                   }
               }
           }
        });
        this.callParent(arguments);
    },
    saveNew:function(){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionProyectos/GestionProyectosController/add',
            params:{
                nombre: main.txtNombre.getValue(),
                descripcion:main.txtDescripcion.getValue(),
                aplicacionid: main.internal.AplicacionId
            },
            success:function(response){
                var objData = Ext.decode(response.responseText);                
                if (objData.success == true && objData.code == 0){
                    main.fireEvent('recordSaved');
                    main.showModifyOptions();

                    main.internal.Proyecto.Id = objData.extradata.ProyectoId
                    main.create = false;
                    //Obtenemos los valores Guardados
                    main.loadInitValues();
                    //Mostramos los controles para modificar
                }
                
                var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();                    

            }
        });
    },showModifyOptions:function(){
        var main = this;
          main.txtEstado.show();
          Ext.getCmp('IdBtnInactivar').show();
          Ext.getCmp('IdBtnInactivarSep').show();
          main.dispParticipantes.hide();
          main.gridParticipantes.show();
          Ext.getCmp('IdBtnTbarPAgregar').enable();
        Ext.getCmp('IdBtnTbarPQuitar').enable();
    },showNewOptions:function(){
        var main = this;
        Ext.getCmp('IdBtnInactivar').hide();
        Ext.getCmp('IdBtnInactivarSep').hide();
        Ext.getCmp('IdBtnTbarPAgregar').disable();
        Ext.getCmp('IdBtnTbarPQuitar').disable();
        main.dispParticipantes.show();
    },saveModified:function(){
        var main = this;
        
        Ext.Ajax.request({
           url:base_url+'GestionProyectos/GestionPropiedadesProyectos/update' ,
           params:{
               id:main.id,
               nombre:main.txtNombre.getValue()
           },
           success:function(response){
               var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();    
                msg.on({
                    'okButtonPressed':function(){
                        //Preparar Nuevo Registro
                        //main.resetToNew();
                    }
                });
           }
        });
    },
    ChangeStatus:function(){
        var main = this;
        
        Ext.Ajax.request({
            url:base_url+'GestionProyectos/GestionProyectosController/ChangeStatus',
            params:{
                id: main.internal.id,
                nombre: main.txtNombre.getValue(),
                currentStatus: main.internal.EstadoId                
            },
            success:function(response){
                var msg = new Per.MessageBox();
                msg.data = Ext.decode(response.responseText);
                msg.success();
                //Call to load init values
                main.loadInitValues();
            }
        })
    },
    loadInitValues:function(){
        var main = this;
        if(main.create == false && main.internal.id != null){
            Ext.MessageBox.show({
                title:'Informacion',
                msg:'Obteniendo Datos',
                icon:Ext.MessageBox.INFO,
                progress:true
            })
            
            Ext.Ajax.request({
                url:base_url+'GestionProyectos/GestionProyectosController/find',
                params:{
                    id:main.internal.id
                },
                success:function(response){
                    Ext.MessageBox.close();
                    var res = Ext.decode(response.responseText);
                    var data = res.data;
                    main.txtNombre.setValue(data.nombre);                    
                    main.txtAplicacion.setValue(data.aplicacion.nombre);
                    main.txtDescripcion.setValue(data.descripcion);
                    main.txtEstado.setValue(data.estado.nombre);
                    var dateFechaRegistro = Ext.Date.parse(data.fechaRegistro,APPDATEFROMDBFORMAT);
                    main.dtFechaRegistro.setValue(dateFechaRegistro);
                    var dateFechaModificacion = Ext.Date.parse(data.fechaModificacion,APPDATEFROMDBFORMAT);                    
                    main.dtFechaUltAct.setValue(dateFechaModificacion);
                    main.internal.EstadoId = data.estado.id
                    main.internal.id = data.id
                    
                    if(main.internal.EstadoId == 0){
                        main.btnChangeStatus.setText('Re-Activar');
                    }else{
                        main.btnChangeStatus.setText('Inactivar');
                    }
                }
            });
        }
    },
    openWinAddParticipantes:function(){
        var main = this;
        var coor = main.panelMainData.getXY();            
        
        console.log(main.internal);
        
        var myWin = Ext.create('MyApp.GestionProyectos.WinAddParticipantes');
        myWin.internal.Proyecto = main.internal.Proyecto
        var newXPosition = coor[0]- myWin.width;               
        myWin.show();
        myWin.setX(newXPosition);
    }
});