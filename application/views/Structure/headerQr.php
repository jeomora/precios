<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Cambio de Precios</title>
  <!--begin::Fonts-->
    <link rel="stylesheet" href="../../assets/css/fontsmi.css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="../../assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="../../assets/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
    <link href="../../assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/style.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
  <!-- Link Swiper's CSS -->
  <?php if (isset($links) && $links): ?>
        <?php foreach ($links as $link): ?>
            <link rel="stylesheet" href="<?php echo base_url($link.'.css') ?>">
        <?php endforeach ?>
    <?php endif ?>

  <!-- Demo styles -->
  <script>
        var base_url = "<?php echo base_url("/") ?>";//No carga el archivo index
        var site_url = "<?php echo site_url("/") ?>";//Si carga el index 
        var user_name = "<?php echo $this->session->userdata('username') ?>";//Si carga el index 
        
    </script>

</head>
<body>