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
        id:null,
        ControlId:null
    },
    initComponent:function(){
        var main = this;
        
        //console.log(main.internal);
        
        Ext.define('valor', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'valor'}
            ]
        });
        
        main.tbarMain = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Guardar',
                   iconCls:'icon-disk',
                   handler:function(){
                       main.Guardar();
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
                   iconCls:'icon-delete',
                   handler:function(){
                       main.quitar();
                   }
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
        
         main.chkSelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        })
        
        
        main.gridTablas = Ext.create('Per.GridPanel',{            
           loadOnCreate:false,           
           width:'100%',
           height:170,
           border:false,
           src: base_url+'GestionPropiedades/GestionPropiedadesController/getValores',
           selModel:main.chkSelModel,
           columns:[
               {
                   xtype:'rownumberer'
               },{
                  header:'id',
                  dataIndex:'id',
                  hidden:true
               },{
                   header:'valor',
                   dataIndex:'valor',
                   flex:1,
                   editor:{
                       xtype:'textfield'
                   }
               }               
           ],
           plugins:[
               Ext.create('Ext.grid.plugin.CellEditing',{clicksToEdit:1, pluginId: 'cellediting'})
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
            defaultFocus:main.txtNombre,
           items:[
               main.panelPrincipal,
                main.panelGrid
           ],
           listeners:{
               'show':function(){
                   if (main.internal.id != 'undefined' && main.internal.id > 0  ){
                        //load data
                        main.getPropiedad();
                        main.getValores();
                    }
               }
           }
        });
        
        
        
        this.callParent(arguments);
    },
    AddValorFila:function(){
        var main = this;        
        var myValor = Ext.create('valor',{
           valor:null 
        });        
        var myStore = main.gridTablas.getStore();
        var myModelAdded = myStore.add(myValor);        
        var myEditing = main.gridTablas.getPlugin('cellediting');        
        var edit = myEditing.startEdit(myValor,2);                        
    },
    Guardar:function(){
        var main = this;
        
         var myStore = main.gridTablas.getStore();
        var myRecords = myStore.getRange();        
        var myValores = Per.Store.getDataAsJSON(myRecords);
        
        console.log(myValores);
        
        Ext.Ajax.request({
           url:base_url+'GestionPropiedades/GestionPropiedadesController/add',
           params:{
                ControlId:main.internal.ControlId,
                Nombre:main.txtNombre.getValue(),
                Descripcion: main.txtDescripcion.getValue(),
                Valores:myValores
           },
           success:function(response){
               var data = Ext.decode(response.responseText);
               //console.log(data);
               if(data.success == true && data.code == 0){
                   main.fireEvent('saved');
                   main.close();
               }
               //console.log(data);
           }           
        });
    },
    getPropiedad:function(){
        var main = this;
        
        Ext.Ajax.request({
           url:base_url+'GestionPropiedades/GestionPropiedadesController/find',
           params:{
               PropiedadId:main.internal.id
           },
           success:function(response){
               var decode = Ext.decode(response.responseText);
               main.internal.id = decode.data.id;
               main.txtNombre.setValue(decode.data.nombre);               
           }           
        });        
    },
    getValores:function(){
        var main = this;
        main.gridTablas.load({
            PropiedadId:main.internal.id
        });
    },
    quitar:function(){
        var main = this;
        var mySelModel = main.gridTablas.getSelectionModel();
        var myStore = main.gridTablas.getStore();
        var records = mySelModel.getSelection();
        myStore.remove(records);
    }
});

