/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.Helpers.Events.HelperActiveProperties',{
    extend:'Ext.window.Window',
    width:400,
    height:200,
    initComponent:function(){
        var main = this;
        
        main.gridFlujoProceso = Ext.create('Per.GridPanel',{
            width:350,
            height:200,
            src:base_url+'Falta',
            columns:[
                {
                    xtype:'rownumberer'
                },
                {
                    header:'Nombre'
                }
            ]
        });
        
        Ext.apply(this,{            
            width:200,
            height:200,
            items:[               
                main.gridFlujoProceso
            ]
            
        });
        
        this.callParent(arguments);
    }
})

