/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEditEntrega',{
   extend:'Ext.window.Window',
   create:true,
   internal:{
       id:null
   },
   width:500,
   height:150,
   modal:true,
   initComponent:function(){
       var main = this;
       
       if (main.create === true){
           main.title = 'Nuevo';
       }else{
           main.title = 'Modificar';
       }
   
       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
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
       
       main.storePicker = new Ext.create('Ext.data.Store',{
            remoteFilter:true,  
            fields:[
                'id',
                'nombre'
            ],
            proxy:{
               type:'ajax',
               //url: base_url+'Comunes_Control/ControlEstado/getControlesActivos',
               reader:{
                   type:'json',
                   root:'results',
                   totalProperty:'total'
               }
           }
       });
       
        main.txtProyecto = Ext.create('Ext.form.ComboBox',{
            fieldLabel: 'Proyecto',
            store: main.storePicker,
            typeAhead:true,
            queryMode: 'remote',
            queryParam:'Nombre',
            displayField: 'nombre',
            enableKeyEvents:true,
            minChars:1,
            hideTrigger:true,
            valueField: 'id',
            width:350
        });
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre'           
       });            
       
       main.dateFecha = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha'
       });
       
       main.panelGeneral = Ext.create('Ext.panel.Panel',{
          region:'west',
          bodyPadding:'10px',
          items:[
              main.txtProyecto,
              main.txtNombre,
              main.dateFecha
          ] 
       });   
       
       main.tbarListAlcance = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Agregar',
                  iconCls:'icon-add'
              },{
                  text:'Quitar',
                  iconCls:'icon-delete'
              }
          ] 
       });
       
       
       
       /*main.listAlcance = Ext.create('Per.GridPanel',{
           tbar:main.tbarListAlcance,
           title:'Procesos',
           loadOnCreate:false,
           region:'center',
            width:200,
            //height:100,
            pageSize:20,
            src:'',
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
                }
            ],
            pagingBar:true
       });*/
       
       /*main.listDetAlcance = Ext.create('Per.GridPanel',{
           title:'Detalle',
           loadOnCreate:false,           
       });*/
       
       
       
       /*main.panelAlcance = Ext.create('Ext.panel.Panel',{
           width:200,
           height:300,
           region:'center',
           items:[
               main.listAlcance               
           ]
       });*/
       
       main.TreeGridAlcance = new   MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance()
       
       Ext.apply(this,{
            width: 900, 
            height: 450,
            layout:'border',
            defaultFocus:main.txtTecnologia,
            items:[
                main.panelGeneral,
                main.TreeGridAlcance
                //main.listAlcance
                //main.panelAlcance
            ]
        });
        
        this.callParent(arguments);
   }
});