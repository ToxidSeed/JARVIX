/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionFormatos.WinGestionFormatos',{
   extend:'Ext.panel.Panel',
   maximized:true,
   width:0,
   height:0,
   floating :true,
   autoRender:true,
   initComponent:function(){
       var main = this;
       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Nuevo',
                  handler:function(){
                      var winNuevo = Ext.create('MyApp.GestionFormatos.WinMantGestionFormatos');
                      winNuevo.show();
                  }
              }
          ] 
       });
       
       main.txtTipoDato = Ext.create('Ext.form.field.Text',{
          fieldLabel:'Tipo de Dato' 
       });
       
        main.fechaRegistroDesde = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Desde',
           format: APPDATEFORMAT
        });
        main.fechaRegistroHasta = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Hasta',
           format: APPDATEFORMAT
        });
        
        main.fieldSetFechaReg = Ext.create('Ext.form.FieldSet',{
            title:'Fecha de Registro',
            items:[
                main.fechaRegistroDesde,
                main.fechaRegistroHasta
            ]
        });
        
        main.PanelCriteriosBusqueda = Ext.create('Ext.panel.Panel',{
            bodyPadding:'10px',
             title:'Criterios de Busqueda',
            region:'west',            
            width:300,
            collapsible:true,
            height:300,            
            split:true,
            items:[
                main.txtTipoDato,
                main.fieldSetFechaReg
            ]
        });
        
        main.GridFormatos = Ext.create('Per.GridPanel',{
           loadOnCreate:false,
           region:'center',
           width:200,
           pageSize:20,
           title:'Lista de Tablas',
           src:base_url+'GestionFormatos/GestionFormatos/GetList',
           columns:[
               {
                   xtype:'rownumberer'
               },{
                   header:'id',
                   dataIndex:'id'
               },{
                   header:'Tipo de Dato',
                   dataIndex:'tipoDato'
               },{
                   header:'Permite Tamano',
                   dataIndex:'flgPermiteTamano',
                   xtype:'checkcolumn',
                   disabled:true
               },{
                   header:'Permite Precision',
                   dataIndex:'flgPermitePrecision',
                   xtype:'checkcolumn',
                   disabled:true   
               },{
                   header:'Permite Mascara',
                   dataIndex:'flgPermiteMascara',
                   xtype:'checkcolumn',
                   disabled:true   
               },{
                   header:'Permite Mayusculas',
                   dataIndex:'flgPermiteMayusculas',
                   xtype:'checkcolumn',
                   disabled:true
               },{
                   header:'Permite Minusculas',
                   dataIndex:'flgPermiteMinusculas',
                   xtype:'checkcolumn',
                   disabled:true
               },{
                   header:'Permite Detalle',
                   dataIndex:'flgPermiteDetalle',
                   xtype:'checkcolumn',
                   disabled:true
               },{
                   header:'Fecha de Registro',
                   dataIndex:'fechaRegistro'
               },{
                   header:'Fecha de Ultima Actualizacion',
                   dataIndex:'fechaUltAct'
               }
           ],
           pagingBar:true
        });
        
        main.GridFormatos.on({
           'afterrender':function() {
               main.GridFormatos.load(main.getParams());
           },
           'itemdblclick':function(obj,record){
               var winModificar = Ext.create('MyApp.GestionFormatos.WinMantGestionFormatos',{
                   internal:{
                       id:record.get('id')
                   }
               });
               winModificar.show();
           }
        });
        
        Ext.apply(this,{
            layout:'border',
            items:[
                main.PanelCriteriosBusqueda,
                main.GridFormatos
            ]
        });
        
        this.callParent(arguments);
   },
   getParams:function(){
       var main = this;
       var object = {
           TipoDato:main.txtTipoDato.getValue(),
           fechaRegistroDesde: main.fechaRegistroDesde.getValue(),
           fechaRegistroHasta: main.fechaRegistroHasta.getValue(),
       };
       return object;
   }   
});

