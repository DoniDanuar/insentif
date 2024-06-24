<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Sistem Informasi Insentif</title>

  <link rel="stylesheet" href="<?php echo (base_url()) ?>/assets/adminlte3/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo (base_url()) ?>/assets/adminlte3/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- datatables -->
  <link rel="stylesheet" href="<?php echo (base_url('assets/datatables/css/jquery.dataTables.min.css')) ?>">
  <!-- jquery-ui -->
  <link rel="stylesheet" href="<?php echo (base_url('assets/jquery-ui/themes/base/jquery-ui.css')) ?>">

  <style>

    .main-header {
      background-color: #0554a8;
    }

   /* .main-footer {
      background: linear-gradient(138deg, rgba(3,4,5,1) 10%, rgba(56,84,164,1) 62%) !important;
      color: #FFFFFF;
    }*/

    .brand-link {
       background-color: #0554a8;
    }

    .main-sidebar {
      background-color: #0554a8;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #787d82 !important;
        color: #fff !important;
    }

    #table th {
      font-size: 12px;
      background-color: #0554a8 !important;
      color: white;
    }

    #table td {
      font-size: 14px;
      vertical-align: middle;
    }

    table.dataTable thead th {
      vertical-align: middle;
    }

    .required label {
      font-weight: bold;
    }

    .required label:after {
        color: #e32;
        content: " * wajib";
        font-style: italic;
        font-size: 12px;
        display:inline;
    }

  </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
