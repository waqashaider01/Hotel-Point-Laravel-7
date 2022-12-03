<!DOCTYPE html>
<html>
<head>
	<title>HotelPoint</title>
	<meta charset='utf-8'>
      <meta name='viewport' content='width=device-width,initial-scale=1'>
      <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'/>
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns' crossorigin='anonymous'></script>
      <link href="{{ asset('css/mylist.css') }}" rel="stylesheet" type="text/css" />
      <style type="text/css">
        html,
  body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #fff;
}
   p{
    margin: 10px !important;
   }
      	.infbtn{
			border:1px solid #D5D8DC;
			border-radius:2px;
			padding:3px 10px 3px 10px;
			font-size:16px;
			margin-right:5px;
			
		}
		.infocard{
			background-color:white;
			width:100%;
			height:100%;
			padding:0%;
			border-radius:5px;
			/*box-shadow: 2px 5px #f4f0ec !important;*/
			box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px !important;

		}
      	#successmsg .checkmark__circle {
        stroke-dasharray: 216; 
        stroke-dashoffset: 216; 
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #7ac142;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

     #successmsg .checkmark {
        width: 106px; 
        height: 106px; 
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        margin: 10% auto;
        box-shadow: inset 0px 0px 0px #7ac142;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    #successmsg .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 98; 
        stroke-dashoffset: 98; 
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
          box-shadow: inset 0px 0px 0px 80px #7ac142;
        }
    }

    .checkmark__circle_cross {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #FF0000;
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}
.checkmark_cross {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #fff;
  stroke-miterlimit: 10;
  margin: 10% auto;
  box-shadow: inset 0px 0px 0px #FF0000;
  animation: crossfill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}
.checkmark__check_cross {
  transform-origin: 50% 50%;
  stroke-dasharray: 29;
  stroke-dashoffset: 29;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}


     @keyframes crossfill {
        100% {
          box-shadow: inset 0px 0px 0px 80px #FF0000;
        }
    }

 .mycontainer {
  width: 50%;
  height: 180px;
  background: transparent;
  margin-top: 10px;
  position: relative;
  padding: 0;
  text-align: center;
  margin: 0 auto!important;
  /*box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.25);*/
}

.icon-wrapper,
.icon-wrapper-2 {
  font-size: 40px;
  text-align: center;
  margin-top: 70px;
  position: relative;
  cursor: pointer;
  display: inline-block;
}
.icon-wrapper .icon,
.icon-wrapper-2 .icon {
  color: #90a4ae;
}
.icon-wrapper .icon i,
.icon-wrapper-2 .icon i {
  transform: scale(1);
}
.icon-wrapper.anim .icon,
.icon-wrapper-2.anim .icon {
  color: green;
}
.icon-wrapper.anim .icon i,
.icon-wrapper-2.anim .icon i {
  -webkit-animation: icon-animation cubic-bezier(0.165, 0.84, 0.44, 1) 1.2s;
          animation: icon-animation cubic-bezier(0.165, 0.84, 0.44, 1) 1.2s;
}
.icon-wrapper .myborder,
.icon-wrapper-2 .myborder {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 80px;
  height: 80px;
  margin-left: -40px;
  margin-top: -40px;
  z-index: 0;
  transition: all ease 0.5s;
  transform-origin: 0px 0px;
}
.icon-wrapper .myborder span,
.icon-wrapper-2 .myborder span {
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 1px solid green;
  transform: scale(0.1);
}
.icon-wrapper.anim .myborder span,
.icon-wrapper-2.anim .myborder span {
  -webkit-animation: border-animation cubic-bezier(0.075, 0.82, 0.165, 1) 1s;
          animation: border-animation cubic-bezier(0.075, 0.82, 0.165, 1) 1s;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
}
.icon-wrapper .satellite,
.icon-wrapper-2 .satellite {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 80px;
  height: 80px;
  margin-left: -40px;
  margin-top: -40px;
}
.icon-wrapper .satellite span,
.icon-wrapper-2 .satellite span {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin-top: -10px;
  margin-left: -10px;
  transition: all ease 0.5s;
  transform-origin: center 0px;
  transform: translate(0, 0) scale(0);
  -webkit-animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
          animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
  -webkit-animation-duration: 1.5s;
          animation-duration: 1.5s;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
}
.icon-wrapper.anim .satellite span:nth-child(1),
.icon-wrapper-2.anim .satellite span:nth-child(1) {
  top: 0;
  left: 50%;
  background: #988ade;
  -webkit-animation-name: satellite-top;
          animation-name: satellite-top;
}
.icon-wrapper.anim .satellite span:nth-child(2),
.icon-wrapper-2.anim .satellite span:nth-child(2) {
  top: 25%;
  left: 100%;
  background: #de8aa0;
  -webkit-animation-name: satellite-top-right;
          animation-name: satellite-top-right;
}
.icon-wrapper.anim .satellite span:nth-child(3),
.icon-wrapper-2.anim .satellite span:nth-child(3) {
  top: 75%;
  left: 100%;
  background: #8aaede;
  -webkit-animation-name: satellite-bottom-right;
          animation-name: satellite-bottom-right;
}
.icon-wrapper.anim .satellite span:nth-child(4),
.icon-wrapper-2.anim .satellite span:nth-child(4) {
  top: 100%;
  left: 50%;
  background: #8adead;
  -webkit-animation-name: satellite-bottom;
          animation-name: satellite-bottom;
}
.icon-wrapper.anim .satellite span:nth-child(5),
.icon-wrapper-2.anim .satellite span:nth-child(5) {
  top: 75%;
  left: 0;
  background: #dec58a;
  -webkit-animation-name: satellite-bottom-left;
          animation-name: satellite-bottom-left;
}
.icon-wrapper.anim .satellite span:nth-child(6),
.icon-wrapper-2.anim .satellite span:nth-child(6) {
  top: 25%;
  left: 0;
  background: #8ad1de;
  -webkit-animation-name: satellite-top-left;
          animation-name: satellite-top-left;
}

