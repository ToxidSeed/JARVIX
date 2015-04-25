/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('Per.GridPanel',{
    extend: 'Ext.grid.Panel',
    src:null,
    loadOnCreate:true,
    width: 0,
    height:0,
    itemsPerPage:20,//Default
    page:1,
    columns: [],
    groupField:null,
    params:{},
    pagingBar:false,    
    sorters:{},
    initComponent: function() {
        var grid = this;                
        /*
         * Getting the Fields
         * 
         */
        var fields = [];
        var fieldIndex = 0;
        for(var i = 0;i<grid.columns.length;i++){            
            if(typeof(grid.columns[i].dataIndex) !== 'undefined'){
                fields[fieldIndex] = grid.columns[i].dataIndex;
                fieldIndex++;
            }
        }      
        /*
         * Create the store
         */              
        var store = Ext.create('Ext.data.Store',{
            fields:fields,
            pageSize:grid.itemsPerPage,
            groupField:grid.groupField,
            sorters:grid.sorters,
            proxy:{
                type:'ajax',
                url: grid.src,
                reader:{
                    type:'json',
                    root:'results',
                    totalProperty:'total'
                }
            }
        });
       
        
        //Setting the pagging bar  
//        console.log(grid.pagingBar);
        if (grid.pagingBar == true){
            grid.bbar = Ext.create('Ext.toolbar.Paging',{
                store:store,                
                listeners:{
                    'beforechange':function(bbar,page){
                            grid.page = page;
                            grid.params.start = (grid.page -1)* grid.itemsPerPage
                            grid.getStore().proxy.extraParams = grid.params;
                    }
                }
            });
        }
        
        
        
        Ext.apply(this,{
            width: grid.width,
            height: grid.height,
            store: store,              
            listeners: {
                afterrender:function(grid,opts){                      
                    if(grid.loadOnCreate === true){                        
                          grid.load(grid.params);
                    }                    
                }
            }
//            bbar:grid.pagingBar
        });        
        this.callParent(arguments);    //Siempre debe ir al Final del initComponent
    },
    'load':function(object){        
        var window = this;    
        //Si es que se tiene toolbar y se envia algun parametro
        if(window.pagingBar == true && typeof(object) !== 'undefined'){
            
            object["start"] = (window.page -1)* window.itemsPerPage;
            object["limit"] =  window.itemsPerPage;
            
        }
        //Si es que tiene toolbar pero no se envia ningun parametro 
        if(window.pagingBar == true && typeof(object) == 'undefined'){
            object = {
                        start:(window.page -1)* window.page.itemsPerPage,
                        limit: window.itemsPerPage
                     };
        }
        //Si es que no se envia ningun objeto y ademas no tiene pagingBar
        if(typeof(object) !== 'undefined'){   
            window.params = object;
            window.getStore().load({params:object});
        }else{                        
            window.getStore().load();
        }
        
    }
});

