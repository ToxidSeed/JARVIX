/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.ns('Per');
Per.MainWindow = Ext.extend(Ext.Window,{
   initComponent:function(){
       Per.MainWindow.superclass.initComponent.call(this);
       this.addEvents(
               'success',
               'complete',
               'failure'
       );       
   },
   processSuccessful:function(){
       this.fireEvent('success',this);
   },
   processFailure:function(){
       this.fireEvent('failure',this);
   },
   processComplete:function(){
       this.fireEvent('complete',this);
   }
});

