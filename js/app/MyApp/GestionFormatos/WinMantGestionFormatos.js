/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionFormatos.WinMantGestionFormatos',{
   extend:'Ext.window.Window',
   create:true,
   id:null,
   width:500,
   height:150,
   modal:true,
   frame:false,
   internal:{
       id:null
   },
   initComponent:function(){
       var main = this;
       
       main.tbar = Ext.create('Ext.toolbar.Toolbar');
       
       //Falta que llame a la opcion de un nuevo registro
       main.btnNuevo = {
           text:'Nuevo',
           handler:function(){
               
           }
       };
       
       main.btnSave = {
           text:'Guardar',
           handler:function(){
               if(main.internal.id === null){
                   main.saveNew();
               }else{
                   main.saveChanges();
               }               
           }
       };
       
       
       main.btnCancelar = {
           text:'Cancelar'
       };
       
       main.tbar.add(main.btnNuevo);
       main.tbar.add(main.btnSave);
       main.tbar.add(main.btnCancelar);
       
       main.txtTipoDato = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Tipo de Dato'
       });
       
  
       
       main.chkGroupConfig = Ext.create('Ext.form.CheckboxGroup',{          
          fieldLabel: 'Configuracion',
          vertical: true,      
          columns: 1,
          items:[
              {boxLabel:'Permite Tamano',id:'flgPermiteTamano',inputValue:'1'},
              {boxLabel:'Permite Precision',id:'flgPermitePrecision',inputValue:'1'},
              {boxLabel:'Permite Mascara',id:'flgPermiteMascara',inputValue:'1'},
              {boxLabel:'Permite Mayusculas',id:'flgPermiteMayusculas',inputValue:'1'},
              {boxLabel:'Permite Minusculas',id:'flgPermiteMinusculas',inputValue:'1'},
              {boxLabel:'Permite Detalle',id:'flgPermiteDetalle',inputValue:'1'}              
          ] 
       });
       
       main.txtFechaRegistro = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Fecha de Registro',
          disabled:true
       });
       
       main.txtEstado = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Estado',
          disabled:true
       });
       
       main.panelGeneral = Ext.create('Ext.panel.Panel',{          
           bodyPadding:'10px', 
           height:350,
           items:[
               main.txtTipoDato,
               main.chkGroupConfig,
               main.txtFechaRegistro,
               main.txtEstado
           ]
       });
       
       Ext.apply(this,{
          frame:true,
          tbar:main.tbar,
          width:600,
          height:350,
          items:[
              main.panelGeneral
          ]
       });  
       
       
       
       
       //Modificando el titulo cuando ya se han creado los objetos
       if(main.internal.id === null){
           main.title = 'Registro de un Nuevo Formato';
       }else{
           main.loadModifiedConfig();
       }

       this.callParent(arguments);
   },
   saveNew:function(){
       var main = this;                    
       
       var flgPermiteTamano = 0;
       var flgPermitePrecision = 0;
       var flgPermiteMascara = 0;
       var flgPermiteMayusculas = 0;
       var flgPermiteMinusculas = 0;
       var flgPermiteDetalle = 0;
       
       if(Ext.getCmp('flgPermiteTamano').getValue() === true){
           flgPermiteTamano = 1;
       }       
       if(Ext.getCmp('flgPermitePrecision').getValue() === true){
           flgPermitePrecision = 1;
       }
       if(Ext.getCmp('flgPermiteMascara').getValue() === true){
           flgPermiteMascara = 1;
       }
       if(Ext.getCmp('flgPermiteMayusculas').getValue() === true){
           flgPermiteMayusculas = 1;
       }
       if(Ext.getCmp('flgPermiteMinusculas').getValue() === true){
           flgPermiteMinusculas = 1;
       }
       if(Ext.getCmp('flgPermiteDetalle').getValue() === true){
           flgPermiteDetalle = 1;
       }
       
        
       
       Ext.Ajax.request({
          url:base_url+'GestionFormatos/GestionFormatos/add',
          params:{
              TipoDato:main.txtTipoDato.getValue(),
              flgPermiteTamano: flgPermiteTamano,
              flgPermitePrecision: flgPermitePrecision,
              flgPermiteMascara: flgPermiteMascara,
              flgPermiteMayusculas: flgPermiteMayusculas,
              flgPermiteMinusculas: flgPermiteMinusculas,
              flgPermiteDetalle: flgPermiteDetalle
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
       });
   },
   loadNewConfig:function(){
       var main = this;
       main.internal.id = null;
       main.title = 'Registro de un Nuevo Formato';
       
       
   },
   loadModifiedConfig:function(){      
       var main = this;
       main.title = 'Modificar Formato';       
       Ext.Ajax.request({
          url:base_url+'GestionFormatos/GestionFormatos/find',
          params:{
              id:main.internal.id
          },
          success:function(response){
              var data = Ext.decode(response.responseText);
              main.internal.id = data.data.id;
              main.txtTipoDato.setValue(data.data.tipoDato);              
              Ext.getCmp('flgPermiteTamano').setValue(data.data.flgPermiteTamano);
              Ext.getCmp('flgPermitePrecision').setValue(data.data.flgPermitePrecision);
              Ext.getCmp('flgPermiteMascara').setValue(data.data.flgPermiteMascara);
              Ext.getCmp('flgPermiteMayusculas').setValue(data.data.flgPermiteMayusculas);
              Ext.getCmp('flgPermiteMinusculas').setValue(data.data.flgPermiteMinusculas);
              Ext.getCmp('flgPermiteDetalle').setValue(data.data.flgPermiteDetalle);
              main.txtFechaRegistro.setValue(data.data.fechaRegistro);
          }
       });
   },
   saveChanges:function(){
        var main = this;                    
       
       var flgPermiteTamano = 0;
       var flgPermitePrecision = 0;
       var flgPermiteMascara = 0;
       var flgPermiteMayusculas = 0;
       var flgPermiteMinusculas = 0;
       var flgPermiteDetalle = 0;
       
       if(Ext.getCmp('flgPermiteTamano').getValue() === true){
           flgPermiteTamano = 1;
       }       
       if(Ext.getCmp('flgPermitePrecision').getValue() === true){
           flgPermitePrecision = 1;
       }
       if(Ext.getCmp('flgPermiteMascara').getValue() === true){
           flgPermiteMascara = 1;
       }
       if(Ext.getCmp('flgPermiteMayusculas').getValue() === true){
           flgPermiteMayusculas = 1;
       }
       if(Ext.getCmp('flgPermiteMinusculas').getValue() === true){
           flgPermiteMinusculas = 1;
       }
       if(Ext.getCmp('flgPermiteDetalle').getValue() === true){
           flgPermiteDetalle = 1;
       }
       
        
       
       Ext.Ajax.request({
          url:base_url+'GestionFormatos/GestionFormatos/add',
          params:{
              id: main.internal.id,
              TipoDato:main.txtTipoDato.getValue(),
              flgPermiteTamano: flgPermiteTamano,
              flgPermitePrecision: flgPermitePrecision,
              flgPermiteMascara: flgPermiteMascara,
              flgPermiteMayusculas: flgPermiteMayusculas,
              flgPermiteMinusculas: flgPermiteMinusculas,
              flgPermiteDetalle: flgPermiteDetalle
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
       });
   }
});

