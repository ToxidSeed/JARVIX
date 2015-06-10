/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.WinPrincipal',{
    extend:'Ext.panel.Panel',
    initComponent:function(){
        var principal = this;
        
        var store = Ext.create('Ext.data.TreeStore',{
            
        });
        
        principal.treePanel = Ext.create('Ext.tree.Panel',{
           title:'Opciones' ,
           region:'west',
           split:true,
           rootVisible:false,
           collapsible:true,
           store:store,
           height:300,
           width:200,
           listeners:{
               'afterrender':function(){
                   Ext.Ajax.request({
                       url:'http://localhost/RequerimentsManagerSrc/index.php/PrincipalController/getSysOpcionesAplicacion',
                       success:function(response){                           
                            store.setRootNode(Ext.decode(response.responseText));
                        }
                   })
               },
               'itemclick':function(tree,record,item,index){
                   principal.getConfigOption(record.get('id'));
               }
           }
           
        });
        
        principal.panelCentral = Ext.create('Ext.tab.Panel',{
            id:'IDPanelCentral',
           frame:true,
           region:'center',
           split:true           
        });
        
        
        
        Ext.apply(this,{            
            floating:true,
            layout:'border',
            maximized:true,
            items:[
                principal.treePanel,
                principal.panelCentral
            ]
        })
        
        
        
        this.callParent(arguments);
    },
    /*
     *Method under in construcction
     **/
    addTabPanel:function(object){
        //console.log(base_url+object.data.viewloader);
        var main = this;
        var tabTitle = object.data.nombre;
        main.panelCentral.add({
            xtype:'panel',
            id:object.data.id,
            title:tabTitle,
            border:false,
            frame:false,                       
            closable:true,
            layout:'border',
            items:[
                {
                    xtype:'component',
                    autoEl:{
                         tag:'iframe',
                         frameBorder:0,
                         src:base_url+object.data.viewLoader
                     } 
                }
            ]                       
        })
        main.panelCentral.setActiveTab(object.data.id);
    },
    getConfigOption:function(id){
        var principal = this;
        Ext.Ajax.request({
            url:base_url+'/PrincipalController/find',
            params:{
                id:id
            },
            success:function(response){                           
                var data = Ext.decode(response.responseText);
                //Adding Tab                
                principal.addTabPanel(data);
            }
        })
    }
    
}
)


