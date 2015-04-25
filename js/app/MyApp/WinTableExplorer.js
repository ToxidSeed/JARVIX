/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.WinTableExplorer',{
    extend:'Ext.window.Window',
    require:[
      'MyApp.WinConfigExplorer'    
    ],
    projectName:null,
    initComponent:function(){
        var window = this;
        
        console.log(window);
         //@toolBar
        //Usage: @toolBar
        var toolConfiguracion = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    text:'Guardar Configuracion',
                    handler:function(){
                        Ext.Ajax.request({
                            url: 'http://localhost/Codex/index.php/DomainGenerator/saveConfiguration',
                            params:{
                                projectName: txtProjectName.getValue(),
                                dataBaseName: txtBaseDatos.getValue()
                            }
                        });
                    }
                }
            ]
        });
        //@txtProjectName
        //Usage: @winEntities
        var txtProjectName = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Proyecto',
           value: window.projectName
        });

        //@txtBaseDatos
        //Usage: @winEntities
        var txtBaseDatos = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Base de Datos' 
        });

        //@panelConfigurations
        //usage: @winEntities
        var panelConfigurations = Ext.create('Ext.form.Panel',{                    
             frame:true,
             title:'Configuracion de Proyecto',
             tbar:toolConfiguracion,
             bodyPadding: '5 5 0',
             items:[txtProjectName,
             txtBaseDatos]
        });
        
        
        //@GridTablas donde se encuentran las Entidades
        //Usage: @winEntities 
        var GridTablas = Ext.create('Per.GridPanel',{
            width: 400, 
            height:150,
            loadOnCreate:false,
            title:'Lista de Tablas',
            src: 'http://localhost/Codex/index.php/DomainGenerator/getTables',
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Nombre',
                    dataIndex:'TableName',
                    flex:1
                }
            ]
        });
        
        GridTablas.on({
            'itemdblclick':function(grid,record){                                
                var myWinConfigExplorer = Ext.create('MyApp.WinConfigExplorer',{
                    ProjectName: window.projectName,
                    TableName: record.get('TableName')
                });
                myWinConfigExplorer.show();
            }
        })
        
        var winToolBar = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Generar'
               }
           ] 
        });
        
        Ext.apply(this,{
           width: 400, 
           tbar:winToolBar,
           modal:true,
           height:350,
           title:'Generador ORM',
           items:[
               panelConfigurations,
               GridTablas
           ],
           listeners:{
               'show':function(){
                   Ext.Ajax.request({
                        url: 'http://localhost/Codex/index.php/DomainGenerator/getConfiguration',
                        params:{
                            projectName: window.projectName
                        },
                        success:function(response){
                            var answer = Ext.decode(response.responseText);
                                                      
                            //Check Response
                            if(answer.data !== null){
                                //Si la Respuesta devuelve contenido
                                //1.- se setea el campo base de datos
                                txtBaseDatos.setValue(answer.data.DataBaseName);
                                //2.- Se Carga el Grid con Datos
                                var object = {
                                    DataBaseName: answer.data.DataBaseName
                                };
                                console.log(object);
                                GridTablas.load(object);                            
                            }                            
                        }
                    });
               }
           }
        });
        
        
        
        this.callParent(arguments);
    }
});
