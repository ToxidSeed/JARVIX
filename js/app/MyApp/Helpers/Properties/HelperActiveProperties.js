/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.Helpers.Properties.HelperActiveProperties',{
    extend:'Ext.window.Window',
    width:400,
    height:200,
    pos:{
        x:0,
        y:0
    },
    initComponent:function(){
        var main = this;        
        
        var selModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        })
        
        
       
        main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre' 
        });
       
        main.btnBuscar = Ext.create('Ext.button.Button',{
           text:'Buscar' 
        });
       
        main.panelSearch = Ext.create('Ext.panel.Panel',{
            width:450,
            bodyPadding:'10px',
            layout:'column',
            items:[
                {
                    xtype:'panel',
                    border:0,
                    columnWidth:.7,
                    items:[
                        main.txtNombre
                    ]
                },{
                    xtype:'panel',                    
                    border:0,                    
                    columnWidth:.3,
                    items:[
                        main.btnBuscar
                    ]
                }
                
            ]
        })                
        
        main.gridFlujoProceso = Ext.create('Per.GridPanel',{
            width:450,
            height:200,
            src:base_url+'Helper/HelpActiveProperties/search',
            selModel:selModel,
            columns:[                                
                {
                    xtype:'rownumberer'
                },
                {
                    header:'Nombre',
                    flex:1
                }
            ]
        });
        
        Ext.apply(this,{           
            title:'Propiedades',
            width:450,            
            height:250,
            items:[            
                main.panelSearch,
                main.gridFlujoProceso
            ]            
        });
        
        this.callParent(arguments);
    }
})

