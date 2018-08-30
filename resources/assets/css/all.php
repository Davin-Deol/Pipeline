<?php
    header("Content-type: text/css; charset: UTF-8");

    $xml = simplexml_load_file('../res/values/colours.xml');
    $colourPrimary = $xml->all->colourPrimary;
    $textColourOnPrimary = $xml->all->textColourOnPrimary;
    $backgroundColourTransparency = $xml->all->backgroundColourTransparency;
?>
body {
    background: linear-gradient(180deg, rgba(<?php echo $colourPrimary . "," . $backgroundColourTransparency; ?>), rgba(<?php echo $colourPrimary . "," . $backgroundColourTransparency; ?>)), url("../Images/Background-Images/2.jpg") repeat;
    background-size:cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: 70% 0%;
    height: 100vh;
}

h1 {
    font-size: 5em;
}

h2 {
    font-size: 2em;
    margin-top: 0;
    font-weight: 300;
}

h3 {
    font-size: 2.5em;
}


h4 {
    font-size: 1.1em;
}

footer h6 {
    font-size: 1.3em;
}
footer hr {
    border-top: 2px solid white;
}
.page-footer p {
    width: 100%;
    font-size: 1.2em;
}
.page-footer a {
    color: white;
}

.allTextSections {
    padding: 7% 0;
}

.textSectionWithLightBackground {
    color: #000000;
    background-color: #FFFFFF;
}

.textSectionsWithDarkBackground {
    color: #FFFFFF;
    background-color: rgb(<?php echo $colourPrimary; ?>);
}

.leftNavbar{
    color:black;
}

.navBarDiv{
    background-color: #bbdefb;
    height: 100vh;
}

.icon{
    margin-left:  30px;
}

.header{
    background-color: #0d47a1;
}

.topNavBarDiv{
    background-color: #283593;
}

.intro{
    width: 500px;
}

.field {
    background-color: white;
    box-shadow: 5px 5px rgba(150, 150, 150, 0.8);
    border: 1px solid #AAA;
    padding: 5%;
    margin: 0 auto;
    margin-bottom: 1em;
    width: auto;
}

.field h1 {
    font-size: 2.3em;
    margin-bottom: 0.5em;
}

.button {
    color: <?php echo $textColourOnPrimary; ?>;
    background-color: rgb(<?php echo $colourPrimary; ?>);
    cursor: pointer;
    border-radius: 10px;
    height: auto;
    width: 100%;
    font-size: 1em;
    margin: 0;
    padding: 10px 0;
    font-weight: 400;
    word-wrap:break-word;
}

.twoButtons {
    width: 50%;
}

.threeButtons {
    width: 33%;
}
.fourButtons {
    width: 25%;
}

.button:hover {
    background-color: #AAA;
    transition: 0.3s;
}

dt {
    margin-top: 10px;
}

input[type=file] {
    display: none !important;
    visibility: hidden;
}

input[type=file]+label {
    text-align: center;
    color: rgb(<?php echo $colourPrimary; ?>);
    background-color: white;
    border: 2px solid rgb(<?php echo $colourPrimary; ?>);
    font-size: 1em;
    padding: 10px 0;
    font-weight: 400;
    width: 100%;
}

.reviewImage {
    width: 15vw;
    height: 15vw;
    overflow: hidden;
    float: left;
    position: relative;
}
.reviewImageMain {
    width: 50vw;
    height: 50vw;
    margin-bottom: 3vw;
    left: 12vw;
}
.slider-nav {
    width: 90%;
    margin: 0 auto 2em;
}

.modalImage {
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    display: none;
    height: 100%; /* Full height */
    justify-content: center;
    left: 0;
    overflow: auto; /* Fallback color */
    position: fixed; /* Stay in place */
    top: 0;
    width: 100%; /* Full width */
    z-index: 2; /* Location of the box */
}

.modal {
    display: none;
    position: fixed; /* Stay in place */
    z-index: 2; /* Sit on top */
    padding-top: 2em; /* Location of the box */
    padding-bottom: 2em; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal p {
    font-weight: 400;
    font-size: 3vh;
}

.modal-content {
    background-color: #aaffaa;
    border-radius: 1em;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.modal-content.form {
    background-color: white;
    width: 100%;
}

.modal-content.form .modal-header {
    text-align: center;
}

.modal-content.form .modal-body {
    font-size: 2em;
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-content {
    font-size: 0.5em;
}

/* Modal Content */

.modal-image {
    display: inline-block;
    position: relative;
}


/* The Close Button */

.closeImage {
    font-size: 1em;
    position: absolute;
    color:rgb(<?php echo $colourPrimary; ?>);
    font-size: 3em;
    font-weight: 900;
    top: 37%;
    -webkit-text-stroke-width: 2px;
   -webkit-text-stroke-color: white;
}

#displayImage {
    width: auto;
    max-height: 90vh;
    max-width: 70vw;
}

.crop {
    position: relative;
}
table {
    margin-bottom: 5%;
    width:100%;
}








input:focus{
    outline: none;
}

input {
    border: none;
    border-bottom: 1px solid #EEE;
    font-size: 1.2em;
    width: 100%;
    margin-bottom: 10px;
}

label {
    font-size: 0.8em;
    font-weight: 400;
}

*:focus {
    outline: none;
}




.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: rgb(<?php echo $colourPrimary; ?>);
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #fff;
  stroke-miterlimit: 10;
  margin: 10% auto;
  box-shadow: inset 0px 0px 0px rgb(<?php echo $colourPrimary; ?>);
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes scale {
  0%, 100% {
    transform: none;
  }
  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}
@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px rgb(<?php echo $colourPrimary; ?>);
  }
}



.nav>li>a>img {
    width: 2em;
    height: 2em;
    margin-top: -0.4em;
    margin-right: 0.7em;
    border-radius: 100%;
    background-color: rgb(<?php echo $colourPrimary; ?>);
}
.nav>li {
    font-size: 1.1em;
    font-family: futura;
}
.navbar-default .navbar-toggle .icon-bar {
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-toggle:focus .icon-bar, .navbar-default .navbar-toggle:hover .icon-bar {
    background-color: rgb(<?php echo $colourPrimary; ?>);
}
.container-fluid>.navbar-header {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-brand {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default {
    background-color: rgb(<?php echo $colourPrimary; ?>);
    border: transparent;
}
.navbar-default .navbar-nav>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-toggle {
    border-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover {
    color: rgb(<?php echo $colourPrimary; ?>);
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover {
    color: <?php echo $textColourOnPrimary; ?>;
    background-color: rgb(<?php echo $colourPrimary; ?>);
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-nav>li>.dropdown-menu {
    background-color:  rgb(<?php echo $colourPrimary; ?>);
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
    background-color:  <?php echo $textColourOnPrimary; ?>;
    color: rgb(<?php echo $colourPrimary; ?>);
}
.navbar-default .navbar-brand:focus, .navbar-default .navbar-brand:hover {
    color: <?php echo $textColourOnPrimary; ?>;
}