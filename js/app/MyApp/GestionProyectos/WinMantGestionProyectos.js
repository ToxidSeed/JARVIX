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
    internal:{},
    constructor:function(parameter){
        var main = this;
        
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
                HelpAplicaciones.setPosition(0,0,true);
                HelpAplicaciones.show();                
                HelpAplicaciones.on({
                    'close':function(){
                        main.txtAplicacion.setValue(HelpAplicaciones.response.nombre);
                        main.internal.AplicacionId = HelpAplicaciones.response.id;                       
                    }
                    
                })
            }
        })
        
        main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
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
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar');
        main.btnGuardar = {text:'Guardar',
                            handler:function(){
                            if(main.create == true){
                                main.saveNew();
                            }else{
                                main.saveModified();
                            }
                           }}
         main.tbar.add(main.btnGuardar);
         main.btnChangeStatus = Ext.create('Ext.button.Button',{
            text:'Inactivar',
            handler:function(){
                if(main.create == false){
                    main.ChangeStatus();
                }
            }
         });             
         
         
         main.tbar.add(main.btnChangeStatus);
                       
        if(main.create == true){
            main.btnChangeStatus.hide();
        }
        
        main.btnCancelar = {
            text:'Cancelar',
            handler:function(){
                main.close();
            }
        }
        main.tbar.add(main.btnCancelar);
        
        //Hide Controls when New
        if(main.create == true){
            main.dtFechaUltAct.hide();
            main.txtEstado.hide();
        }
        
        main.panelProyectos = Ext.create('Ext.form.Panel',{            
            bodyPadding:'10px',            
            frame:false,
            height:350,
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
        })
        
        Ext.apply(this,{
           width:500,
           height:420,   
           defaultFocus:main.txtNombre,
           items:[
             main.panelProyectos                        
           ],
           listeners:{
               'show':function(){                   
                   if(main.create === false){         
                       main.loadInitValues()
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
                var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();    
                msg.on({
                    'okButtonPressed':function(){
                        //Preparar Nuevo Registro
                        main.resetToNew();
                    }
                })

            }
        })
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
                })
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
            })
        }
    }
})

