/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionAplicaciones.WinMantGestionAplicaciones',{
   extend:'Ext.window.Window',
   create:true,
   id:null,
   width:500,
   height:150,
   modal:true,
   //frame:false, 
   EstadoId:null,
   initComponent:function(){
       var main = this;
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre',
           width:400
        });
        
        main.txtEstado = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Estado' ,
           readOnly:true
        });
        
        main.txtRutaPublicacion  = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Ruta Publicacion',
            width:450
        })
        main.txtServidor = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Servidor'
        })
        main.txtBaseDatos = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Base de Datos'
        });
        
        main.txtUsuario = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Usuario' 
        });
        
        main.txtPassword = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Password',
            inputType:'Password'
        });
        
        main.dtFechaRegistro = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Registro' ,
           disabled:true
        });
        
        main.dtFechaUltAct = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Ult. Act.',
           disabled:true
        });
        
            
      
        main.Toolbar = Ext.create('Ext.toolbar.Toolbar');
        main.btnGuardar = {
                        iconCls:'icon-disk',
                        text:'Guardar',
                            handler:function(){
                            if(main.create == true){
                                main.saveNew();
                            }else{
                                main.saveModified();
                            }
                           }}
         main.Toolbar.add(main.btnGuardar);         
         
         main.btnChangeStatus = Ext.create('Ext.button.Button',{
            text:'Inactivar',
            handler:function(){
                            if(main.create == false){
                                main.ChangeStatus();
                            }
            }
         });                 
         main.Toolbar.add(main.btnChangeStatus);
         
         if(main.create == true){
             main.btnChangeStatus.hide();
         }
                       
        //main.Toolbar.add(main.btnInactivar);                                                                         
      
        
        main.btnCancelar =   Ext.create('Ext.button.Button',{
            text:'Salir',
            iconCls:'icon-door-out',
            handler:function(){
                main.close();                            
            }
         });           
        main.Toolbar.add(main.btnCancelar);  
        
        //Hide Controls when New
        if(main.create == true){
            main.dtFechaUltAct.hide();
            main.txtEstado.hide();            
        }
        
        main.general = Ext.create('Ext.panel.Panel',{  
           bodyPadding:'10px',
           border:false,
//           width:1,
//           height:1,
//           region:'west',
          items:[
              main.txtNombre,
               main.txtEstado,
               main.txtRutaPublicacion,
               main.txtServidor,
               main.txtBaseDatos,
               main.txtUsuario,
               main.txtPassword,
               main.dtFechaRegistro,
               main.dtFechaUltAct,   
          ] 
       });
        
        Ext.apply(this,{
            width:500,
            height:330,
//            bodyPadding:'10px',                        
            tbar: main.Toolbar,
           items:[
                   main.general               
           ],
           listeners:{
               'show':function(){   
                   if(main.create == false){
                       main.loadInitValues()
                   }                    
               },
               'resize':function(win,w,h){                   
                   main.redimensionar(win,w,h);
               }
           }
           
        });
        
        this.callParent(arguments);
   },
   redimensionar:function(win,w,h){
       var main = this;         
       main.general.setHeight(h-60);
   },
   saveNew:function(){
       var main = this;
       
        Ext.Ajax.request({
            url:base_url+'GestionAplicaciones/GestionAplicacionesController/add',
            params:{
                nombre: main.txtNombre.getValue(),
                rutaPublicacion:main.txtRutaPublicacion.getValue(),
                servidor: main.txtServidor.getValue(),
                baseDatos: main.txtBaseDatos.getValue(),
                username: main.txtUsuario.getValue(),
                password : main.txtPassword.getValue()
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
                
                //La Ventana que invoca a esta ventana esta siendo pasada como parametro en el constructor, y cada vez que se presiona el 
                //boton de aceptar el grid se refresca                        
                main.mainWindow.GridAplicaciones.load(main.mainWindow.getParams());
            },
            failure:function(response){
                //Si es que falla, el grid tambien debe actualizarse
                main.mainWindow.GridAplicaciones.load(main.mainWindow.getParams());
            }
        })
       
   },
   saveModified:function(){
       var main = this;
        Ext.Ajax.request({
           url:base_url+'GestionAplicaciones/GestionAplicacionesController/update' ,
           params:{
               id:main.recordId,
               nombre:main.txtNombre.getValue()
           },
           success:function(response){
               var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();    
//                msg.on({
//                    'okButtonPressed':function(){
//                        //Preparar Nuevo Registro
//                        //main.resetToNew();
//                    }
//                })
           }
        });
   },
   ChangeStatus:function(){
        var main = this;
        
        Ext.Ajax.request({
            url:base_url+'GestionAplicaciones/GestionAplicacionesController/ChangeStatus',
            params:{
                id:main.recordId,
                nombre:main.txtNombre.getValue(),
                currentStatus: main.EstadoId
            },
            success:function(response){
               var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();    
                //Call to load init values     
                main.loadInitValues()
            }
        })
   },
    resetToNew:function(){
        var main = this;   
        main.txtNombre.setValue(null);
        main.txtRutaPublicacion.setValue(null);
        main.txtServidor.setValue(null);
        main.txtBaseDatos.setValue(null);
        main.txtUsuario.setValue(null);
        main.txtPassword.setValue(null);
    },
    loadInitValues:function(){
        var main = this;                        
        if(main.create == false && main.recordId != null){
            Ext.MessageBox.show({
                    title:'Titulo',
                    msg:'Obteniendo Datos',
                    icon:Ext.MessageBox.INFO,
                    progress:true
                })
                
                Ext.Ajax.request({
                   url:base_url+'GestionAplicaciones/GestionAplicacionesController/find' ,
                   params:{
                       id:main.recordId
                   },
                   success:function(response){         
                        Ext.MessageBox.close();
                        var data = Ext.decode(response.responseText);
                        main.txtNombre.setValue(data.data.nombre);
                        main.txtRutaPublicacion.setValue(data.data.rutaPublicacion);
                        main.txtServidor.setValue(data.data.servidor);
                        main.txtBaseDatos.setValue(data.data.baseDatos);
                        main.txtUsuario.setValue(data.data.username);
                        var dateFechaRegistro = Ext.Date.parse(data.data.fechaRegistro,APPDATEFROMDBFORMAT);                                               
                        main.dtFechaRegistro.setValue(dateFechaRegistro);
                        var dateFechaModificacion = Ext.Date.parse(data.data.fechaModificacion,APPDATEFROMDBFORMAT)                        
                        main.dtFechaUltAct.setValue(dateFechaModificacion);
                        main.txtEstado.setValue(data.data.estado.nombre);
                        main.EstadoId = data.data.estado.id;                            
                         
                        
                        /*Setting Control Values*/                        
                        if(main.EstadoId == 0){                               
                            main.btnChangeStatus.setText('Re-Activar');                                                        
                        }else{
                            main.btnChangeStatus.setText('Inactivar');                                                        
                        }                        
                                                                                                                     
                    },
                    failure:function(){
                        Ext.MessageBox.close();
                    }
                });
        }
        
         
    }
});

