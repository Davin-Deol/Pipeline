<?php
    header("Content-type: text/css; charset: UTF-8");
    require_once("Mobile-Detect-2.8.26/Mobile_Detect.php");

    function convertHexToRGB($hex)
    {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        return $rgb['r'] . "," . $rgb['g'] . "," . $rgb['b'];
    }

    $xml = simplexml_load_file('../../resources/values/colours.xml');
    $colourPrimary = convertHexToRGB($xml->all->colourPrimary);
    $textColourOnPrimary = $xml->all->textColourOnPrimary;
    $backgroundColourTransparency = $xml->all->backgroundColourTransparency;
?>
html, body {
    margin: 0;
    background: none;
    height: 100vh;
    width: 100vw;
}

html {
    background: linear-gradient(180deg, rgba(<?php echo $colourPrimary . "," . $backgroundColourTransparency; ?>), rgba(<?php echo $colourPrimary . "," . $backgroundColourTransparency; ?>)), url("../img/Background-Images/2.jpg") repeat;
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: 70% 0%;
    overflow: scroll;
}

h1 {
    font-weight: 300;
    font-size: 2.3em;
}

h2 {
    font-size: 2.5em;
}

h3 {
    font-size: 1.7em;
    margin-top: 0;
    font-weight: 300;
}

h4 {
    font-size: 1.1em;
}

footer h6 {
    font-size: 1.3em;
    margin-top: 10%;
}
footer hr {
    border-top: 2px solid white;
}
footer hr.header {
    width: 15%;
    margin-top: 0px;
    margin-bottom: 0.5em;
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

.icon {
    margin-left:  30px;
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
    text-align: center;
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
    display: inline-block;
    text-align: center;
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
    height: 3em;
    margin: 0.5em;
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
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    font-weight: 400;
}

.modal span {
    font-size: 1.2em;
}

.modal .button {
    margin-top: 1em;
}

.modal-content {
    background-color: #eee;
    border-radius: 1em;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    float: none;
}

.modal-content.form {
    background-color: white;
}

.modal-content.form .modal-header {
    text-align: center;
}

.modal span.close {
    float: right;
    font-weight: bold;
}

.modal span.close:hover, .modal span.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
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








input:focus{
    outline: none;
}

input, select, textarea {
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


.profileImage {
    width: 2em;
    height: 2em;
    margin-top: -0.4em;
    margin-right: 0.7em;
    border-radius: 100%;
    background-color: rgb(<?php echo $colourPrimary; ?>);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
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
.navbar .navbar-toggle .icon-bar {
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-toggle:focus .icon-bar, .navbar .navbar-toggle:hover .icon-bar {
    background-color: rgb(<?php echo $colourPrimary; ?>);
}
.container-fluid>.navbar-header {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-brand {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar {
    background-color: rgb(<?php echo $colourPrimary; ?>);
    border: transparent;
}
.navbar .navbar-nav>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-toggle:focus, .navbar .navbar-toggle:hover {
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-toggle {
    border-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-nav>.open>a, .navbar .navbar-nav>.open>a:focus, .navbar .navbar-nav>.open>a:hover {
    color: rgb(<?php echo $colourPrimary; ?>);
    background-color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-nav>li>a:focus, .navbar .navbar-nav>li>a:hover {
    color: <?php echo $textColourOnPrimary; ?>;
    background-color: rgb(<?php echo $colourPrimary; ?>);
}
.navbar .navbar-nav .open .dropdown-menu>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-nav>li>.dropdown-menu {
    background-color:  rgb(<?php echo $colourPrimary; ?>);
}
.navbar .navbar-nav .open .dropdown-menu>li>a:hover {
    background-color:  <?php echo $textColourOnPrimary; ?>;
    color: rgb(<?php echo $colourPrimary; ?>);
}
.navbar .navbar-brand:focus, .navbar .navbar-brand:hover {
    color: <?php echo $textColourOnPrimary; ?>;
}
<?php
$detect = new Mobile_Detect;
if (!$detect->isMobile() || $detect->isTablet()) { ?>
    #header {
        height: 10vh;
        position: fixed;
        z-index: 1;
    }

    h1 {
        margin: 0;
    }

    h3 {
        font-size: 1.7em;
    }

    h4 {
        font-size: 1.7em;
    }

    b, p {
        position: relative;
        margin: 0 auto;
        font-size: 1.2em;
    }

    ol {
        font-size: 1.2em;
    }

    .row p {
        width: 100%;
    }

    .modal-content {
        margin-top: 10%;
    }

    .field {
        width: 80%;
        font-size: 1.2em;
    }

    .content {
        width: 80%;
        margin: 0 auto;
    }

    #profileImageDisplay {
        display: block;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }
    
    input[type=file]+label {
        display: block;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }
<?php } ?>