<style>
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');

  .landing_page .bottom_content {
    /* padding-left: 15px; */
    /* padding-right: 15px; */
    position: relative;
    z-index: 5;
  }

  .container {
    padding-left: 15px;
    padding-right: 15px;
  }

  .row {
    margin-left: -15px;
    margin-right: -15px;
  }

  body {
    font-family: 'Open Sans', sans-serif;
    color: #000000;
  }

  p,
  a,
  span {
    font-family: 'Open Sans', sans-serif;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  span,
  a {
    /* color: #000000; */
  }

  .top_bar img {
    width: auto;
    height: auto;
    max-width: 100%;
    max-width: 90px;
  }

  body {
    background-color: rgb(195 200 227 / 63%);
    background-color: #ffffff;
  }

  .landing_page {
    overflow: visible;
    background: linear-gradient(to right, #0310ef, #0031aa);
    padding: 210px 0px 200px;
    position: relative;
    height: calc(100vh - 118px);
    z-index: 10;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .landing_page:after {
    position: absolute;
    content: "";
    top: 0;
    height: 100%;
    width: 100%;
    background-repeat: no-repeat;
    background-image: url(https://html.themexriver.com/Saasio/assets/img/app-landing/shape/bl-shape.png);
    z-index: 1;
  }

  .bg-white {
    border: 0 !important;
  }

  .top_bar {
    box-shadow: unset;
    padding: 15px 0px;
    top: 10px;
    width: 100%;
    z-index: 10;
    position: absolute;
  }

  .top_bar .container {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
  }

  .top_bar img {
    margin: 0;
  }

  .landing_page {}

  .landing_page .sign_in_collapse {}

  .landing_page .sign_in_wrapper {
    position: relative;
  }

  .landing_page .sign_in_collapse {
    position: absolute;
    right: 0;
    top: 60px;
    height: 100%;
    width: 350px;
    z-index: 10;
    height: 354px;
  }

  .landing_page .sign_in_collapse .card {
    background-color: rgba(255, 255, 255, 0.9);
  }

  .landing_page .sign_in_collapse .card form {
    position: relative;
    z-index: 2;
  }

  .landing_page .sign_in_collapse .card:after {
    background-image: url(https://cdn.pixabay.com/photo/2017/09/20/16/59/smart-home-2769239_960_720.jpg);
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
  }

  form .form-group {
    margin-bottom: 30px;
  }

  form h1 {
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 25px;
  }

  form p {
    margin-bottom: 0;
  }

  .loginpading {
    padding: 0;
  }

  .bottom_content {
    color: #ffffff;
  }

  .bottom_content>.container>.row {
    background-color: unset;
    margin: 0;
    align-items: center;
  }


  .sign_in_collapse h1.title,
  .services h1.title {
    color: #000000;
  }

  .sign_in_collapse h1.title {
    font-size: 30px;
  }

  h1.title {
    color: #ffffff;
    font-weight: bold;
    font-size: 35px;
    margin-top: 0;
    margin-bottom: 25px;
  }

  h1.title.home {
    font-size: 50px;
    font-weight: 900;
  }

  .bottom_content h5 {
    line-height: 1.6;
    font-weight: 400;
    font-size: 19px;
  }

  footer {
    background: transparent;
    background: #000000;
    padding: 50px 0 10px 0 !important;
    color: #ffffff;
    text-align: center;
    position: relative;
    margin-top: 0;
    font-size: 14px;
  }


  footer:after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: -43px;
    width: 80%;
    height: 80px;
    background: linear-gradient(to right, #0310ef, #0031aa);
    border-radius: 50%;
    z-index: 1;
    margin: auto;
  }

  footer ul {
    list-style: none;
    margin-bottom: 0;
    padding-left: 0;
  }

  footer ul li {
    display: inline-block;
    margin-left: 15px;
  }

  footer span {
    color: #ffffff;
  }

  .clients {
    padding: 40px 0;
    margin: 0;
  }



  @keyframes move_wave {
    0% {
      transform: translateX(0) translateZ(0) scaleY(1)
    }

    50% {
      transform: translateX(-25%) translateZ(0) scaleY(0.55)
    }

    100% {
      transform: translateX(-50%) translateZ(0) scaleY(1)
    }
  }

  .navbar-links {
    display: flex;
    margin-left: auto;
    justify-content: flex-end;
    list-style: none;
    margin-bottom: 0;
    margin-right: 20px;
    margin-top: 10px;
  }

  .navbar-links li {}

  .navbar-links li a {
    color: #ffffff;
    padding: 8px 20px;
    white-space: nowrap;
  }


  @media(max-width:1200px) {}

  @media(max-width:992px) {}

  @media(max-width:576px) {}

  @media(max-width:576px) {
    body section {
      margin: 25px 10px;
      box-shadow: -6px -5px 12px hsl(0deg 0% 62% / 20%), 6px 5px 12px hsl(0deg 0% 62% / 40%);
      padding: 20px 0 !important;
      border-radius: 10px;
      overflow: hidden;
    }


    body section.landing_page {
      padding: 130px 0 140px 0 !important;
      box-shadow: -6px -5px 12px hsl(0deg 0% 62% / 20%), 6px 5px 12px hsl(0deg 0% 62% / 0%);
      overflow: hidden;
      margin: 10px 10px 0 10px;
      border-radius: 10px 10px 0 0;
    }

    footer {
      margin-top: 0px;
    }

    body section.copyright-area {
      padding: 0 !important;
      margin: 0px 10px 10px 10px;
      box-shadow: unset;
      border-radius: 0 0 10px 10px;
      overflow: hidden;
    }

    .landing_page .sign_in_collapse {
      width: 280px;
    }

    .icons_wrapper i {
      font-size: 80px;
      line-height: 1;
    }

    .icons_wrapper {
      margin-bottom: 0;
    }

    .top_bar {
      padding: 0;
    }

    h1.title.home {
      margin-bottom: 10px;
      font-size: 30px;
    }

    .bottom_content h5 {
      font-size: 16px;
    }

    .anim_pic {
      margin-top: 30px;
    }

    .landing_page {
      padding: 100px 0 140px 0;
      height: unset;
    }

    .anim_pic {
      text-align: left;
    }

    .anim_pic img {
      max-height: 150px;
    }


    .top_bar img {
      max-width: 90px;
    }


    form .form-group {
      margin-bottom: 15px;
    }

    form .form-group label {
      padding: 0;
    }
  }
</style>