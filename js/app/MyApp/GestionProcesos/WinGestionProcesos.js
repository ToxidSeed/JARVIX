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
   initComponent:function(){
       var main = this;
       
       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Nuevo',
                   handler:function(){
//                       var WinEditar = new  MyApp.GestionProcesos.WinMantGestionProcesos();
//                       WinEditar.show();
                        window.open(base_url+'GestionProcesos/GestionProcesosController/addOption');
                   }
               }
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
                 handler:function(){
                     
//                     main.GridPropiedades.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 handler:function(){
                     main.limpiarCriterios();
                 }
             }
         ] 
      });
      
      main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{          
          region:'west', 
          bodyPadding:'10px',
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
                 dataIndex:'nombre'
             },{
                 header:'Fecha de Registro',
                 dataIndex:'fechaRegistro'
             },{
                 header:'Fecha de Actualizacion',
                 dataIndex:'FechaActualizacion'
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
      })
      
      Ext.apply(this,{
            layout:'border',
            items:[
              main.panelCriterioBusqueda,
              main.Grid
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

