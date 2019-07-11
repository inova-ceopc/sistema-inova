

// document.cancelFullScreen = document.webkitExitFullscreen || document.mozCancelFullScreen || document.exitFullscreen || document.msExitFullscreen;
// //paga o elemento com as classes fs 
// var elem = document.querySelector(document.webkitExitFullscreen ? ".fs" : ".fs-container");
// //escuta o teclado para sair da visualizacão em tela cheia caso tecle esc
// document.addEventListener('keypress', function(e) {
//   switch (e.keyCode) {
//     case 13: // ENTER. ESC should also take you out of fullscreen by default.
//       e.preventDefault();
     
//       exitFullscreen();
     
//       break;

//       case 27: // ENTER. ESC should also take you out of fullscreen by default.
//       e.preventDefault();
     
//       exitFullscreen();
    
//       break;
//   }

// }, false);



// //vê se está em tela cheia
// function onFullScreenEnter() {
//   console.log("Entered fullscreen!");
 
//   elem.onwebkitfullscreenchange = onFullScreenExit;
//   elem.onmozfullscreenchange = onFullScreenExit;

// };
// //vê se saiu da tela cheia
// // Called whenever the browser exits fullscreen.
// function onFullScreenExit() {
// 	$(".requestfullscreen").removeClass("hide");
// 	$(".exitFullscreen").addClass("hide");
//   console.log("Exited fullscreen!");
// };

// // Note: FF nightly needs about:config full-screen-api.enabled set to true.
// //entra na função tela cheia
// function enterFullscreen() {
// 	$(".exitFullscreen").removeClass("hide");
// 	$(".requestfullscreen").addClass("hide");

//   console.log("enterFullscreen()");
//   elem.onwebkitfullscreenchange = onFullScreenEnter;
//   elem.onmozfullscreenchange = onFullScreenEnter;
//   elem.onfullscreenchange = onFullScreenEnter;

//   if (elem.webkitRequestFullscreen) {
//     elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
//   } else {
//     if (elem.mozRequestFullScreen) {
//       elem.mozRequestFullScreen();
//     } else if (elem.msRequestFullscreen){
//       elem.msRequestFullscreen();
//     } else{
//       elem.requestFullscreen();
//     }
//   }
//   // exitFullscreen();
// }
// //sai da função tela cheia
// function exitFullscreen() {
	
// 	$(".requestfullscreen").removeClass("hide");
// 	$(".exitFullscreen").addClass("hide");
//   console.log("exitFullscreen()");
//   document.cancelFullScreen();
//   // document.getElementById('enter-exit-fs').onclick = enterFullscreen;
// }
function toggleFullScreen() {
  var doc = window.document;
  var docEl = doc.documentElement;

  var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
  var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

  if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
    requestFullScreen.call(docEl);
   
  }
  else {
    cancelFullScreen.call(doc);

  }
}