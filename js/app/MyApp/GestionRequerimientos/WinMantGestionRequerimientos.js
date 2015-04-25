/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionRequerimientos.WinMantGestionRequerimientos',{
   extend:'Ext.window.Window',
   create:true,
   width:500,
   height:380,
   modal:true,
   frame:false,
   internal:{},
   initComponent:function(){
       var main = this;
       main.txtCodigo = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Codigo'
       });
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre',
           width:350
       })
       
       main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
           fieldLabel:'Descripcion',
           width:350,
            height:200
       })
       
       main.dtFechaRegistro = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Registro'
       })
       
       main.dtFechaModificacion = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha de Modificacion' 
       });
       
       main.txtEstado = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Estado',
           disabled:true
       });
       
       main.btnGuardar = Ext.create('Ext.button.Button',{
          text:'Guardar' ,
          handler:function(){
              if(main.create == true){
                  main.saveNew();
              }else{
                  main.saveModified();
              }              
          }
       });
       main.btnChangeStatus = Ext.create('Ext.button.Button',{
          text:'Inactivar',
          handler:function(){
              if(main.create == false){
                  main.ChangeStatus();
              }
          }
       });
       
       main.btnCancelar = Ext.create('Ext.button.Button',{
          text:'Cancelar',
          handler:function(){
              main.close();
          }
       });
       
       main.toolbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              main.btnGuardar,
              main.btnChangeStatus,
              main.btnCancelar
          ] 
       });
       
       
       if(main.create == true){
           main.btnChangeStatus.hide();
       }
       
       Ext.apply(this,{
           tbar:main.toolbar,
          bodyPadding:'10px',
          items:[
              main.txtCodigo,
              main.txtEstado,
              main.txtNombre,              
              main.txtDescripcion//,
//              main.dtFechaRegistro,
//              main.dtFechaModificacion
          ],
          listeners:{
              'show':function(){
                  if(main.create == false){
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
           url:base_url+'GestionRequerimientos/GestionRequerimientosController/add',
           params:{
               nombre:main.txtNombre.getValue(),
               codigo:main.txtCodigo.getValue(),
               descripcion:main.txtDescripcion.getValue()
           },
           success:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.success();
               msg.on({
                   'okButtonPressed':function(){
                       
                   }
               })
           }
       })
   },
   saveModified:function(){
       var main = this;
       
       Ext.Ajax.request({
          url:base_url+'GestionRequerimientos/GestionRequerimientosController/update' ,
          params:{
              id:main.internal.id,
              codigo:main.txtCodigo.getValue(),
              nombre:main.txtNombre.getValue(),
              descripcion:main.txtDescripcion.getValue()
          },
          success:function(response){
              var msg = new Per.MessageBox();
              msg.data = Ext.decode(response.responseText);
              msg.success();
              msg.on({
                  'okButtonPressed':function(){
                      //Preparar Nuevo Registro
                  }
              })
          }
       });
   },   
   loadInitValues: function(){
       var main = this;
       if(main.create == false && main.internal.id != null){
           Ext.MessageBox.show({
                title:'Informacion',
                msg:'Obteniendo Datos',
                icon:Ext.MessageBox.INFO,
                progress:true
            })
            
            Ext.Ajax.request({
                url:base_url+'GestionRequerimientos/GestionRequerimientosController/find',
                params:{
                    id:main.internal.id
                },
                success:function(response){
                    Ext.MessageBox.close();
                    var res = Ext.decode(response.responseText);
                    var data = res.data;
                    main.txtCodigo.setValue(data.codigo);
                    main.txtNombre.setValue(data.nombre);
                    main.txtDescripcion.setValue(data.descripcion);
                    var dateFechaRegistro = Ext.Date.parse(data.fechaRegistro,APPDATEFROMDBFORMAT);
                    main.dtFechaRegistro.setValue(dateFechaRegistro);
                    main.txtEstado.setValue(data.estado.nombre);
                    main.internal.EstadoId = data.estado.id;
                    if(main.internal.EstadoId == 0){
                        main.btnChangeStatus.setText('Re-Activar');
                    }else{
                        main.btnChangeStatus.setText('Inactivar');
                    }
                }
            })
       }
   },
   ChangeStatus:function(){
       var main = this;
       
       Ext.Ajax.request({
           url:base_url+'GestionRequerimientos/GestionRequerimientosController/ChangeStatus',
           params:{
               id:main.internal.id,
               currentStatus: main.internal.EstadoId,
               nombre: main.txtNombre.getValue()
           },
           success:function(response){
               var msg = new Per.MessageBox();
               msg.data = Ext.decode(response.responseText);
               msg.success();
                //Call to load init values
               main.loadInitValues();
           }
       })
   }
});


