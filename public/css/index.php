<?php
    header("Content-type: text/css; charset: UTF-8");
    require_once("Mobile-Detect-2.8.26/Mobile_Detect.php");

    $xml = simplexml_load_file('../../resources/values/colours.xml');
    $colourPrimary = $xml->all->colourPrimary;
    $textColourOnPrimary = $xml->all->textColourOnPrimary;
    $backgroundColourTransparency = $xml->all->backgroundColourTransparency;
?>
html, body {
    font-family: "Helvetica Neue", HelveticaNeue, "TeX Gyre Heros", TeXGyreHeros, FreeSans, "Nimbus Sans L", "Liberation Sans", Arimo, Helvetica, Arial, sans-serif;
    height: 100vh;
    width: 100vw;
    margin: 0;
    background: none;
}

html {
    background: linear-gradient( rgba(19, 108, 178, 0.2), rgba(19, 108, 178, 0.2)),
    url("../../public/img/Index/Top-Section/Bridge.jpg");
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat no-repeat;
    background-position: 70% 0%;
    overflow: scroll;
}

h1 {
    font-weight: 100;
    font-size: 5em;
}

h2 {
    font-weight: 300;
}

h3 {
    text-align: center;
}

p {
    width: 90%;
    margin: 0 auto;
}

#topSection {
    color: #FFFFFF;
    text-align: center;
    height: 95vh;
    line-height: 85vh;
    text-shadow: 4px 4px 4px #000000;
}

#topSection h4 {
    font-weight: 300;
    margin: 0 auto;
    width: 90%;
}

#topSection span {
    display: inline-block;
    line-height: normal;
    vertical-align: middle;
}

#downButtonSection a {
    padding-top: 0px;
}

#downButtonSection a span {
    position: absolute;
    left: 50%;
    width: 46px;
    height: 46px;
    margin-left: -23px;
    border: 1px solid #fff;
    border-radius: 100%;
    box-sizing: border-box;
    margin-top: 15vh;
}

#downButtonSection a span::after {
    position: absolute;
    top: 50%;
    left: 50%;
    content: '';
    width: 16px;
    height: 16px;
    margin: -12px 0 0 -8px;
    border-left: 1px solid #fff;
    border-bottom: 1px solid #fff;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    box-sizing: border-box;
}

.fadeIn {
    opacity: 0;
}

.modal h2 {
    font-size: 5em;
}

a {
    text-decoration: none;
}

.alternativeOptions {
    border: none;
    background-color: #FFF;
    cursor: pointer;
    color: #136cb2;
    font-size: 1em;
}

.alternativeTwoBtn {
    float: right;
}
/*

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
*/
@-webkit-keyframes cardEnter {
    0%,
    20%,
    40%,
    60%,
    80%,
    100% {
        -webkit-transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    0% {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
    }
    20% {
        -webkit-transform: scale3d(1.1, 1.1, 1.1);
    }
    40% {
        -webkit-transform: scale3d(0.9, 0.9, 0.9);
    }
    60% {
        opacity: 1;
        -webkit-transform: scale3d(1.03, 1.03, 1.03);
    }
    80% {
        -webkit-transform: scale3d(0.97, 0.97, 0.97);
    }
    100% {
        opacity: 1;
        -webkit-transform: scale3d(1, 1, 1);
    }
}

@keyframes cardEnter {
    0%,
    20%,
    40%,
    60%,
    80%,
    100% {
        -webkit-transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    0% {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
    }
    20% {
        -webkit-transform: scale3d(1.1, 1.1, 1.1);
        transform: scale3d(1.1, 1.1, 1.1);
    }
    40% {
        -webkit-transform: scale3d(0.9, 0.9, 0.9);
        transform: scale3d(0.9, 0.9, 0.9);
    }
    60% {
        opacity: 1;
        -webkit-transform: scale3d(1.03, 1.03, 1.03);
        transform: scale3d(1.03, 1.03, 1.03);
    }
    80% {
        -webkit-transform: scale3d(0.97, 0.97, 0.97);
        transform: scale3d(0.97, 0.97, 0.97);
    }
    100% {
        opacity: 1;
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1);
    }
}

.radio {
    display: inline-block;
    font-size: 1em;
    cursor: pointer;
}

.radio:hover .inner {
    -webkit-transform: scale(0.5);
    transform: scale(0.5);
    opacity: .5;
}

.radio input {
    height: 1px;
    width: 1px;
    opacity: 0;
}

.radio input:checked+.outer .inner {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
}

.radio input:checked+.outer {
    border: 3px solid #f08b3b;
}

.radio input:focus+.outer .inner {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
    background-color: #e67012;
}

.radio .outer {
    /*height: 20px;
  width: 20px;*/
    display: block;
    float: left;
    border: 3px solid #0c70b4;
    border-radius: 50%;
    background-color: #fff;
    margin-right: 0.5em;
}

.radio .inner {
    -webkit-transition: all 0.25s ease-in-out;
    transition: all 0.25s ease-in-out;
    height: 0.6em;
    width: 0.6em;
    -webkit-transform: scale(0);
    transform: scale(0);
    display: block;
    margin: 2px;
    border-radius: 50%;
    background-color: #f08b3b;
    opacity: 0;
}

<?php
$detect = new Mobile_Detect;
if (!$detect->isMobile() || $detect->isTablet()) { ?>
    h1 {
        font-size: 10em;
    }

    #downButtonSection a span {
        margin-top: 20vh;
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
<?php } ?>