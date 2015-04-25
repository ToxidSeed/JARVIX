Ext.ns('Per');
Per.DebugHelperWindow = Ext.extend(Ext.Window,{
   closable:false,
   
   initComponent:function(){
       var main = this;
       main.txtAreaMessage = Ext.create('Ext.form.HtmlEditor',{
           width:0,
           height:0,
           overflowY:'auto',
           overflowX:'auto',
           resizable:true
       });
       
        Ext.apply(this,{
            width:1000,
            height:500,
            items:[
                main.txtAreaMessage 
            ],buttons:[
                        {
                            text:'Aceptar',
                            handler:function(){
                                 main.close();
                            }
                        }
            ],
            listeners:{
                'resize':function(win,w,h){
                    main.txtAreaMessage.setWidth(w-5);
                    main.txtAreaMessage.setHeight(h-5);
                }
            }
            
        });  
       
       this.callParent(arguments);
   },
   showMsg:function(msg){
       var main = this;
       main.txtAreaMessage.setValue(msg);
       main.show();
   }   
});