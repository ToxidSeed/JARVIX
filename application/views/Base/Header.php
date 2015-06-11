<html>
<head>
<!--<link rel="stylesheet" type="text/css" href="../js/app/desktop/css/desktop.css">-->
<!--<link rel="stylesheet" type="text/css" href="js/extjs/resources/ext-theme-neptune/ext-theme-neptune-all.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/MyAppIconStyle.css">
<script type="text/javascript" src="<?php echo base_url();?>js/extjs/examples/shared/include-ext.js?theme=gray"></script>



<script type="text/javascript">
        var path = '/RequerimentsManagerSrc/js/app/';
        base_url = '<?php echo base_url();?>'+'index.php/';
        APPDATEFROMDBFORMAT = '<?php echo APPDATEFROMDBFORMAT;?>';
        DATE_W3C = '<?php echo DATE_W3C;?>';
        APPDATEFORMAT = '<?php echo APPDATEFORMAT;?>';
        
        Ext.Loader.setPath({
        //    'Ext.ux.desktop': path+'desktop/js',
          //  MyDesktop: path+'desktop',
            MyApp: path+'MyApp',
            Per: path+'percod'
        });
</script>        