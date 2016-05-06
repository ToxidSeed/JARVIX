/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('MyApp.GestionControles.WinMantPropiedades',{
    extend:'Ext.window.Window',
    create:false,
    /*width:500,
    height:200,*/
    modal:true,
    autoRender:true,
    delRecords:null,
    internal:{
        id:null,
        ControlId:null
    },
    initComponent:function(){
        var main = this;
        //initializeing
        main.delRecords = new Array();
        //console.log(main.internal);
        
        Ext.define('valor', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'valor'}
            ]
        });
        
        Ext.define('ModelEditor', {
            extend: 'Ext.data.Model',
            fields: [
                'id','constante'
            ]
        });
        
        main.tbarMain = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Guardar',
                   iconCls:'icon-disk',
                   handler:function(){
                       main.Guardar();
                   }
               },{
                   text:'Salir',
                   iconCls:'icon-door-out',
                   handler:function(){
                       main.close();
                   }
               }/*,{
                   text:'probar',
                   handler:function(){
                       
                   }
               }*/
           ] 
        });
        
        main.tbarValores = Ext.create('Ext.toolbar.Toolbar',{
           items:[
               {
                   text:'Agregar',
                   iconCls:'icon-add',
                   handler:function(){
                       //add row
                       main.AddValorFila();
                   }
               },
               {
                   text:'Quitar',
                   iconCls:'icon-delete',
                   handler:function(){
                       main.quitar();
                   }
               }/*,{
                   text:'probar',
                   handler:function(){                  
                        var myStore = main.gridTablas.getStore();                        
                        var myRecord = myStore.getRange(1,1);
                        console.log(myRecord[0]);
                        myRecord[0].set('flgDefault',1);
                   }
               } */
           ] 
        });
        
        main.txtNombre = Ext.create('Ext.form.field.Text',{
           fieldLabel:'Nombre' 
        });
        
        // The data store containing the list of states
        var store_editores = Ext.create('Ext.data.Store', {
            fields: ['id', 'constante'],
            proxy:{
               type:'ajax',
               url: base_url+'GestionControles/GestionControlesController/get_editores',
               reader:{
                   type:'json',
                   root:'results',
                   totalProperty:'total'
               }
           }
        });

        // Create the combo box, attached to the states data store
        main.editores = Ext.create('Ext.form.ComboBox', {
            fieldLabel: 'Editor',
            store: store_editores,
            queryMode: 'remote',
            displayField: 'constante',
            valueField: 'id'            
        });
        
            
        
        
        main.txtDescripcion = Ext.create('Ext.form.field.TextArea',{
            fieldLabel:'Descripcion',
            width:350,
            height:60
        });
        
        main.chkSelModel = new Ext.selection.CheckboxModel({
            mode:'MULTI'
        });
        
        //main.selModel = 
        
        
        /*Ext.define('User',{
           extend:'Ext.data.Model',
           fields:[
               {name:'id', type:'int'},
               {name:'valor', type:'string'},
               {name:'defaukt',type:'boolean',defaultValue:false}   
           ]
        });*/
        
        
        main.gridTablas = Ext.create('Per.GridPanel',{            
           loadOnCreate:false,           
           width:'100%',
           height:170,
           border:false,
           src: base_url+'GestionPropiedades/GestionPropiedadesController/getValores',
           selModel:main.chkSelModel,
           /*selModel:{
               selType:'cellmodel'
           },*/
           columns:[
               {
                   xtype:'rownumberer'
               },{
                  header:'id',
                  dataIndex:'id',
                  hidden:true
               },{
                   header:'valor',
                   dataIndex:'valor',
                   flex:1,
                   editor:{
                       xtype:'textfield'
                   }
               },{
                   text:'default',
                   xtype:'checkcolumn',
                   dataIndex:'flgDefault',
                   listeners:{
                       'checkchange':function(check,row_index){
                           main.desmarcar(row_index);
                       }
                   }                   
               }               
           ],
           plugins:[
               Ext.create('Ext.grid.plugin.CellEditing',{clicksToEdit:1, pluginId: 'cellediting'})
           ]
        });
        
        main.gridTablas.on({
           'edit':function(editor,e){
               console.log(editor);
           } 
        });
                      
        main.panelPrincipal = Ext.create('Ext.panel.Panel',{
           bodyPadding:'10px',           
           //split:true,
           region:'west',
           width:'65%',
           //border:false,
           height:400,
           items:[
               main.txtNombre,
               main.editores,
               main.txtDescripcion              
           ]
        });
        
         main.panelGrid = Ext.create('Ext.panel.Panel',{             
             tbar:main.tbarValores,
             border:false,
            region:'center',
            width:'35%',
            height:200,
            items:[
                main.gridTablas
            ]
        });
        
        Ext.apply(this,{
            tbar:main.tbarMain,
            layout:'border',
            width:600, 
            height:350,
            defaultFocus:main.txtNombre,
           items:[
               main.panelPrincipal,
                main.panelGrid
           ],
           listeners:{
               'show':function(){
                   if (main.internal.id != 'undefined' && main.internal.id > 0){
                        //load data
                        main.getPropiedad();
                        main.loadValores();
                    }
               }
           }
        });
        
        this.callParent(arguments);
    },
    AddValorFila:function(){
        var main = this;        
        var myValor = Ext.create('valor',{
           id:null,
           valor:null,
           flgDefault:null
        });        
        var myStore = main.gridTablas.getStore();
        var myModelAdded = myStore.add(myValor);        
        var myEditing = main.gridTablas.getPlugin('cellediting');        
        var edit = myEditing.startEdit(myValor,2);                        
    },
    Guardar:function(){
        var main = this;
        
        
        
        var myValores = main.getValores();
        var myValoresEliminar = Per.Store.getDataAsJSON(main.delRecords);                
        
        //console.log(myValoresInsertar);
        
        
        Ext.Ajax.request({
           url:base_url+'GestionPropiedades/GestionPropiedadesController/writeRecord',
           params:{
                PropiedadId:main.internal.id,
                ControlId:main.internal.ControlId,
                EditorId:main.editores.getValue(),
                Nombre:main.txtNombre.getValue(),
                Descripcion: main.txtDescripcion.getValue(),
                //ValoresInsert:myValores.valoresInsertar,
                //ValoresUpdate:myValores.valoresUpdate,
                Valores: myValores,
                ValoresEliminar:myValoresEliminar
           },
           success:function(response){
               var data = Ext.decode(response.responseText);
               //console.log(data);
               if(data.success == true && data.code == 0){
                   main.fireEvent('saved');
                   main.close();
               }               
           }           
        });
    },
    getPropiedad:function(){
        var main = this;
        
        Ext.Ajax.request({
           url:base_url+'GestionPropiedades/GestionPropiedadesController/find',
           params:{
               PropiedadId:main.internal.id
           },
           success:function(response){
               var decode = Ext.decode(response.responseText);
               main.internal.id = decode.data.id;
               main.txtNombre.setValue(decode.data.nombre);    
               
                var RecordModelEditor = Ext.create('ModelEditor', {
                    id   : decode.data.editor.id,
                    constante : decode.data.editor.constante
                });
                main.editores.setValue(RecordModelEditor);
           }           
        });        
    },
    loadValores:function(){
        var main = this;
        main.gridTablas.load({
            PropiedadId:main.internal.id
        });
    },
    getValores:function(){
        var main = this;
        var myStore = main.gridTablas.getStore();
        var myRecords = myStore.getRange();        
        var row;
        
        var varValores = new Array();
        
        
        for(row in myRecords){            
            varValores.push(myRecords[row]);                            
        }
        
      
        return Per.Store.getDataAsJSON(varValores);

    },       
    getValoresActualizar:function(){
        var main = this;
       var myStore = main.gridTablas.getStore();
        var myRecords = myStore.getRange();        
        var row;
        var varValoresUpdate = new Array();         
        
        for(row in myRecords){
            if (myRecords[row].get('id') != null){
                varValoresUpdate.push(myRecords[row]);                
            }
        }
        return Per.Store.getDataAsJSON(varValoresInsert);
    },
    quitar:function(){
        var main = this;
        var mySelModel = main.gridTablas.getSelectionModel();
        var myStore = main.gridTablas.getStore();
        var records = mySelModel.getSelection();        
        var row;                
        for(row in records){            
            if (records[row].get('id') != null){
                main.delRecords.push(records[row]);
            }
        }        
        myStore.remove(records);        
    },
    desmarcar:function(row_index_no_desmarcar){
        var main = this;
        var myStore = main.gridTablas.getStore();
        var rows = myStore.getRange();
        
        for(var index in rows){
            console.log(row_index_no_desmarcar);
            if (index != row_index_no_desmarcar ){
                var record = rows[index];
                record.set('flgDefault',0);
                console.log(index);
            }                                
        }        
    }
});

