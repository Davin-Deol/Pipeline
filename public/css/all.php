<?php
    header("Content-type: text/css; charset: UTF-8");
    require_once("Mobile-Detect-2.8.26/Mobile_Detect.php");

    function convertHexToRGB($hex, $dark = false)
    {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        
        if ($dark)
        {
            $rgb['r'] = $rgb['r'] * 0.75;
            $rgb['g'] = $rgb['g'] * 0.75;
            $rgb['b'] = $rgb['b'] * 0.75;
        }
        
        return $rgb['r'] . "," . $rgb['g'] . "," . $rgb['b'];
    }

    $xml = simplexml_load_file('../../resources/values/colours.xml');
    $colourPrimary = $xml->all->colourPrimary;
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
    background: linear-gradient(180deg, rgba(<?php echo convertHexToRGB($colourPrimary) . "," . $backgroundColourTransparency; ?>), rgba(<?php echo convertHexToRGB($colourPrimary) . "," . $backgroundColourTransparency; ?>)), url("../img/Background-Images/2.jpg") repeat;
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

footer {
    padding-top: 40px;
}

hr.dark {
    border-top: 2px solid rgb(<?php echo convertHexToRGB($colourPrimary, true); ?>);
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

.footer-copyright {
    background-color: rgb(<?php echo convertHexToRGB($colourPrimary, true); ?>);
    padding: 1.5em 40px;
    margin-top: 2.5em;
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
    background-color: <?php echo $colourPrimary; ?>;
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

.validationError {
    color: #D00;
    font-size: 0.8em;
    display: none;
}

.button {
    color: <?php echo $textColourOnPrimary; ?>;
    background-color: <?php echo $colourPrimary; ?>;
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
    color: <?php echo $colourPrimary; ?>;
    background-color: white;
    border: 2px solid <?php echo $colourPrimary; ?>;
    font-size: 1em;
    padding: 10px 0;
    font-weight: 400;
    width: 100%;
}

.reviewImage {
    height: 3em;
    margin: 0.5em;
}

#cookiePopup {
    background-color: #EEE;
    border-bottom: 1px solid #DDD;
    padding: 1%;
    position: fixed;
    top: 0;
    z-index: 1;
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
    /* padding-top: 2em; Location of the box */
    padding-bottom: 2em; /* Location of the box */
    left: 0;
    top: 0;
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    /* background-color: rgb(0,0,0); Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    font-weight: 400;
    font-size: 1.2em;
    border 2px solid transparent;
}

#successMessageModal, #errorMessageModal {
    background-color: rgba(0,0,0,0);
}

#successModalContent {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

#errorModalContent {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
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
    color:<?php echo $colourPrimary; ?>;
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

.glyphicon.secondary {
    color: <?php echo $colourPrimary; ?>;
}






input:focus{
    outline: none;
}

input, select, textarea {
    border: none;
    border-bottom: 1px solid #EEE;
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
  stroke: <?php echo $colourPrimary; ?>;
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
  box-shadow: inset 0px 0px 0px <?php echo $colourPrimary; ?>;
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
    box-shadow: inset 0px 0px 0px 30px <?php echo $colourPrimary; ?>;
  }
}


.profileImage {
    width: 2em;
    height: 2em;
    margin-top: -0.4em;
    margin-right: 0.7em;
    border-radius: 100%;
    background-color: <?php echo $colourPrimary; ?>;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.navbar {
    background-color: <?php echo $colourPrimary; ?>;
    border: transparent;
    font-size: 1.1em;
    font-family: futura;
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-brand {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar .navbar-nav>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
    cursor: pointer;
}
.navbar-nav>.open>a,
.navbar-nav>.open>a:focus,
.navbar-nav>.open>a:hover,
.navbar-nav .open .dropdown-menu>li>a:hover {
    color: <?php echo $colourPrimary; ?>;
    background-color: <?php echo $textColourOnPrimary; ?>;
}

.navbar .navbar-nav>li>a:focus,
.navbar .navbar-nav>li>a:hover {
    color: <?php echo $textColourOnPrimary; ?>;
    background-color: <?php echo $colourPrimary; ?>;
}

.navbar-nav .open .dropdown-menu>li>a {
    color: <?php echo $textColourOnPrimary; ?>;
}
.navbar-nav>li>.dropdown-menu {
    background-color:  <?php echo $colourPrimary; ?>;
}
.nav>li>a>img {
    width: 2em;
    height: 2em;
    margin-top: -0.4em;
    margin-right: 0.7em;
    border-radius: 100%;
    background-color: <?php echo $colourPrimary; ?>;
}
.navbar-toggle,
.icon-bar {
    border: 1px solid <?php echo $textColourOnPrimary; ?>;
}
.attachToNav {
    background-color: rgb(<?php echo convertHexToRGB($colourPrimary, true); ?>);
    color: white;
    margin-bottom: 1em;
    margin-top: -20px;
}
.attachToNav .label-cbx input:checked+.checkbox svg path {
    fill: white;
}
.attachToNav .label-cbx .checkbox svg polyline {
    stroke: rgb(<?php echo convertHexToRGB($colourPrimary, true); ?>);
}
.attachToNav .label-cbx input:checked+.checkbox {
    border-color: white;
}
.attachToNav select, .attachToNav input {
    color: black;
}



.label-cbx {
    user-select: none;
    cursor: pointer;
    margin-bottom: 0;
    font-size: 1em;
    line-height: 25px;
}

.label-cbx input:checked+.checkbox {
    border-color: #136cb2;
}

.label-cbx input:checked+.checkbox svg path {
    fill: #136cb2;
}

.label-cbx input:checked+.checkbox svg polyline {
    stroke-dashoffset: 0;
}

.label-cbx:hover .checkbox svg path {
    stroke-dashoffset: 0;
}

.label-cbx .checkbox {
    float: left;
    margin: 0.2em 10px 0px;
    border: 2px solid #AAA;
    border-radius: 3px;
    height: 1.6em;
    /*width: 1.3em;*/
}

.label-cbx .checkbox svg path {
    z-index: 1;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 3.8em;
    stroke-dashoffset: 3.8em;
}

.label-cbx .checkbox svg polyline {
    fill: none;
    stroke: #FFF;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    height: 1.3em;
    width: 1.3em;
    transition: all 0.3s ease;
}

.label-cbx>span {
    pointer-events: none;
    vertical-align: middle;
}

.invisible {
    display: none;
}

svg {
    width: 1.3em;
    height: 1.3em;
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