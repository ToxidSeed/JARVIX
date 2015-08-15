/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionPropiedades.WinGestionPropiedades',{
    extend:'Ext.panel.Panel',
    maximized:true,
    width:0,
    height:0,
    floating:true,
    autorender:true,
    initComponent:function(){
        var main = this;
        
        main.tbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Nuevo',
                   iconCls:'icon-add',
                   handler:function(){
                       main.openMantWindow();
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
                 iconCls:'icon-search',
                 handler:function(){
                     
                     main.GridPropiedades.load(main.getParams()) 
                 }
             },{
                 text:'Limpiar',
                 iconCls:'icon-clean',
                 handler:function(){
                     main.limpiarCriterios();
                 }
             }
         ] 
      });
      
      main.panelCriterioBusqueda = Ext.create('Ext.panel.Panel',{          
          title:'Criterios de Busqueda',
          region:'west',
          bodyPadding:'10px', 
          split:true,
          collapsible:true,
          collapsed:true,
          tbar:main.panelCritTbar,
          items:[
                main.txtCodigo,
                main.txtNombre, 
                 main.fieldFechaRegistro,
                 main.fieldFechaUltAct
          ]
      })
      
      main.GridPropiedades = Ext.create('Per.GridPanel',{
         loadOnCreate:false,
         region:'center',
         width:200,
         pageSize:20,
         title:'Lista de Propiedades',
         src:base_url+'GestionPropiedades/GestionPropiedadesController/getPropiedades',
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
             }             
         ],
         pagingBar:true
      });
        
        main.GridPropiedades.on({
          'afterrender':function(){
              main.loadGridPropiedades();
          },
          'itemdblclick':function(grid,record,item){
              
              var id = record.get('id');
              
              
              main.openMantWindow(false,{
                  id:id
              });
          }
      })
        
        Ext.apply(this,{
            layout:'border',
            items:[
              main.panelCriterioBusqueda,
              main.GridPropiedades
            ]
            
        });
        
        this.callParent(arguments);
    },
    getParams:function(){
        var main = this;
        var object = {
            id:main.txtCodigo.getValue(),
            nombre: main.txtNombre.getValue(),
            fechaRegistroDesde: main.dtFechaRegistroDesde.getValue(),
            fechaRegistroHasta: main.dtFechaRegistroHasta.getValue(),
            fechaUltActDesde: main.dtFechaUltActDesde.getValue(),
            fechaUltActHasta:main.dtFechaUltActHasta.getValue()
        };
        return object;
    },
    limpiarCriterios:function(){
        var main = this;
        main.txtCodigo.setValue(null);
        main.txtNombre.setValue(null);
        main.dtFechaRegistroDesde.setValue(null);
        main.dtFechaRegistroHasta.setValue(null);
        main.dtFechaUltActDesde.setValue(null);
        main.dtFechaUltActHasta.setValue(null);
    },
    loadGridPropiedades:function(){
        var main = this;
        main.GridPropiedades.load(main.getParams());
    },
    openMantWindow:function(create,object){
        var main = this;
        
        var winCreate = true;
        var myInternal = {};
        
        if(create === true){
            winCreate = create;            
        }                      
        if(create === false){
            myInternal = object;
            winCreate  = false;            
        }
        
        var myWindow = new MyApp.GestionPropiedades.WinMantGestionPropiedades({
            create:winCreate,
            internal:myInternal
        });
        
        myWindow.show();
        myWindow.on({
            'success':function(){
                main.loadGridPropiedades();
            },
            'close':function(){
                main.loadGridPropiedades();
            }
        });
    }
})



