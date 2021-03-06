<?php
    header("Content-type: text/css; charset: UTF-8");

    $xml = simplexml_load_file('../res/values/colours.xml');
    $colourPrimary = $xml->all->colourPrimary;
    $textColourOnPrimary = $xml->all->textColourOnPrimary;
    $backgroundColourTransparency = $xml->all->backgroundColourTransparency;
?>
#header {
    height: 10vh;
    position: fixed;
    z-index: 1;
}
#loginSection {
    width: auto;
    width: 100px;
}
#loginButton {
    margin: 0;
    padding: 0;
}

#loginButton {
    width: 100px; /* Sets the width and automatically the height */
    margin-bottom: -20px; /* Makes the button align with the options */
    margin-left: 10vw; /* Puts some distance between the button and the left side of the window */
}

.allTextSections {
    padding: 40px;
}

#topSection span {
    display: inline-block;
    line-height: normal;
    vertical-align: middle;
}

#contactSection {
    padding: 10px;
}

.demo a:hover {
  opacity: .5;
}

#downButtonSection a span {
    width: 46px;
    height: 46px;
    margin-left: -23px;
    border: 1px solid #fff;
    margin-top: 20vh;
}
#downButtonSection a span::after {
  width: 16px;
  height: 16px;
  margin: -12px 0 0 -8px;
  border-left: 1px solid #fff;
  border-bottom: 1px solid #fff;
}
h1 {
    font-weight: 100;
    font-size: 10em;
    margin-bottom: 0;
}

h2 {
    font-weight: 300;
    font-size: 5em;
}

h3 {
    text-align: center;
    font-size: 3em;
}

h4 {
    font-size: 2.5em;
}

p {
    position: relative;
    margin: 0 auto;
    font-size: 1.2em;
}

ol {
    font-size: 1.2em;
}

/* All links will have the same font colour as the other text in its div */
a {
    color: inherit;
    text-decoration: none;
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

.row p {
    width: 100%;
}




.modal {
    padding-top: 8em; /* Location of the box */
    padding-bottom: 8em; /* Location of the box */
}



.topNavBarDiv{
    background-color: #283593;
}
.navbar-default .navbar-toggle .icon-bar {
    background-color: white;
}
.navbar-default .navbar-toggle:focus .icon-bar, .navbar-default .navbar-toggle:hover .icon-bar {
    background-color: #136cb2;
}
.container-fluid>.navbar-header {
    color: white;
}
.navbar-default .navbar-brand {
    color: white;
}
.navbar-default {
    background-color: #136cb2;
    border: transparent;
}
.navbar-default .navbar-nav>li>a {
    color: white;
}
.navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {
    background-color: white;
}
.navbar-default .navbar-toggle {
    border-color: white;
}
.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover {
    color: #136cb2;
    background-color: white;
}
.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover {
    color: white;
    background-color: #136cb2;
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a {
    color: white;
}
.navbar-nav>li>.dropdown-menu {
    background-color:  #136cb2;
}
.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
    background-color:  white;
    color: #136cb2;
}
.navbar-default .navbar-brand:focus, .navbar-default .navbar-brand:hover {
    color: white;
}