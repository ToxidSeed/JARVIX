/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('MyApp.GestionProyectos.WinAddParticipantes',{
   extend:'Ext.window.Window', 
   response:{},
   internal:{},
   initComponent:function(){
       var main = this;
       
       main.txtNombresApellidos = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombres y Apellidos'
       });
       
       main.tbarCriterios = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){
                       
                   }
               },
              '-'
               ,
               {
                   text:'Salir',
                   iconCls:'icon-door-out',
                   handler:function(){
                       main.close();
                   }
               }
           ] 
       });
       
       main.panelCriterio = Ext.create('Ext.panel.Panel',{
           border:false,
           title:'Criterios',           
           tbar:main.tbarCriterios,
           region:'north',      
           split:true,
           height:'25%',
           collapsible:true,
           bodyPadding:'10px',
           items:[
               main.txtNombresApellidos
           ]
       });
       
       var myChkGrid = new Ext.selection.CheckboxModel();
      
       main.gridUsuarios = Ext.create('Per.GridPanel',{
          loadOnCreate:false,          
          width:'100%',
          height:295,
          border:false,
          pageSize:20,
          src:base_url+'GestionProyectos/GestionProyectosController/getNoParticipantes',
          columns:[
              {
                  xtype:'rownumberer'
              },{
                  header:'identificador',
                  dataIndex:'id',
                  hidden:true
               },{
                  header:'Nombre',
                  dataIndex:'nombre',
                  flex:1
              }
          ],
          pagingBar:true,
          selModel:myChkGrid
       });
       
       main.gridUsuarios.on({
           'afterrender':function(){
                  main.getNoParticipantes();
              }
       })
       
       main.tbarAsignar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Asignar',
                  iconCls:'icon-user_add',
                  handler:function(){
                     main.asignarParticipantes();
                     
                  }
              }
          ] 
       });
       
       
        main.panelGrid = Ext.create('Ext.panel.Panel',{
            tbar:main.tbarAsignar,
           title:'Usuarios',           
           region:'center',
           width:'100%',
           split:true,           
           height:'75%',
           items:[
               main.gridUsuarios
           ]
       });
       
       
       
       Ext.apply(this,{
           title:'Asignar Participantes',
           layout:'border',                      
           width:350,           
           height:500,
           modal:true,
           items:[
               main.panelCriterio,
               main.panelGrid
           ]
       });    
       
       this.callParent(arguments);
   },
   getNoParticipantes:function(){
       var main = this;
       main.gridUsuarios.load({
            Nombre:main.txtNombresApellidos.getValue(),
            ProyectoId: main.internal.Proyecto.Id
       });
   },
   asignarParticipantes:function(){
      var main = this;
      var mySelModel = main.gridUsuarios.getSelectionModel();
      var selected = mySelModel.getSelection();
      var records = Per.Store.getDataAsJSON(selected,('id'));
      Ext.Ajax.request({
         url:base_url+'GestionProyectos/GestionProyectosController/updParticipantes',
         params:{
            ProyectoId: main.internal.Proyecto.Id,
            selected: records
         },
         success:function(response){
            main.getNoParticipantes();
            main.fireEvent('DespuesAgregar')
         }
      });
   }
});
