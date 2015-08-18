/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.Tecnologias.WinMantTecnologias',{
   extend:'Per.MainWindow',
   create:true,
       id:null,
    width:500,
    height:150,
    modal:true,
    frame:false,
    internal:{},
    initComponent:function(){
        var main = this;
        
        console.log(main.internal);
        
        if(main.create === true){
            main.title = 'Nueva Tecnologia';
        }else{
            main.title = 'Modificar Tecnologia';
        }
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre' ,
           width:300
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
        main.btnGuardar = {text:'Guardar',
                            iconCls:'icon-disk',
                            handler:function(){                            
                                if(main.create === true){
                                    main.saveNew();
                                }else{
                                    main.saveModified();
                                }
                           }}
         main.tbar.add(main.btnGuardar);
         main.btnInactivar = {
                            text:'Inactivar',
                            handler:function(){
                            if(main.create == false){
                                main.suspend();
                            }
                           }}
        if(main.create === false){
            main.tbar.add(main.btnInactivar);
        }
        
        main.btnCancelar = {
            text:'Salir',
            iconCls:'icon-door-out',
            handler:function(){
                main.close();
            }
        }
        main.tbar.add(main.btnCancelar);
        
        //Hide Controls when New
        if(main.create === true){
            main.dtFechaUltAct.hide();
            main.txtEstado.hide();
        }
        
        main.mainPanel = Ext.create('Ext.panel.Panel',{
           bodyPadding:'10px', 
           height:300,
           items:[
               main.txtNombre,
               main.dtFechaRegistro,
               main.dtFechaUltAct,
               main.txtEstado               
           ]
        });
        
        //Load property Values
        main.loadRegistry();
        
        
        Ext.apply(this,{
            width:400, 
            height:250,            
            defaultFocus:main.txtNombre,
           items:[
               main.mainPanel
           ] 
        });
        this.callParent(arguments);
    },
    saveNew:function(){
        var main = this;
        Ext.Ajax.request({
            url:base_url+'Tecnologias/Tecnologias/add',
            params:{
                Nombre: main.txtNombre.getValue()                               
            },
            success:function(response){                                                                              
                main.processSuccessful();
                main.cleanFields();
                var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();    
            }
        });
    },
    saveModified:function(){
        var main = this;
        
        Ext.Ajax.request({
           url:base_url+'Tecnologias/Tecnologias/update' ,
           params:{
               id:main.internal.id,
               nombre:main.txtNombre.getValue()
           },
           success:function(response){
               main.processSuccessful();
               var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                msg.success();                    
           }
        });
    },
    suspend:function(){
        var main = this;
    },
    cleanFields:function(){
        var main = this;
        main.txtNombre.setValue('');
    },
    loadRegistry:function(){
        var main = this;
        Ext.Ajax.request({
           url:base_url+'Tecnologias/Tecnologias/find' ,
           params:{
               id:main.internal.id               
           },
           success:function(response){
               var response = Ext.decode(response.responseText);               
               main.txtNombre.setValue(response.data.nombre);
               main.internal.id = response.data.id;
           }
        });
    }
});


