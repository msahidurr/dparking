<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  th,
  td,
  body {
    font-family: 'Roboto', sans-serif;
  }

  h4.font-weight-semibold {
    margin-bottom: 10px !important;
  }

  .content-wrapper {
    background: radial-gradient(#ead1d0, #f2f1f6);
    padding: 60px 30px 40px 30px;
  }

  .navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link i {
    margin-right: 8px;
  }

  .card {
    border: 0;
    box-shadow: 5px 5px 10px rgb(0 0 0 / 10%);
    border-radius: 10px;
    margin-bottom: 30px !important;
    background-color: #ffffff;
  }

  .card-header {
    padding: 15px 30px;
  }

  .col-xl-8.stretch-card.grid-margin {
    /* margin-bottom: 0; */
  }



  .navbar .navbar-menu-wrapper {
    background: #000000;
    padding-left: 0;
  }

  .navbar .navbar-menu-wrapper .navbar-toggler {
    background-color: #000000 !important;
  }

  .navbar .navbar-menu-wrapper .navbar-toggler:not(.navbar-toggler-right) {
    font-size: 20px;
    border-radius: 0px !important;
  }

  .sidebar {
    background: #000000;
    position: fixed;
    overflow: hidden;
    border: 0;
  }

  .sidebar>.nav {
    height: calc(100vh - 119px);
    overflow-y: auto;
    padding: 0 0 60px 0;
    overflow-x: hidden;
  }

  .sidebar .nav-item-head {
    color: #ffffff;
    font-weight: 500;
  }


  .sidebar .nav .nav-item+.pt-2 {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .sidebar .nav .nav-item+.pt-2~.nav-item {
    margin: 0 20px;
  }

  .sidebar .nav .nav-item {
    padding: 0;
  }

  .sidebar .nav.sub-menu {
    margin-left: 20px;
    border-left: 0;
    border-radius: 0;
  }

  .sidebar .nav .nav-item .nav-link {
    padding: 10px 20px;
  }

  .sidebar .nav .nav-item+.pt-2~.nav-item .nav-link {
    padding: 10px 20px;
    border: 4px;
    border-style: groove;
    border-top: 0;
    border-bottom-width: 1px;
    margin-bottom: 10px;
    border-radius: 5px;
    color: #ffffff;
  }

  .sidebar .nav.sub-menu .nav-item .nav-link:hover,
  .sidebar .nav.sub-menu .nav-item .nav-link,
  .sidebar .nav .nav-item .nav-link .menu-title,
  .sidebar .nav .nav-item .nav-link i.menu-icon {
    color: #ffffff;
  }

  .sidebar .nav .nav-item:not(:nth-child(2)).active {
    background-color: transparent;
  }

  .sidebar .nav .nav-item:not(:nth-child(2)).active a {
    border-bottom-color: orange;
  }

  .sidebar .nav .nav-item:not(:nth-child(2))>.nav-link i {
    color: #ffffff;
    opacity: 1;
  }

  body.sidebar-icon-only .sidebar .nav .nav-item+.pt-2~.nav-item {
    margin: 0 10px;
  }

  body.sidebar-icon-only .sidebar .nav .nav-item+.pt-2~.nav-item .nav-link {
    padding: 10px !important;
  }

  body.sidebar-icon-only .sidebar-icon-only .sidebar .nav.sub-menu {
    margin-left: 0 !important;
  }

  .sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title,
  body.sidebar-icon-only .sidebar .nav .nav-item+.pt-2~.nav-item .nav-link {
    background-color: #000000 !important;
  }



  div.table-responsive>div.dataTables_wrapper>div.row:last-child>div[class^="col-"]:first-child {
    margin: 20px 0;
  }

  a.btn {
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: 500;
    font-size: 14px !important;
    letter-spacing: 0.5px;
  }

  i[title*='edit'] {
    padding: 10px;
  }

  img.sidebar-brand-logo {
    max-width: 100%;
    max-height: 50px;
  }

  .navbar .navbar-menu-wrapper .navbar-toggler {
    position: unset;
    margin-left: -1px;
  }

  .navbar .navbar-menu-wrapper .navbar-toggler {
    position: unset;
  }

  @media(min-width:992px) {
    .sidebar-icon-only .sidebar {
      width: 0;
    }

    .sidebar-icon-only .navbar .navbar-menu-wrapper {
      width: 100%;
    }

    .sidebar-icon-only .navbar {
      left: 0;
    }

    .page-body-wrapper {
      margin-left: auto;
      margin-right: unset;
    }

    .sidebar-icon-only .page-body-wrapper {
      max-width: 100%;
      width: 100%;
      margin-left: auto;
      margin-right: unset;
    }


    .sidebar-icon-only .sidebar .nav.sub-menu {
      margin: 0;
    }

    body.sidebar-icon-only .sidebar .nav .nav-item+.pt-2~.nav-item {
      margin: 0;
    }

    .sidebar-icon-only .sidebar .nav .nav-item.hover-open .collapse,
    .sidebar-icon-only .sidebar .nav .nav-item.hover-open .collapsing {
      background-color: #000000;
    }
  }

  @media(max-width:992px) {
    .content-wrapper {
      padding: 40px 20px 40px 20px;
    }

    .grid-margin>.card:nth-last-of-type(1) {
      margin-bottom: 0 !important;
    }

    .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini {
      width: auto;
    }

    .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini img {
      max-width: 100px;
    }

    .navbar .navbar-brand-wrapper {
      width: unset;
    }

    .sidebar {
      top: 0;
      z-index: 1051;
    }

    .sidebar-offcanvas.active {
      right: unset;
      max-height: 100%;
    }

    ul.profile {
      padding-left: 0 !important;
    }

    .pt-2.pb-1 {
      margin: 0 20px;
    }
  }

  @media(max-width:576px) {
    .content-wrapper {
      padding: 30px 15px 30px 15px;
    }
  }
</style>