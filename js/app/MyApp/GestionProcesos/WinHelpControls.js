/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('MyApp.GestionProcesos.WinHelpControls',{
    extend:'Ext.window.Window',
    initComponent:function(){
        
        
        
        Ext.apply(this,{
           width:300,
           height:300
        });
        
        this.callParent(arguments);
    }
});