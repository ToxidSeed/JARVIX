/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.UsuarioGestion',{
   extend:'Ext.ux.desktop.Module' ,
   require:[
       'Ext.window.Window',
       'Per.GridPanel'/*,
       'Per.Config'*/
   ],
   id:'UsuarioGestion',
   Config:null,
   init:function(){
       this.launcher = {
           text:'Gestion de Usuarios'
       }              
   },
   createSearchFilters:function(){
        var module = this;
        
        module.Config = new Per.Config();
        
        module.txtNombres = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombres' 
        });
        
        module.txtApellidos = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Apellidos' 
        });
        
        module.txtCorreoElectronico = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Correo Electronico' 
        });
                
        
        module.dtFechaRegistroDesde = Ext.create('Ext.form.field.Date',{
           fieldLabel: 'Desde',
           format: module.Config.dateFormat 
        });
        
        module.dtFechaRegistroHasta = Ext.create('Ext.form.field.Date',{
           fieldLabel: 'Hasta' ,
           format: module.Config.dateFormat
        });
        
        module.fieldSetFechaRegistro = Ext.create('Ext.form.FieldSet',{
           title:'Fecha de Registro',
           items:[
               module.dtFechaRegistroDesde,
               module.dtFechaRegistroHasta               
           ] 
        });
        
        module.tbarPanelCriteria = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Buscar',
                    handler:function(){
                        module.loadGridUsuarios();  
                    }
                },{
                    text:'Limpiar'
                }
            ]
        });
        
        module.PanelCriteria = Ext.create('Ext.form.Panel',{
            title:'Criterios de Busqueda',
            tbar:module.tbarPanelCriteria,
            region:'west',
            bodyPadding: '5 5 0',
            frame:true,
            items:[
                module.txtNombres,
                module.txtApellidos,
                module.txtCorreoElectronico,
                module.fieldSetFechaRegistro
            ]
        });
        return module.PanelCriteria;
   },
   loadGridUsuarios:function(){
       var module = this;
        var params = {
            nombres: module.txtNombres.getValue(),
            apellidos: module.txtApellidos.getValue(),
            email: module.txtCorreoElectronico.getValue(),
            fechaRegistroDesde: module.dtFechaRegistroDesde.getValue(),
            fechaRegistroHasta: module.dtFechaRegistroHasta.getValue()
        }
       module.GridUsuariosRegistrados.load(params);
   },
   createGridUsuariosRegistrados:function(){
       var module = this;
       module.GridUsuariosRegistrados = Ext.create('Per.GridPanel',{
            loadOnCreate:false,
            region:'center',
            //selModel: Ext.create("Ext.selection.CheckboxModel", { }),
            width:500,
            title:'Usuarios Registrados',
            src: 'http://localhost/Elysium/index.php/GestionUsuariosController/getUsuarios',
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Correo Electronico',
                    dataIndex:'email',
                    flex:1
                },{
                    header:'Nombres',
                    dataIndex:'nombres'
                },{
                    header:'Apellidos',
                    dataIndex:'apellidos'
                },{
                    header:'Estado',
                    dataIndex:'FlgActivo'
                },{
                    header:'Pais',
                    dataIndex:'NombrePais'
                }
            ]
        });
        
        module.GridUsuariosRegistrados.on({
            'afterrender':function(){
                module.loadGridUsuarios();
            }
        })
        
        return  module.GridUsuariosRegistrados;
   },
   
       createWindow : function(){            
            var module = this;
            var desktop = this.app.getDesktop();
            var win = desktop.getWindow('UsuarioGestion');
            
            var toolWindow = Ext.create('Ext.toolbar.Toolbar',{
               items:[
                   {
                       text:'Nuevo'                       
                   },{
                       text:'Cerrar',
                       handler:function(){
                           win.close();
                       }
                   }
               ]
            });
            
            if(!win){               
                    win = desktop.createWindow({
                            tbar:toolWindow,
                            id:'UsuarioGestion',
                            title:'Gestion de Usuarios',
                            width: 0,
                            maximized:true,
                            height: 0,
                            animCollapse:false,
                            border: false,
                            layout:'border',
                            items:[
                                this.createSearchFilters(),
                                this.createGridUsuariosRegistrados()
                            ]
                    });
            }
            return win;
    } 
});


