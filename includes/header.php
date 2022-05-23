<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css import - NOT WORKING -->
  <link rel="stylesheet" href="./public/style.css">

  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Graphing Libraries -->
  <!-- Plotly -->
  <script src='https://cdn.plot.ly/plotly-2.11.1.min.js'></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>



  <title>Risk Dashboard</title>

</head>
<!-- Styles - MOVE INTO STYLESHEET LATER -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap');

    :root {
      --Background-colour: #112d40;
      --Widget-colour: #0b3755;
      --White-text-colour: #fff;
      --Grey-text-colour: #cdcdcd;
      --Menu-selected-colour: #87d7ff;
      --Font-Family: 'Open Sans', sans-serif;

    }

    body {
      margin: 0;
      font-family: var(--Font-Family);
      background-color: var(--Background-colour);
  }

  .sidebar {
      margin: 0;
      padding: 10px;
      width: 150px;
      background-color: var(--Background-colour);
      position: fixed;
      height: 100%;
      overflow: auto;
  }

  .sidebar-brand {
    color: var(--White-text-colour);
    padding: 5px 10px 5px 10px;
  }

  .sidebar a {
      display: block;
      color: white;
      padding: 16px;
      margin-bottom: 10px;
      border-radius: 10px;
      text-decoration: none;
  }

  .sidebar a.active {
      background-color: var(--Menu-selected-colour);
      color: Black;
  }

  .sidebar a:hover:not(.active) {
      background-color: #87d6fe;
      color: white;
  }

  div.content {
      margin-left: 180px;
      padding: 10px 16px;
      height: 1000px;
  }

  /* Dashboard Heading */
  .dashboard-heading{
    color: var(--White-text-colour);
  }

  /* option selector */
  .option-selector{
    width: 100px;
    border: none;
    background-color: var(--Widget-colour);
    color: var(--White-text-colour);
    border: 1px white solid;
    display: inline-block;
  }

  /* Widget title */
  .widget-title {
    margin: 0;
    padding: 0;
    font-size: 25px;
    font-weight: 600;
    display: inline-block;
  }
  /* Open Exposure Pnl tile  */
  .pnl-tile{
    text-align: center;
  }
  /* Table */
  .table{
    border-spacing: 10px;
    font-weight: 300;
    display: block;
    white-space: nowrap;
  }
  .table td{
    border-bottom: 1px solid white;
  }

  /* CSS Grid */
  .wrapper {
    display: grid;
    gap: 30px;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: minmax(300px, auto);
    /* grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); */
    color: #444;

  }

  .item {
    background-color: var(--Widget-colour);
    color: #fff;
    border-radius: 5px;
    padding: 10px;
    font-size: 150%;
  }

  .item1 {
    grid-column: 1 / 2;
    grid-row: 1;
  }
  .item2 {
    grid-column: 2 / 3;
    grid-row: 1;
  }
  .item3 {
    grid-column: 3 / 4;
    grid-row: 1 / 3;
  }
  .item8 {
    grid-column: 3 / 4 ;
    grid-row: 3 / 5;
  }
  .item9 {
    grid-column: 1 / 3;
  }

  /* Sidebar Media Query */
  @media screen and (max-width: 700px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .sidebar a {
      float: left;
    }

    div.content {
      margin-left: 0;
    }
  }
  /* Sidebar Media Query */
  @media screen and (max-width: 400px) {
    .sidebar a {
      text-align: center;
      float: none;
    }
  }
</style>

<body>

  <!-- Side Navigation Bar -->
  <div class="sidebar">
    <!-- Blackwell Logo - REPLACE LINK WITH FILE PATH -->
    <img src="./public/logo.png" width="150px">
    <p class="sidebar-brand">Main Menu</p>
    <a class="active" href="/Risk/dashboard.php">Risk BHS</a>
    <a href="#news">Dashboard 2</a>
    <a href="#contact">Dashboard 3</a>
    <a href="#about">Dashboard 4</a>
  </div>

<div class="content">
