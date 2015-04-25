Ext.define('MyApp.ProjectsExplorer',{
	extend: 'Ext.ux.desktop.Module',
	requires:[ 
	          'Ext.window.Window',
                  'MyApp.WinTableExplorer'
	          ],
	id:'ProjectsExplorer',
	init:function(){
		this.launcher = {
				text: 'ORM'
		};		
	},
	createWindow : function(){                                                          
                //@grid Proyectos
                var GridProyectos = Ext.create('Per.GridPanel',{
                   width:400,
                   height: 125,                   
                   title:'Explorador de Proyectos',
                   src: 'http://localhost/Codex/index.php/DomainGenerator/getProjects',
                   columns: [   
                       {
                         xtype:'rownumberer'  
                       },
                       {
                           header:'Nombre',
                           dataIndex: 'ProjectName',
                           flex:1
                        }]
                });
                //@GridProyectos Events
                GridProyectos.on({
                    'itemdblclick':function(grid,record){                                                
                        var WinTableExplorer = Ext.create('MyApp.WinTableExplorer',{
                            projectName: record.get('ProjectName')
                        });
                        WinTableExplorer.show();
                    }
                });
                                                
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow('TablesList');
		if(!win){
			win = desktop.createWindow({
				id:'TablesList',
				title:'Generacion de Objetos (ORM)',
				width: 600,
				height: 400,
				animCollapse:false,
				border: false,
				layout:'fit',
                                items:[
                                    GridProyectos
                                ]
			});
		}
		return win;
	}
});
