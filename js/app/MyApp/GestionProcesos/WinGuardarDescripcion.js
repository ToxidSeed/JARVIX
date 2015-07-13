Ext.define('MyApp.GestionProcesos.WinGuardarDescripcion',{
	extend:'Ext.window.Window' , 
	title:'Descripcion',	 
	internal:{
		id:null,
		procesoFlujoId:null,
		numeroFlujo:null,
		tipoFlujo:{
			id:null
		},
		numeroPaso:null,
		pasoFlujoReferenciaId:null,
                descripcion:null    
	},
        actions:{
            AddStep:false,
            AddAlternativeWorkFlow:false,
            AddExceptionWorkFlow:false,
            Update:false,
            InsertStep:false
            
        },        
	listeners:{
		  'deactivate':function(){
          	   this.close();
          }
	},
	initComponent:function(){
                
		

		var main = this;



		main.toolgen = Ext.create('Ext.toolbar.Toolbar',{
			items:[
				{
					text:'Aceptar',
                                        iconCls:'icon-accept',
					handler:function(){
                                            
                                            if(main.actions.AddStep != undefined && main.actions.AddStep === true){
                                                main.AddStep();
                                            }
                                            if(main.actions.AddAlternativeWorkFlow != undefined && main.actions.AddAlternativeWorkFlow === true){
                                                main.AddAlternativeWorkFlow();
                                            }
                                            if(main.actions.AddExceptionWorkFlow != undefined && main.actions.AddExceptionWorkFlow === true){
                                                main.AddExceptionWorkFlow();
                                            }
                                            if(main.actions.InsertStep != undefined && main.actions.InsertStep == true){                                                
                                                main.InsertStep();
                                            }
                                            if(main.actions.Update != undefined && main.actions.Update == true){                                                
                                                main.Update();
                                            }
					}
				},{
					text:'Salir',
                                        iconCls:'icon-door-out',
					handler:function(){
						main.close();
					}
				}
			]	
		});

		main.txtPaso = Ext.create('Ext.form.field.Text',{
			fieldLabel:'Paso'
		});

		main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
			fieldLabel:'Descripcion',
                        hideLabel:true,
                        width:1,
                        heiht:1
		});

//		main.general = Ext.create('Ext.panel.Panel',{  
//                   bodyPadding:'0 0 0 0',
//                   frame:true,
//                   border:false,
//                   items:[
//                       //main.txtPaso,
//                       main.txtDescripcion
//                   ] 
//                 });



                Ext.apply(this,{
                  //tbar:main.toolgen,
                  defaultFocus:main.txtDescripcion,  
                  width:500,
                  border:false,
                  height:200,       
                          layout:'border',
                          items:[
                              main.txtDescripcion
                          ],
                  buttons:[
                      {
                          text:'Aceptar',
                          iconCls:'icon-accept',
                          handler:function(){
                              main.save();
                          }
                      },{
                          text:'Salir',
                          iconCls:'icon-door-out',
                          handler:function(){
                              main.close();
                          }
                      }
                  ],
                  listeners:{
                      'resize':function(win,w,h){
                          main.resizeComponents(win,w,h);
                      }
                  }
                });

		this.callParent(arguments);
                main.LoadInitialValues();
	},
        resizeComponents:function(win,w,h){
            var main = this;
            main.txtDescripcion.setWidth(w);
            main.txtDescripcion.setHeight(h-60);
        },
	saveNew:function(url){
		var main = this;

          Ext.Ajax.request({
          url:base_url+url,
          params:{
              ProcesoFlujoId: main.internal.procesoFlujoId,
              Descripcion:main.txtDescripcion.getValue(),
              NumeroFlujo: main.internal.numeroFlujo,
              TipoFlujo:main.internal.tipoFlujo.id,
              NumeroPaso:main.internal.numeroPaso,
              PasoFlujoReferenciaId:main.internal.pasoFlujoReferenciaId	
          },
          success:function(response){
              var msg = new Per.MessageBox();  
              msg.data = Ext.decode(response.responseText); 
              if(msg.data.success === false){
				msg.success();              	  
              }
              main.internal.id = msg.data.extradata.PasoFlujoId
              //Se Cerrara la ventana para cuando sea success or failure
              main.close();
          }
       });
	},
        saveModified:function(url){
            var main = this;

		Ext.Ajax.request({
          url:base_url+url,
          params:{
              PasoFlujoId:main.internal.id,
              Descripcion:main.txtDescripcion.getValue()
          },
          success:function(response){
              var msg = Ext.decode(response.responseText);                                   
              main.close();
          }
          });
        },
       AddAlternativeWorkFlow:function(){
           var main = this;
           var url = 'GestionProcesos/AddPasoFlujoAlternativo/Add';
           main.saveNew(url);
       },
       AddExceptionWorkFlow:function(){
           var main = this;
           var url = 'GestionProcesos/AddPasoFlujoException/Add';
           main.saveNew(url);
       },
       AddStep:function(){
           var main = this;
           var url = 'GestionProcesos/AddPasoFlujo/Add';
           main.saveNew(url);
       },
       InsertStep:function(){
            var main = this;
            var url = 'GestionProcesos/InsertPasoFlujo/Insert';
            main.saveNew(url);
       },
       Update:function(){
           
           var main = this;
           var url = 'GestionProcesos/UpdatePasoFlujo/Update';
           main.saveModified(url);
       },
       LoadInitialValues:function(){
           var main = this;           
           main.txtDescripcion.setValue(main.internal.descripcion);
       },
       save:function(){
           var main = this;
           if(main.actions.AddStep != undefined && main.actions.AddStep === true){
                main.AddStep();
            }
            if(main.actions.AddAlternativeWorkFlow != undefined && main.actions.AddAlternativeWorkFlow === true){
                main.AddAlternativeWorkFlow();
            }
            if(main.actions.AddExceptionWorkFlow != undefined && main.actions.AddExceptionWorkFlow === true){
                main.AddExceptionWorkFlow();
            }
            if(main.actions.InsertStep != undefined && main.actions.InsertStep == true){                                                
                main.InsertStep();
            }
            if(main.actions.Update != undefined && main.actions.Update == true){                                                
                main.Update();
            }
       }
});
