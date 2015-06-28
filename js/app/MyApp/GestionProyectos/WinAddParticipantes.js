/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('MyApp.GestionProyectos.WinAddParticipantes',{
   extend:'Ext.window.Window', 
   response:{},
   initComponent:function(){
       var main = this;
       
       main.txtNombresApellidos = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombres y Apellidos'
       });
       
       main.tbarCriterios = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   handler:function(){
                       
                   }
               },
              '-'
               ,
               {
                   text:'Cancelar',
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
       
      
       main.gridUsuarios = Ext.create('Per.GridPanel',{
          loadOnCreate:false,          
          width:'100%',
          height:295,
          border:false,
          pageSize:20,
          src:'',
          columns:[
              {
                  xtype:'rownumberer'
              },{
                  header:'Nombres y Apellidos',
                  dataIndex:'Nombres',
                  flex:1
              }
          ],
          pagingBar:true
       });
       
       main.tbarAsignar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Asignar'
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
   }   
});
