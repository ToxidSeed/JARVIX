/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionControles.WinMantPropiedades',{
    extend:'Ext.window.Window',
    create:false,
    /*width:500,
    height:200,*/
    modal:true,
    autoRender:true,
    internal:{
        id:null
    },
    initComponent:function(){
        var main = this;
        
        Ext.define('Valor', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'Valor'}
            ]
        });
        
        main.tbarMain = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Guardar',
                   iconCls:'icon-disk'
               },{
                   text:'Salir',
                   iconCls:'icon-door-out',
                   handler:function(){
                       main.close();
                   }
               }
           ] 
        });
        
        main.tbarValores = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   handler:function(){
                       //add row
                       main.AddValorFila();
                   }
               },
               {
                   text:'Quitar',
                   iconCls:'icon-delete'
               } 
           ] 
        });
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre' 
        });
        
        main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
            fieldLabel:'Descripcion',
            width:350,
            height:60
        });
        
        
        
        
        main.gridTablas = Ext.create('Per.GridPanel',{            
           loadOnCreate:false,           
           width:'100%',
           height:170,
           border:false,
           src: base_url+'',
           columns:[
               {
                   xtype:'rownumberer'
               },{
                   header:'Valor',
                   dataIndex:'Valor',
                   flex:1,
                   editor:{
                       xtype:'textfield'
                   }
               }               
           ],
           plugins:[
               Ext.create('Ext.grid.plugin.CellEditing',{clicksToEdit:1})
           ]
        });
        
       
        
        main.panelPrincipal = Ext.create('Ext.panel.Panel',{
            bodyPadding:'10px',           
           //split:true,
           region:'west',
           width:'65%',
           //border:false,
           height:400,
           items:[
               main.txtNombre,
               main.txtDescripcion              
           ]
        });
        
         main.panelGrid = Ext.create('Ext.panel.Panel',{             
             tbar:main.tbarValores,
             border:false,
            region:'center',
            width:'35%',
            height:200,
            items:[
                main.gridTablas
            ]
        });
        
        Ext.apply(this,{
            tbar:main.tbarMain,
            layout:'border',
            width:600, 
            height:350,
           items:[
               main.panelPrincipal,
                main.panelGrid
           ]
        });
        this.callParent(arguments);
    },
    AddValorFila:function(){
        var main = this;
        
        var myValor = Ext.create('Valor',{
           Valor:null 
        });
        
        var myStore = main.gridTablas.getStore();
        var myModelAdded = myStore.add(myValor);
        
        var recurn = main.gridTablas.fireEvent('cellclick',{
           cellIndex:1, 
           record:myModelAdded,
           rowIndex:1
        });
        
        console.log(recurn);
    }
});

