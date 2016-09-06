
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionControles.WinGestionControles',{
    extend:'Ext.panel.Panel',    
    maximized:true,    
    width:0,
    height:0,
    floating:true,
    autoRender:true,
    initComponent:function(){
        
        var principal = this;
        
        principal.tbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Nuevo',
                   iconCls:'icon-add',
                   handler:function(){
                       var winNuevo = Ext.create('MyApp.GestionControles.WinMantGestionControles');
                       winNuevo.show();
                       winNuevo.on({
                           'saved':function(){
                               principal.GridTablas.load(principal.getParams()) 
                           }
                       });
                   }
               }
           ] 
        });
        
        var tbarCriterioBusqueda = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){
                      principal.GridTablas.load(principal.getParams()) 
                   }
               },{
                   text:'Limpiar',
                   iconCls:'icon-clean',
                   handler:function(){
                       principal.limpiarCriterios();
                   }
               },{
                   text:'Ocultar',
                   iconCls:'icon-collapse',
                   handler:function(){
                       principal.panelCriteriosBusqueda.collapse();
                   }
               }
           ] 
        });
        
        principal.txtCodigo = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Codigo'
        });
        principal.txtNombre = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre'
        });
        
        principal.fechaRegistroDesde = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Desde',
           format: APPDATEFORMAT
        });
        principal.fechaRegistroHasta = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Hasta',
           format: APPDATEFORMAT
        });
        
        principal.fieldSetFechaReg = Ext.create('Ext.form.FieldSet',{
            title:'Fecha de Registro',
            items:[
                principal.fechaRegistroDesde,
                principal.fechaRegistroHasta
            ]
        })
        
        principal.fechaUltActDesde = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Desde' ,
           format: APPDATEFORMAT
        });
        principal.fechaUltActHasta = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Hasta' ,
           format: APPDATEFORMAT
        });
        
        principal.fieldSetFechaUltAct = Ext.create('Ext.form.FieldSet',{
            title:'Fecha de Ultima Actualizacion',
            items:[
                principal.fechaUltActDesde,
                principal.fechaUltActHasta
            ]
        })
        
        
        
        
        principal.panelCriteriosBusqueda = Ext.create('Ext.panel.Panel',{
            tbar:tbarCriterioBusqueda,
            bodyPadding:'10px',
            title:'Criterios de Busqueda',
            region:'west',            
            width:300,
            collapsible:true,
            collapsed:true,
            height:300,            
            split:true,
            items:[
                principal.txtCodigo,
                principal.txtNombre,
                principal.fieldSetFechaReg,
                principal.fieldSetFechaUltAct
            ]
        });
        
//        principal.bbar = Ext.create('Ext.toolbar.Paging',{
//           displayInfo:true 
//        });
        
        principal.GridTablas = Ext.create('Per.GridPanel',{
            loadOnCreate:false,
            //selModel: Ext.create("Ext.selection.CheckboxModel", { }),
            region:'center',
            width:200,
            pageSize:20,
            title:'Lista de Tablas',
            src: base_url+'GestionControles/GestionControlesController/getControles',
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'id',
                    dataIndex:'id'
                },{
                    header:'Nombre',
                    dataIndex:'nombre',
                    flex:1
                },{
                    header:'Fecha de Registro' ,
                    dataIndex:'fechaRegistro'
                },{
                    header:'Fecha de Ultima Actualizacion',
                    dataIndex:'fechaUltAct'
                }
            ],
            pagingBar:true
        });
        
        principal.GridTablas.on({
            'afterrender':function(){
               principal.GridTablas.load(principal.getParams())  
            },
            'itemdblclick':function(grid,record,item,index){                               
               var winUpdate = Ext.create('MyApp.GestionControles.WinMantGestionControles',{
                   create:false,
                   internal:{
                       id:record.get('id')
                   }                   
               });               
               winUpdate.show();
               winUpdate.on({
                    'saved':function(){
                        principal.GridTablas.load(principal.getParams()) 
                    }
                });
            }
        })
        
        Ext.apply(this,{
            layout:'border',
           items:[
               principal.panelCriteriosBusqueda,
               principal.GridTablas
           ]
        });
                
                
                
        this.callParent(arguments);
    },
    getParams:function(){
        var main = this;
        var object = {
            id:main.txtCodigo.getValue(),
            nombre: main.txtNombre.getValue(),
            fechaRegistroDesde: main.fechaRegistroDesde.getValue(),
            fechaRegistroHasta: main.fechaRegistroHasta.getValue(),
            fechaUltActDesde: main.fechaUltActDesde.getValue(),
            fechaUltActHasta:main.fechaUltActHasta.getValue()
        };
        return object;
    },
    limpiarCriterios:function(){
        var main = this;
        main.txtCodigo.setValue(null);
        main.txtNombre.setValue(null);
        main.fechaRegistroDesde.setValue(null);
        main.fechaRegistroHasta.setValue(null);
        main.fechaUltActDesde.setValue(null);
        main.fechaUltActHasta.setValue(null);
    }
})


