/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('Per.MessageBox',{ 
   extend:'Ext.util.Observable',
   data:null,
   constructor:function() {              
        this.addEvents({
            "okButtonPressed" : true,
            "yesButtonPressed": true,
            "noButtonPressed":true,
            "cancelButtonPressed":true
        });        
        // Call our superclass constructor to complete construction process.
        this.callParent(arguments)
     },
   success:function(){
       var msg = this;
       //Check the Object Message, show message if no defined
       if(msg.data == null){
            this.showConfigMessageNoDefined()            
       }  
       //Proviene de la validacion de los controles
       if(msg.data.code == 1){
           msg.showWarningValidationMessage();
       }
       if(msg.data.code == 0){
           msg.showInfoProcessMessage()
       }              
       if(msg.data.code == -1){
           msg.showErrorProcessMessage();
       }
   },
   showConfigMessageNoDefined:function(){
       var messageBox = this;
       Ext.MessageBox.show({
             title:'Error',
             msg:'No se ha seteado el object mensaje',             
             buttons: Ext.MessageBox.OK,
             icon:Ext.MessageBox.ERROR,
             fn:function(btn){                                   
                 messageBox.fireEvent('okButtonPressed',{});
             }
         }) 
   },
   showWarningValidationMessage:function(){
      var msg = this;
      var text = '<ul>';            
      for(var object in msg.data.errors){                    
          text += '<li>'+msg.data.errors[object]+'</li>';
      }
      
      //Check if variable is array or not
      if(msg.data.message != null){
        if (msg.data.message.constructor === Array) {
            for(msgs_idx in msg.data.message){
               text += '<li>'+msg.data.message[msgs_idx]+'</li>';
            }
         }else{
            text += '<li>'+msg.data.message+'</li>';
         }
      }
                  
      text +='</ul>';
      
       Ext.MessageBox.show({
             title:msg.data.type,
             msg:text,
             buttons: Ext.MessageBox.OK,
             icon:Ext.MessageBox.WARNING,
             fn:function(btn){                                   
                 msg.fireEvent('okButtonPressed',{});
             }
         }) 
   },
   showInfoProcessMessage:function(){
        var msg = this;
        Ext.MessageBox.show({
             title:msg.data.type,
             msg:msg.data.message,
             buttons: Ext.MessageBox.OK,
             icon:Ext.MessageBox.INFO,
             fn:function(btn){                                   
                 msg.fireEvent('okButtonPressed',{});
             }
         }) 
   },
   showErrorProcessMessage:function(){
       var msg = this;
       Ext.MessageBox.show({
          title:msg.data.type,
          msg:msg.data.message,
          buttons: Ext.MessageBox.OK,
          icon:Ext.MessageBox.ERROR,
          fn:function(btn){
              msg.fireEvent('okButtonPressed',{});
          }
       });
   },
   failure:function(){
       var messageBox = this;
       Ext.MessageBox.show({
             title:'Error',
             msg:messageBox.data.message,             
             buttons: Ext.MessageBox.OK,
             icon:Ext.MessageBox.ERROR,
             fn:function(btn){                                   
                 messageBox.fireEvent('okButtonPressed',{});
             }
         }) 
   }
});

