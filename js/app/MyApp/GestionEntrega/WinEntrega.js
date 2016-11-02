/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionEntrega.WinEntrega',{
   extend:'Ext.panel.Panel',
   maximized:true,
   width:0,
   height:0,
   floating:true,
   autoRender:true,
   initComponent:function(){
       var main = this;
       
       main.tbar = Ext.create('Ext.toolbar.Toolbar',{
          items:[
              {
                  text:'Nuevo',
                  iconCls:'icon-add',
                  handler:function(){
                      main.editEntrega();
                  }
              }
          ] 
       });
       
       main.tbarCriterioBusqueda = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Buscar',
                   iconCls:'icon-search',
                   handler:function(){
                       
                   }
               },{
                   text:'Limpiar',
                   iconCls:'icon-clean',
                   handler:function(){
                       
                   }
               },{
                   text:'Ocultar',
                   iconCls:'icon-collapse',
                   handler:function(){
                       
                   }
               }
           ]
       });
       
       main.txtProyecto = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Proyecto'
       });
       
       main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre'
       });
       
       
       main.panelCriteriosBusqueda = Ext.create('Ext.panel.Panel',{
           tbar:main.tbarCriterioBusqueda,
           bodyPadding:'10px',
           title:'Criterios de Busqueda',
           region:'west',
           width:300,
           collapsible:true,
           collapsed:true,
           height:300,
           split:true,
           items:[
               main.txtNombre
           ]
       });
       
       main.list = Ext.create('Per.GridPanel',{
          loadOnCreate:false,
          region:'center',
          width:200,
          pageSize:20,
          title:'Entregas',
          src:'../GestionEntregas/Entrega/search',
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
       });      
       
       main.list.on({
           'afterrender':function(){
                main.list.load({
                    ProyectoId: main.txtProyecto.getValue()
                });
           },
           'itemdblclick':function(grid,record){
               //console.log(record);
               main.editEntrega(record.get('id'));
           }
       });
       
       Ext.apply(this,{
            layout:'border',
            items:[
                main.panelCriteriosBusqueda,
                main.list
           ]
        });
                                                
        this.callParent(arguments);
   },
   editEntrega:function(EntregaId){
       var main = this;
       var myWin = new MyApp.GestionEntrega.WinEditEntrega({
           internal:{
               id:EntregaId
           }
       });
       myWin.show();
   }
});

