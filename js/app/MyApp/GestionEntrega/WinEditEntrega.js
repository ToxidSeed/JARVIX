/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEditEntrega',{
   extend:'Ext.window.Window',
   create:true,
   internal:{
       id:null,
       proyecto:{
           id:null
       }
   },
   width:500,
   height:0,
   modal:true,
   maximized:true,
   initComponent:function(){
       var main = this;

       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Guardar',
                  iconCls:'icon-disk',
                  handler:function(){
                      main.GuardarEntrega();
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

        main.txtEntrega = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Entrega'
        });

       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre'
       });

       main.dateFecha = Ext.create('Ext.form.field.Date',{
           fieldLabel:'Fecha Entrega'
       });

       main.dateFechaCierra = Ext.create('Ext.form.field.Date',{
          fieldLabel:'Fecha Cierre Alcance',
          disabled:true
       });

       main.btnBuscarProyecto = Ext.create('Ext.Button',{
            text:'...',
            handler:function(){
                main.BuscarProyecto();
            }
        })

       main.panelGeneral = Ext.create('Ext.panel.Panel',{
           height:150,
          region:'west',
          bodyPadding:'10px',
          items:[
              {
                   layout:'column',
                   frame:false,
                   border:false,
                    bodyStyle:{
                         background:'transparent',
                         padding:'0px 0px 5px 0px'
                    },
                   items:[
                        main.txtProyecto,
                        main.btnBuscarProyecto
                   ]
               },
              main.txtEntrega,
              //main.txtNombre,
              main.dateFecha,
              main.dateFechaCierra
          ]
       });


       main.TreeGridAlcance = Ext.create('MyApp.GestionEntrega.WinEditEntrega_TreeGridAlcance');

       main.TreeGridProcesosDisp = Ext.create('MyApp.GestionEntrega.WinEditEntrega_TreeGridProcesosDisp');
       //
       main.TreeGridProcesosDisp.on({
           'btnOcultar_Click':function(node){
               main.OcultarProcesos();
           }
       });

       //afteritemexpand
       //beforeitemexpand

       main.TreeGridAlcance.on({
         'btnAgregar_Click':function(args){
             //Show and hide panels
             //console.log(main.TreeGridAlcance.getStore().getNewRecords());
             main.MostrarProcesos();

             //Load stores
             //main.TreeGridDefAlcance.store.load();
         }
       });


       Ext.apply(this,{
            width: 900,
            height: 250,
            layout:'border',
            defaultFocus:main.txtTecnologia,
            items:[
                main.panelGeneral,
                main.TreeGridAlcance,
                main.TreeGridProcesosDisp
            ],
            listeners:{
                'show':function(){
                    if(main.internal.id !== null){
                        main.getEntrega();
                    }
                }
            }
        });

       if (main.create === true){
           main.title = 'Nueva Entrega';
           main.Nuevo();
       }else{
           main.title = 'Modificar Entrega';
       }

        this.callParent(arguments);
   },
   MostrarProcesos:function(){
        var main = this;
        main.panelGeneral.hide();
        main.TreeGridProcesosDisp.show();
        main.loadAlcanceDisponible(main.internal.proyecto.id);
   },
   OcultarProcesos:function(){
       var main = this;
        //console.log('ssss');
        main.panelGeneral.show();
        main.TreeGridProcesosDisp.hide();
   },
   Nuevo:function(){
       var main = this;
       if (main.internal.id === null){
           main.TreeGridProcesosDisp.Toolbar.child("#btnAgregar").disable();
           main.TreeGridAlcance.ltbar.child('#btnBuscar').disable();
       }
   },
   Modificar:function(){
        var main = this;
        main.TreeGridProcesosDisp.Toolbar.child("#btnAgregar").enable();
        main.TreeGridAlcance.ltbar.child('#btnBuscar').enable();
   },
   BuscarProyecto:function(){
       var main = this;
        var winProyectos = new MyApp.Helpers.Proyectos.HelperProyectosUsuario();
            winProyectos.show();
            winProyectos.on({
                'seleccion':function(){
                    main.txtProyecto.setValue(winProyectos.response.Proyecto.nombre);
                    main.internal.proyecto.id = winProyectos.response.Proyecto.id;
//                    main.txtSetProject.setValue(winProyectos.response.Proyecto.nombre);
//                    main.Grid.load(main.getParams());
//                    main.Grid.show();
//                    main.dispModelarRequerimientos.hide();
                }
        });
   },
   GuardarEntrega:function(){
       var main = this;
       Ext.Ajax.request({
           url:'../GestionEntregas/Entrega/wrt',
           params:{
               Id:main.internal.id,
               ProyectoId:main.internal.proyecto.id,
               Entrega:main.txtEntrega.getValue(),
               Fecha: main.dateFecha.getValue()
           },
           success:function(response){
                //Ext.Msg.alert('Status', response.responseText);
                var data = Ext.decode(response.responseText);
                main.TreeGridProcesosDisp.setProyecto(main.internal.proyecto.id);
                main.internal.id = data.extradata.EntregaId;
                main.Modificar();
           }
       });
   },
   getEntrega:function(){
       var main = this;
       Ext.Ajax.request({
           url:'../GestionEntregas/Entrega/find',
           params:{
               EntregaId:main.internal.id
           },
           success:function(response){

                var record = Ext.decode(response.responseText).data;

                main.internal = {
                    id:record.id,
                      proyecto:{
                        id:record.proyecto.id
                    }
                };
                //
                main.txtEntrega.setValue(record.nombre);
                main.txtProyecto.setValue(record.proyecto.nombre);
                main.dateFecha.setValue(record.fecha);
                //console.log(response);
                //Set Grid Values
                main.TreeGridProcesosDisp.setInternal(main.internal);
                main.loadAlcanceAsignado(main.internal);
           }
       });
   },
   loadAlcanceDisponible:function(ProyectoId){
       var main = this;
       //console.log(ProyectoId);
       //main.TreeGridProcesosDisp.setProyecto(ProyectoId);
       main.TreeGridProcesosDisp.getStore().load();
   },
   loadAlcanceAsignado:function(parEntrega){
     var main = this;
     main.TreeGridAlcance.setInternal(main.internal);
     main.TreeGridAlcance.getStore().load();
   }
});
