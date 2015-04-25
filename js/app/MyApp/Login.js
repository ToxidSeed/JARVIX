/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.Login',{
    extend:'Ext.window.Window',    
    closable:false,
    titlebar:false,
    Login:function(){        
        var object = this;
        Ext.Ajax.request({
            url:base_url+'/AccesoAplicacion/AccesoAplicacionController/Login',
            params:{
                email:object.txtLogin.getValue(),
                password: object.txtPassword.getValue()
            },
            success:function(response){
                var msg = new Per.MessageBox();  
                msg.data = Ext.decode(response.responseText); 
                if(msg.data.code == 0){
                    object.close();
                }
                msg.success();    
            }
        });
    },
    initComponent:function(){
        var window = this;
        
        window.txtLogin = Ext.create('Ext.form.field.Text',{
           fieldLabel:'email' ,
           width: 300
        });
        
        window.txtPassword = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Password',
            inputType:'password'
        });
        
        window.btnLogin = Ext.create('Ext.button.Button',{
           text:'Ingresar' ,
           handler:function(){
               window.Login();
           }
        });
                
        Ext.apply(this,{                  
           bodyPadding: '5 5 0',
           width:350,
           height:130,
           modal:true,        
           border:false,
           frame:true,
           header:false,
           items:[
               window.txtLogin,
               window.txtPassword,
               window.btnLogin
           ]
        });
    
        this.callParent(arguments);
    }
})