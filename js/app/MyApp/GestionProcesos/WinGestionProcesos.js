/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProcesos.WinGestionProcesos',{
   extend:'Ext.panel.Panel' ,
   maximized:true,
   width:0,
   heigh:0,
   floating:true,
   autorender:true,
   config:{},
   initComponent:function(){
       var main = this;
       
        main.txtSetProject = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Proyecto',
            width:350
         });
         
         
         
         
         
         main.btnSetProject = {                              
                                iconCls:'icon-arrow_refresh'
                           }
       
       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   handler:function(){
//                       var WinEditar = new  MyApp.GestionProcesos.WinMantGestionProcesos();
//                       WinEditar.show();
                        window.open(base_url+'GestionProcesos/GestionProcesosController/addOption');
                   }
               },
               '-',
                main.txtSetProject,
                main.btnSetProject
                
           ]
       });
       
       main.txtCodigo = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Codigo'
      })
      
      main.txtNombre = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Nombre'
      })
                  
      main.dtFechaRegistroDesde = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Desde' ,
         format:APPDATEFORMAT
      });
      
      main.dtFechaRegistroHasta = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Hasta' ,
         format:APPDATEFORMAT
      });
      
      main.fieldFechaRegistro = Ext.create('Ext.form.FieldSet',{
         title:'Fecha de Registro' ,
         items:[
             main.dtFechaRegistroDesde,
             main.dtFechaRegistroHasta
         ]
      });
      
      main.dtFechaUltActDesde = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Desde' ,
         format:APPDATEFORMAT
      });
      main.dtFechaUltActHasta = Ext.create('Ext.form.field.Date',{
         fieldLabel:'Hasta' ,
         format:APPDATEFORMAT
      });
      
      main.fieldFechaUltAct = Ext.create('Ext.form.FieldSet',{
          title:'Fecha Ult Act',
          items:[
             main.dtFechaUltActDesde,
             main.dtFechaUltActHasta
          ]
      })
      
      main.panelCritTbar = Ext.create('Ext.toolbar.Toolbar',{
         items:[
             {
                 text:'Buscar',
                 iconCls:'icon-search',
                 handler:function(){
                     
//                     main.GridPropiedades.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 iconCls:'icon-clean',
                 handler:function(){
                     main.limpiarCriterios();
                 }
             },{
                  text:'Ocultar',
                  iconCls:'icon-collapse',
                  handler:function(){
                     
                  }
             }
         ] 
      });
      
      main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{          
          region:'west', 
          bodyPadding:'10px',
          collapsible:true,
          collapsed:true,
          title:'Criterios de Busqueda',
          tbar:main.panelCritTbar,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      })
      
      main.Grid = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Procesos',
         src:base_url+'GestionProcesos/GestionProcesosController/getList',
         columns:[
             {
                 xtype:'rownumberer'
             },
             {
                 header:'Codigo',
                 dataIndex:'id'
             },{
                 header:'Nombre',
                 dataIndex:'nombre',
                 flex:1
             },{
                 header:'Fecha de Registro',
                 dataIndex:'fechaRegistro',
                 width:150
             },{
                 header:'Fecha de Actualizacion',
                 dataIndex:'FechaActualizacion',
                 width:150
             }             
         ],
         pagingBar:true
      });
        
        main.Grid.on({
          'afterrender':function(){
              main.Grid.load(main.getParams());
          },
          'itemdblclick':function(grid,record,item){
//            var WinModificar = new MyApp.GestionProcesos.WinMantGestionProcesos({
//                            title:'Modificar Proceso',
//                            mainWindow: main,
//                            create:false,
//                            internal:{
//                                id:record.get('id')
//                            }
//            });
//            WinModificar.show();
                var url = base_url+'GestionProcesos/GestionProcesosController/updateOption/?id='+record.get('id')
                window.open(url);
          }
      });
      
        main.dispModelarRequerimientos = Ext.create('Ext.form.field.Display',{
            width:'100%',
            padding:10,
            height:'100%',
            hidden:true,            
            value:'Seleccione un Proyecto para Modelar los Requerimientos'
        });
      
      if (main.config.proyectoId != undefined) {
         main.Grid.show();
         main.dispModelarRequerimientos.hide();
       }else{
         main.Grid.hide();
         main.dispModelarRequerimientos.show();         
       }
      
      Ext.apply(this,{
            layout:'border',
            items:[
              main.panelCriterioBusqueda,
              main.Grid,
              main.dispModelarRequerimientos
            ]
            
        });
        
      this.callParent(arguments);
   },
   getParams:function(){
       var main = this;
       var object = {
           id:main.txtCodigo.getValue()
       }
       return object;
   },
   limpiarCriterios:function(){
       var main = this;
       main.txtCodigo.setValue(null);
       main.txtNombre.setValue(null);       
   }
});

