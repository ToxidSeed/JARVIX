/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProcesos.WinAddComentarios',{
    extend:'Ext.window.Window' , 
    internal:{
      id:null,
      //Former: ProcesoControlPropiedadId:null
      idReferencia:null,
      list_url:null,
      wrt_url:null,
      del_url:null
    },
    initComponent:function(){
        var main = this;        
        
        var myTbar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   iconCls:'icon-new',
                   text:'Nuevo',
                   handler:function(){
                       main.nuevo();
                   }
               },
               {
                    iconCls:'icon-disk',
                    text:'Guardar',
                    handler:function(){
                        main.wrt();
                    }
                },{
                    iconCls:'icon-door-out',
                    text:'Salir',
                    handler:function(){
                        main.close();
                    }
                }
           ] 
        });
        
        main.myHtmlComentario = Ext.create('Ext.form.field.HtmlEditor',{
            width:350,
            height:330,
            region:'west'            
        }); 
        
        main.myPanel = Ext.create('Ext.panel.Panel',{
            width:350,
            height:330,
            region:'west',
            border:false,
            split:true,
            items:[
                main.myHtmlComentario
            ]
        });
        
        main.tbarGrid = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   xtype:'checkbox',
                   fieldLabel:'Expandir',
                   labelAlign:'right',
                   handler:function(me,checked){
                       
                       if(checked ===true){                                             
                           main.myGridComentarios.addCls('custom-grid-pre-line');
                       }else{                           
                           main.myGridComentarios.removeCls('custom-grid-pre-line');
                       }                        
                   }
               }
           ] 
        });
        
        main.myGridComentarios = Ext.create('Per.GridPanel',{
            tbar:main.tbarGrid,
            cls:'custom-grid',
            region:'center',
            loadOnCreate:false,
            autoScroll:true,
            //src:base_url+'GestionProcesos/ProcesoControlPropiedad/listComentarios',
            src:base_url+main.internal.list_url,
            width:150,
            height:200,
            columns:[
                {                    
                    dataIndex:'id',   
                    hidden:true
                },{
                    xtype:'rownumberer'
                },{
                    header:'comentario',
                    dataIndex:'texto',
                    flex:1
                }
            ]
        });
        
        main.myGridComentarios.on({
            'itemdblclick':function(me,record){
                main.internal.id = record.get('id');
                 //console.log(main.internal);
                main.myHtmlComentario.setValue(record.get('texto'));
            }
        });
        
        //main.myGridComentarios.addCls('custom-grid-pre-line');
        
        Ext.apply(this,{
           title:'comentarios', 
           maximizable:true,
           tbar:myTbar,
           modal:true,
           width:800,
           height:390,
           layout:'border',
           items:[
                main.myPanel,
                main.myGridComentarios
           ]
        });
        
        main.on({
            'resize':function(grid,neww,newy){
                //console.log(main.myPanel.getWidth())
            },
            'render':function(){
                main.listComentarios();
            }
        });
        
        main.myPanel.on({
            'resize':function(panel,neww,newy){
                console.log(neww,newy)
                main.myHtmlComentario.setWidth(neww);
                main.myHtmlComentario.setHeight(newy);
            }
        });
        
        
        this.callParent(arguments);
    },
    wrt:function(){
        var main = this;
        
        Ext.Ajax.request({
          //url:base_url+'GestionProcesos/ProcesoControlPropiedad/wrtComentario',
          url:base_url+main.internal.wrt_url,
          params:{
             id:main.internal.id,
             idReferencia:main.internal.IdReferencia,
             texto:main.myHtmlComentario.getValue()
          },
          success:function(response){
                main.listComentarios();
          }
       });        
    },
    del:function(){
        var main = this;
        Ext.Ajax.request({
          //url:base_url+'GestionProcesos/ProcesoControlPropiedad/del',
          url:base_url+main.internal.del_url,
          params:{
              id:main.internal.id
          },
          success:function(response){
              //console.log(response);
          }
       });
    },
    listComentarios:function(){
        var main = this;
        main.myGridComentarios.load({
            ProcesoControlPropiedadId:main.internal.IdReferencia            
        });
    },
    nuevo:function(){
        var main = this;
        main.internal.id = null;
        main.myHtmlComentario.setValue(null);
    }
});

