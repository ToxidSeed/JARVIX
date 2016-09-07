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
   maximized:true,
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


       main.TreeGridAlcance = Ext.create('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance');
       main.TreeGridProcesosDisp = Ext.create('MyApp.GestionEntrega.WinEditEntrega_TreeGridProcesosDisp');

       main.TreeGridAlcance.on({
         'btnAgregar_Click':function(args){
             //Show and hide panels
             main.MostrarProcesos();

             //Load stores
             //main.TreeGridDefAlcance.store.load();
         }
       })


       Ext.apply(this,{
            width: 900,
            height: 450,
            layout:'border',
            defaultFocus:main.txtTecnologia,
            items:[
                main.panelGeneral,
                main.TreeGridAlcance,
                main.TreeGridProcesosDisp
            ]
        });

        this.callParent(arguments);
   },
   MostrarProcesos:function(){
        var main = this;
        console.log('ssss');
        main.panelGeneral.hide();
        main.TreeGridProcesosDisp.show();
   }
});
