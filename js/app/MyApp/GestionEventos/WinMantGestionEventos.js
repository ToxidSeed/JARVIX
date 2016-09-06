/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEventos.WinMantGestionEventos',{
    extend:'Ext.window.Window',    
    create:true, //parametro que utilizamos para determinar si es un nuevo registro un la edicion de uno ya existente
    Id:null,
    width:500,
    height:150,
    modal:true,
    frame:false,
    constructor:function(parameter){
        var main = this;
        
        if(parameter != undefined){
            if(parameter.id != null && parameter.create == false){
                Ext.MessageBox.show({
                    title:'Titulo',
                    msg:'Obteniendo Datos',
                    icon:Ext.MessageBox.INFO,
                    progress:true
                })
                
                //Loading Data
                
                Ext.Ajax.request({
                   url:base_url+'GestionEventos/GestionEventosController/find' ,
                   params:{
                       id:parameter.id
                   },
                   success:function(response){         
                        Ext.MessageBox.close();
                        var data = Ext.decode(response.responseText);
                        main.txtNombre.setValue(data.data.nombre);
                        main.dtFechaRegistro.setValue(data.data.fechaRegistro);
                        main.dtFechaUltAct.setValue(data.data.fechaUltAct);
                        main.txtEstado.setValue(data.data.estado.nombre);
                    },
                    failure:function(){
                        Ext.MessageBox.close();
                    }
                });
            }
        }
        
        this.callParent(arguments);
    },
    initComponent:function(){
        var main = this;
        
        console.log(main.id);
        if(main.Id == 0){
            main.title = 'Nuevo Evento';
        }else{
            main.title = 'Modificar Evento';
        }
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre',
           width:350
        });
        
        main.dtFechaRegistro = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Registro' ,
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
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar');
        main.btnGuardar = {
                            text:'Guardar',
                            iconCls:'icon-disk',
                            handler:function(){
                            if(main.create == true){
                                main.saveNewEvento();
                            }else{
                                main.saveModifiedEvento();
                            }
                           }}
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
        
        main.btnCancelar = {
            text:'Cancelar',
            iconCls:'icon-door-out',
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
        
        Ext.apply(this,{
            width:400,
            height:250,
            bodyPadding:'10px',
           items:[
               main.txtNombre,
               main.dtFechaRegistro,
               main.dtFechaUltAct,
               main.txtEstado               
           ] 
        });
        
        this.callParent(arguments);
    },
    saveNewEvento:function(){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'GestionEventos/GestionEventosController/add',
            params:{
                nombre: main.txtNombre.getValue()                               
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
    },
    saveModifiedEvento:function(){
        var main = this;
        Ext.Ajax.request({
           url:base_url+'GestionEventos/GestionEventosController/update' ,
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
    resetToNew:function(){
        var main = this;        
    }    
})


