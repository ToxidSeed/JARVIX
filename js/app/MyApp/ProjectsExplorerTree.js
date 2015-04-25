/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('MyApp.ProjectsExplorerTree',{
    extend:'Ext.ux.desktop.Module',
    requires:[
        'Ext.window.Window',
        'MyApp.WinTableExplorer'
    ],
    id:'ProjectsExplorer',
    init:function(){
        this.launcher = {
            text:'ORM'
        };
    },
    loadConfigurationProject:function(record){
         var window = this;
         //Setting the project Name
         window.txtProjectName.setValue(record.get('text'));
         //Obtenemos el valor del tree y obtenemos los valores         
        //Obtenemos el Nombre de la base de datos de acuerdo al nombre del proyecto
         Ext.Ajax.request({
            url: 'http://localhost/Codex/index.php/DomainGenerator/getConfiguration',
            params:{
                projectName: record.get('text')
            },
            success:function(response){
                var answer = Ext.decode(response.responseText);
                //Check Response                
                if(answer.data !== null){
                    //Si la Respuesta devuelve contenido
                    //1.- se setea el campo base de datos                                    
                    window.txtBaseDatos.setValue(answer.data.DataBaseName);
                    //2.- Se Carga el Grid con Datos
                    var object = {
                        DataBaseName: answer.data.DataBaseName
                    };                    
                    window.GridTablas.load(object);                                                                    
                }else{
                    window.txtBaseDatos.setValue('');
                    window.GridTablas.getStore().removeAll();                    
                }
            }
        });         
    },
    loadDomainConfiguration:function(tableName){
        var window = this;
        window.GridColumns.load({
            ProjectName:  window.txtProjectName.getValue(),            
            DataBaseName: window.txtBaseDatos.getValue(),
            TableName: tableName            
        })        
    },
    
    generateDomain: function(){
         var window = this;
         
         var records = window.GridColumns.getStore().getRange();
         var columns = Per.Store.getDataAsJSON(records);
         
         Ext.Ajax.request({
               url:'http://localhost/Codex/index.php/DomainGenerator/generateDomain',
               params:{
                  ProjectName: window.txtProjectName.getValue(),
                  TableName: window.txtTableName.getValue(),
                  Columns: columns
               },
               success:function(response){
                   
                   var data = Ext.decode(response.responseText);                   
                   Ext.MessageBox.show({
                       msg:data.msg
                   })
               }
         });
    },
    createColumnsExplorer: function(){
        var window = this;
        
        var widthPrincipal = window.app.viewport.width;       
        var widthPanel = widthPrincipal*0.5;
        var widthGridExplorer = widthPanel - 20;
        
        //toolbar:
        window.toolbar = Ext.create('Ext.toolbar.Toolbar',{
            items:[
                {
                    'text':'Generar',
                    handler:function(){
                        window.generateDomain();
                    }
                }
            ]
        });
        
        //@txtTableName
        window.txtTableName = Ext.create('Ext.form.field.Text',{
            fieldLabel:'Tabla',
            disabled:true
        });
                
        
        //@GridTablas donde se encuentran las Entidades
        //Usage: @winEntities 
        window.GridColumns = Ext.create('Per.GridPanel',{
            loadOnCreate:false,            
            width:widthGridExplorer,
            title:'Configuracion de Objetos',
            src: 'http://localhost/Codex/index.php/DomainGenerator/getColumns',
            columns:[
                {
                    xtype:'rownumberer'
                },{
                    header:'Nombre',
                    dataIndex:'ColumnName',
                    width:200
                    
                },{
                    header:'Codigo',
                    dataIndex:'Codigo',
                    width:200,
                    field:{
                        xtype:'textfield'
                    }
                },{
                    header:'Relacionado a',
                    dataIndex:'Relacion',
                    flex:1,
                    field:{
                        xtype:'textfield'
                    }
                 }
            ],
            selType: 'cellmodel',
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1
                })
            ]
        });
        
        //Creating the Form Panel
        window.formPanel = Ext.create('Ext.form.Panel',{
            title:'Detalles de Tabla',
            tbar:window.toolbar,
           frame:true,
           region:'east',           
           width: widthPanel,
           split:true,
           bodyPadding: '5 5 0',
           items:[
               window.txtTableName,
               window.GridColumns
           ]
        });
        
        return window.formPanel;
    },
    createProjectsExplorer:function(){
        var principal = this;
        var store = Ext.create("Ext.data.TreeStore",{
            
        });

        var widthPrincipal = principal.app.viewport.width;
        
                
        this.treePanel = Ext.create('Ext.tree.Panel', {
            title: 'Simple Tree',
            region:'west',            
            store: store,
            split:true,
            width: widthPrincipal * 0.2,
            rootVisible: false,
            listeners:{
                'afterrender':function(){
                    //Adding childs here
                    Ext.Ajax.request({
                        url:'http://localhost/Codex/index.php/DomainGenerator/getProjectsTreeFormat',
                        success:function(response){
                            store.setRootNode(Ext.decode(response.responseText));
                        }
                    });
                },
                'itemdblclick':function(tree, record,item, index){                    
                    principal.loadConfigurationProject(record);
                }
            }
        });
        return this.treePanel;        
    },
    getGridTablasSelectedRows:function(){
        var window = this;
        var records = window.GridTablas.getSelectionModel().getSelection();
        return records;
    },
    MultiDomainGenerate:function(){
        var window = this;
        var tables = Per.Store.getDataAsJSON(window.getGridTablasSelectedRows());
        Ext.Ajax.request({
            url: 'http://localhost/Codex/index.php/DomainGenerator/generate',
            params:{
                tables :tables,
                ProjectName: window.txtProjectName.getValue()
            },
            success:function(){
                alert('correct');
            }                           
        });
    },
    createTablesExplorer:function(){
        var window = this;
        
        var widthPrincipal = window.app.viewport.width;
        var widthPanel = widthPrincipal*0.3;
        var widthGrid  = widthPanel-10;
        //@txtProjectName
        //Usage: @winEntities
        window.txtProjectName = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Proyecto',
           disabled:true,
           value: window.projectName
        });

        //@txtBaseDatos
        //Usage: @winEntities
        window.txtBaseDatos = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Base de Datos' 
        });

        //@GridTablas donde se encuentran las Entidades
        //Usage: @winEntities 
        window.GridTablas = Ext.create('Per.GridPanel',{
            loadOnCreate:false,
            selModel: Ext.create("Ext.selection.CheckboxModel", { }),
            width:widthGrid,
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
        window.GridTablas.on({
           'itemdblclick' :function(grid,record){
               window.txtTableName.setValue(record.get('TableName'));
               window.loadDomainConfiguration(record.get('TableName'));
           }
        });
        
        //ToolConfiguracion            
        window.tbarConfiguration = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Generar',
                   handler:function(){
                       window.MultiDomainGenerate();
                   }
               },{
                   text:'Guardar Configuracion',
                   handler:function(){
                       Ext.Ajax.request({
                           url: 'http://localhost/Codex/index.php/DomainGenerator/saveConfiguration',
                           params:{                               
                               projectName: window.txtProjectName.getValue(),
                               dataBaseName :window.txtBaseDatos.getValue()
                           },
                           success:function(response){
                               var data = response.responseText;
                               alert(response.responseText)
                               //Reload Tables
                               window.GridTablas.load({
                                   DataBaseName: window.txtBaseDatos.getValue()
                               });
                           }                           
                       }) 
                   }
               }
           ]           
        })
        
        
        //@panelConfigurations        
        //usage: @winEntities
        window.panelConfigurations = Ext.create('Ext.form.Panel',{                    
             frame:true,
             region:'center',
             split:true,
             width: widthPanel,
             title:'Configuracion de Proyecto',
             tbar:window.tbarConfiguration,
             bodyPadding: '5 5 0',
             items:[window.txtProjectName,
             window.txtBaseDatos,
             window.GridTablas
            ]
        });

       return this.panelConfigurations;
    },
    createWindow : function(){            
            var module = this;
            var desktop = this.app.getDesktop();
            var win = desktop.getWindow('ProjectsExplorer');
            if(!win){               
                    win = desktop.createWindow({
                            id:'TablesList',
                            title:'Generacion de Objetos (ORM)',
                            width: 0,
                            maximized:true,
                            height: 0,
                            animCollapse:false,
                            border: false,
                            layout:'border',
                            items:[
                                this.createProjectsExplorer(),
                                this.createTablesExplorer(),
                                this.createColumnsExplorer()
                            ]
                    });
            }
            return win;
    }
});