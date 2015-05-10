/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionProcesos.WinAddRequerimiento',{
    extend:'Ext.window.Window',
    internal:{        
        proceso:{
            id:null
        }        
    },    
    initComponent:function(){
        var main = this;
        
        main.mainTbar = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Agregar',
                    handler:function(){
                        main.Add();
                    }
                },
                {
                    text:'Cancelar',
                    handler:function(){
                        main.close();
                    }
                }
            ]
        });
        
        var myChkSelector = Ext.create('Ext.selection.CheckboxModel');
        
        main.gridRequerimientos = Ext.create('Per.GridPanel',{
           border:false,
           loadOnCreate:false,
           width:550,
           height:350,
           pageSize:20,
           src: base_url+'/GestionProcesos/ProcesoRequerimientoFuncional/getRequerimientos',
           columns:[
               {
                   xtype:'rownumberer'
               },{
                   header:'Codigo',
                   dataIndex:'requerimientoFuncional.codigo'
               },{
                   header:'Nombre',
                   dataIndex:'requerimientoFuncional.nombre',
                   flex:1
               },{
                   header:'RequerimientoFuncionalId',
                   dataIndex:'requerimientoFuncional.id',
                   hidden:true
               },{
                   header:'ProcesoRequerimientoFuncionalId',
                   dataIndex:'id'
               }
           ],
           pagingBar:true,
           selModel:myChkSelector
        });
        
        main.gridRequerimientos.on({
            'afterrender':function(){
                main.getRequerimientos();
            }            
        });
           
        main.tbarBusqueda = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Buscar',
                    handler:function(){
                        
                    }
                },{
                    text:'Ocultar',
                    handler:function(){
                        main.panelBusqueda.collapse();
                    }
                }
            ]
        });
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Nombre'
        });
        
        main.panelBusqueda = Ext.create('Ext.panel.Panel',{
            bodyPadding:'10px',
            region:'west',
            title:'Busqueda',
            tbar:main.tbarBusqueda,
            collapsible:true,
            items:[
                main.txtNombre
            ]
        });
        
        main.panelGrid = Ext.create('Ext.panel.Panel',{
           region:'center',
           items:[
               main.gridRequerimientos
           ]
        });
        
        Ext.apply(this,{
            width:800,
            tbar:main.mainTbar,
            height:450,
            title:'Requerimientos',
            modal:true,
            layout:'border',
            defaultFocus:main.txtNombre,
            items:[
                main.panelBusqueda,
                main.panelGrid
            ],
            listeners:{
                'resize':function(win,nwidth,nheight){
                    main.gridRequerimientos.setHeight(nheight-60);                   
                }
            }
        });
        
        this.callParent(arguments);
    },
    Add:function(){
        var main = this;
        var mySelModel  = main.gridRequerimientos.getSelectionModel();         
        var records = mySelModel.getSelection();
        var columns = ['id','requerimientoFuncional.id'];
        var data = Per.Store.getDataAsJSON(records,columns);
        
        //Save Records
        
        Ext.Ajax.request({
           url:base_url+'GestionProcesos/ProcesoRequerimientoFuncional/asociar',
           params:{
               Requerimientos: data,
               ProcesoId: main.internal.proceso.id,
               Id: null
           },
           success:function(response){
                main.fireEvent('save');
                main.getRequerimientos();
           },
           failure:function(){
               
           }
        });
    },
    getRequerimientos:function(){
        var main = this;
        main.gridRequerimientos.load({
            parProcesoId : main.internal.proceso.id
        });
    }
});