@-webkit-keyframes border-animation {
  0% {
    border-width: 20px;
    opacity: 1;
  }
  40% {
    opacity: 1;
  }
  100% {
    transform: scale(1.2);
    border-width: 0px;
    opacity: 0;
  }
}

@keyframes border-animation {
  0% {
    border-width: 20px;
    opacity: 1;
  }
  40% {
    opacity: 1;
  }
  100% {
    transform: scale(1.2);
    border-width: 0px;
    opacity: 0;
  }
}
@-webkit-keyframes satellite-top {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(0, -140px);
  }
}
@keyframes satellite-top {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(0, -140px);
  }
}
@-webkit-keyframes satellite-bottom {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(0, 140px);
  }
}
@keyframes satellite-bottom {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(0, 140px);
  }
}
@-webkit-keyframes satellite-top-right {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(125.2236135957px, -62.6118067979px);
  }
}
@keyframes satellite-top-right {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(125.2236135957px, -62.6118067979px);
  }
}
@-webkit-keyframes satellite-bottom-right {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(125.2236135957px, 62.6118067979px);
  }
}
@keyframes satellite-bottom-right {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(125.2236135957px, 62.6118067979px);
  }
}
@-webkit-keyframes satellite-bottom-left {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(-125.2236135957px, 62.6118067979px);
  }
}
@keyframes satellite-bottom-left {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(-125.2236135957px, 62.6118067979px);
  }
}
@-webkit-keyframes satellite-top-left {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(-125.2236135957px, -62.6118067979px);
  }
}
@keyframes satellite-top-left {
  0% {
    transform: scale(1) translate(0, 0);
  }
  100% {
    transform: scale(0) translate(-125.2236135957px, -62.6118067979px);
  }
}
@-webkit-keyframes icon-animation {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes icon-animation {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
.icon-wrapper-2 .spark {
  position: relative;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  position: absolute;
  left: 50%;
  top: 50%;
  margin-left: -40px;
  margin-top: -40px;
}
.icon-wrapper-2 .spark span {
  position: absolute;
  width: 25px;
  height: 4px;
  top: 50%;
  left: 50%;
  margin-top: -2px;
  margin-left: -12.5px;
}
.icon-wrapper-2 .spark span:nth-of-type(1) {
  transform: rotate(0deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(2) {
  transform: rotate(-18deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(3) {
  transform: rotate(-36deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(4) {
  transform: rotate(-54deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(5) {
  transform: rotate(-72deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(6) {
  transform: rotate(-90deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(7) {
  transform: rotate(-108deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(8) {
  transform: rotate(-126deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(9) {
  transform: rotate(-144deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(10) {
  transform: rotate(-162deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(11) {
  transform: rotate(-180deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(12) {
  transform: rotate(-198deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(13) {
  transform: rotate(-216deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(14) {
  transform: rotate(-234deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(15) {
  transform: rotate(-252deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(16) {
  transform: rotate(-270deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(17) {
  transform: rotate(-288deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(18) {
  transform: rotate(-306deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(19) {
  transform: rotate(-324deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span:nth-of-type(20) {
  transform: rotate(-342deg) translate(40px) scale(0);
}
.icon-wrapper-2 .spark span {
  background: green;
  border-radius: 2px;
}

.icon-wrapper-2.anim .spark span:nth-of-type(1) {
  -webkit-animation: spark-animation-1 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-1 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(2) {
  -webkit-animation: spark-animation-2 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-2 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(3) {
  -webkit-animation: spark-animation-3 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-3 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(4) {
  -webkit-animation: spark-animation-4 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-4 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(5) {
  -webkit-animation: spark-animation-5 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-5 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(6) {
  -webkit-animation: spark-animation-6 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-6 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(7) {
  -webkit-animation: spark-animation-7 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-7 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(8) {
  -webkit-animation: spark-animation-8 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-8 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(9) {
  -webkit-animation: spark-animation-9 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-9 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(10) {
  -webkit-animation: spark-animation-10 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-10 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(11) {
  -webkit-animation: spark-animation-11 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-11 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(12) {
  -webkit-animation: spark-animation-12 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-12 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(13) {
  -webkit-animation: spark-animation-13 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-13 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(14) {
  -webkit-animation: spark-animation-14 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-14 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(15) {
  -webkit-animation: spark-animation-15 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-15 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(16) {
  -webkit-animation: spark-animation-16 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-16 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(17) {
  -webkit-animation: spark-animation-17 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-17 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(18) {
  -webkit-animation: spark-animation-18 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-18 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(19) {
  -webkit-animation: spark-animation-19 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-19 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}
.icon-wrapper-2.anim .spark span:nth-of-type(20) {
  -webkit-animation: spark-animation-20 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
          animation: spark-animation-20 cubic-bezier(0.075, 0.82, 0.165, 1) 1.5s;
}

@-webkit-keyframes spark-animation-1 {
  0% {
    opacity: 1;
    transform: rotate(0deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(0deg) translate(96px) scale(0);
  }
}

@keyframes spark-animation-1 {
  0% {
    opacity: 1;
    transform: rotate(0deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(0deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-2 {
  0% {
    opacity: 1;
    transform: rotate(-18deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-18deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-2 {
  0% {
    opacity: 1;
    transform: rotate(-18deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-18deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-3 {
  0% {
    opacity: 1;
    transform: rotate(-36deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-36deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-3 {
  0% {
    opacity: 1;
    transform: rotate(-36deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-36deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-4 {
  0% {
    opacity: 1;
    transform: rotate(-54deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-54deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-4 {
  0% {
    opacity: 1;
    transform: rotate(-54deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-54deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-5 {
  0% {
    opacity: 1;
    transform: rotate(-72deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-72deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-5 {
  0% {
    opacity: 1;
    transform: rotate(-72deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-72deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-6 {
  0% {
    opacity: 1;
    transform: rotate(-90deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-90deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-6 {
  0% {
    opacity: 1;
    transform: rotate(-90deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-90deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-7 {
  0% {
    opacity: 1;
    transform: rotate(-108deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-108deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-7 {
  0% {
    opacity: 1;
    transform: rotate(-108deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-108deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-8 {
  0% {
    opacity: 1;
    transform: rotate(-126deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-126deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-8 {
  0% {
    opacity: 1;
    transform: rotate(-126deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-126deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-9 {
  0% {
    opacity: 1;
    transform: rotate(-144deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-144deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-9 {
  0% {
    opacity: 1;
    transform: rotate(-144deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-144deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-10 {
  0% {
    opacity: 1;
    transform: rotate(-162deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-162deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-10 {
  0% {
    opacity: 1;
    transform: rotate(-162deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-162deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-11 {
  0% {
    opacity: 1;
    transform: rotate(-180deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-180deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-11 {
  0% {
    opacity: 1;
    transform: rotate(-180deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-180deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-12 {
  0% {
    opacity: 1;
    transform: rotate(-198deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-198deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-12 {
  0% {
    opacity: 1;
    transform: rotate(-198deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-198deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-13 {
  0% {
    opacity: 1;
    transform: rotate(-216deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-216deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-13 {
  0% {
    opacity: 1;
    transform: rotate(-216deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-216deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-14 {
  0% {
    opacity: 1;
    transform: rotate(-234deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-234deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-14 {
  0% {
    opacity: 1;
    transform: rotate(-234deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-234deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-15 {
  0% {
    opacity: 1;
    transform: rotate(-252deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-252deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-15 {
  0% {
    opacity: 1;
    transform: rotate(-252deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-252deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-16 {
  0% {
    opacity: 1;
    transform: rotate(-270deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-270deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-16 {
  0% {
    opacity: 1;
    transform: rotate(-270deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-270deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-17 {
  0% {
    opacity: 1;
    transform: rotate(-288deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-288deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-17 {
  0% {
    opacity: 1;
    transform: rotate(-288deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-288deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-18 {
  0% {
    opacity: 1;
    transform: rotate(-306deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-306deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-18 {
  0% {
    opacity: 1;
    transform: rotate(-306deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-306deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-19 {
  0% {
    opacity: 1;
    transform: rotate(-324deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-324deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-19 {
  0% {
    opacity: 1;
    transform: rotate(-324deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-324deg) translate(96px) scale(0);
  }
}
@-webkit-keyframes spark-animation-20 {
  0% {
    opacity: 1;
    transform: rotate(-342deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-342deg) translate(96px) scale(0);
  }
}
@keyframes spark-animation-20 {
  0% {
    opacity: 1;
    transform: rotate(-342deg) translate(40px) scale(1);
  }
  80% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: rotate(-342deg) translate(96px) scale(0);
  }
}




 

      </style>
</head>
<body>
  
<div class="d-flex justify-content-center align-items-center " style='max-width:70% !important; margin: 0 auto; min-height: 80vh; '>
	<div style='margin:20px;' class=' bg-white text-center mb-2 ' >
		
           @if ($success==1) 
           	 <div id="successmsg">
					        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
		              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
		              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
		            </svg>
		        </div>
           @elseif ($success==2) 
            <div id="successmsg">
                     <div class="mycontainer" >
                      <div class="icon-wrapper-2 anim">
                        <span class="icon"><i class="fa fa-thumbs-up"></i></span>
                        <div class="myborder"><span></span></div>
                        <div class="spark">
                          <span></span><span></span><span></span><span></span>
                          <span></span><span></span><span></span><span></span>
                          <span></span><span></span><span></span><span></span>
                          <span></span><span></span><span></span><span></span>
                          <span></span><span></span><span></span><span></span>
                        </div>
                      </div>
                    </div>
                    </div>
           
           @else
           	  <div id="errormsg">
						<svg class="checkmark_cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
						  <circle class="checkmark__circle_cross" cx="26" cy="26" r="25" fill="none" />
						  <path class="checkmark__check_cross" fill="none" d="M16 16 36 36 M36 16 16 36" />
						</svg>
			        </div>
         @endif
		<h1> {!! $head !!}</h1>
		<p>{!! $message !!}</p>

    
     @if ($showform==1) 
     <div class="d-flex flex-column">
                            <div class="container-fluid">
                            <div class="row  mt-3">
                            <div class="col">
                            <div class="infocard shadow-sm bg-white">
                            <div class="form-style-6" style="text-align: left !important;">
                            <fieldset style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;" >
                            <legend style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">Transaction Detail</legend>
                            <form method="POST" action="/guest_confirmation/add_transaction">
                              @csrf
                                <div class="row" >
                                <div class="col">
                                    <label>Transaction Id</label>
                                    <input type="text" name="transaction_number" id="transactionid" placeholder="Add your transaction id here" required>
                                    <input type="hidden" name="id" value="{{$reservationid}}">

                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col">
                                    <label>Comments</label>
                                    <textarea class="" name="comments" id="editcomments" style="min-height:80px;" rows="3" value=""></textarea>
                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col" style="text-align: right;">
                                    <button type="submit"  id="submit" name="submit_transaction" class="infbtn"  style="background-color:white;color:#43D1AF;">Submit</button>
                                    
                                </div>
                                </div>
                            </form>
                                </fieldset>
                            
                            </div>
                            </div>
                        </div>
                        </div>
                            

                            </div>

                    </div>
    @endif
		

	  
		 

			
	</div>

	
</div>


</body>
</html>