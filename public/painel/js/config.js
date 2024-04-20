"use strict";var base={defaultFontFamily:"Overpass, sans-serif",primaryColor:"#1b68ff",secondaryColor:"#4f4f4f",successColor:"#3ad29f",warningColor:"#ffc107",infoColor:"#17a2b8",dangerColor:"#dc3545",darkColor:"#343a40",lightColor:"#f2f3f6"},extend={primaryColorLight:tinycolor(base.primaryColor).lighten(10).toString(),primaryColorLighter:tinycolor(base.primaryColor).lighten(30).toString(),primaryColorDark:tinycolor(base.primaryColor).darken(10).toString(),primaryColorDarker:tinycolor(base.primaryColor).darken(30).toString()},chartColors=[base.primaryColor,base.successColor,"#6f42c1",extend.primaryColorLighter],colors={bodyColor:"#6c757d",headingColor:"#495057",borderColor:"#e9ecef",backgroundColor:"#f8f9fa",mutedColor:"#adb5bd",chartTheme:"light"},darkColor={bodyColor:"#adb5bd",headingColor:"#e9ecef",borderColor:"#212529",backgroundColor:"#495057",mutedColor:"#adb5bd",chartTheme:"dark"},curentTheme=localStorage.getItem("mode"),dark=document.querySelector("#darkTheme"),light=document.querySelector("#lightTheme"),switcher=document.querySelector("#modeSwitcher");function modeSwitch(){console.log("abc");var o=localStorage.getItem("mode");o?"dark"==o?(dark.disabled=!0,light.disabled=!1,localStorage.setItem("mode","light")):(dark.disabled=!1,light.disabled=!0,localStorage.setItem("mode","dark")):$("body").hasClass("dark")?(dark.disabled=!1,light.disabled=!0,localStorage.setItem("mode","dark")):(dark.disabled=!0,light.disabled=!1,localStorage.setItem("mode","light"))}console.log(curentTheme),curentTheme?("dark"==curentTheme?(dark.disabled=!1,light.disabled=!0,colors=darkColor):"light"==curentTheme&&(dark.disabled=!0,light.disabled=!1),switcher.dataset.mode=curentTheme):$("body").hasClass("dark")?(colors=darkColor,localStorage.setItem("mode","dark")):localStorage.setItem("mode","light");


// var baseImagePath = '/oficial.png';
// var darkImagePath = '/oficial.png';
// var darkImagePath1 = '/oficial.png';
// var darkImagePath2 = '/oficial.png';
// var imagem = document.getElementById('menuImage');
// // Determine o caminho da imagem com base no tema
// var elemento = document.querySelector('.vertical.light');
//   // Obtenha a lista de classes do elemento
//   var classes = elemento.classList;
//   // Acesse o valor da classe
//   var valorDaClasse = classes;
// console.log('aquii'+valorDaClasse);

// function callback(mutationsList, observer) {
//     for (let mutation of mutationsList) {
//       if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
//         // A classe foi alterada
//         var elemento = document.getElementById('verticalLight');
//         var classes = elemento.classList;
//         var valorDaClasse = classes;
//         console.log('A classe foi alterada para: ' + valorDaClasse[2]);
//         if(valorDaClasse[2]==="collapsed" && valorDaClasse[3]!="hover" && curentTheme === 'dark' ){
//             imagem.src = darkImagePath1;


//         }else if(valorDaClasse[2]==="collapsed"  && valorDaClasse[3]!="hover" && curentTheme === 'light')  {
//             imagem.src = darkImagePath2;
//         }
//         else{
//             if (curentTheme === 'dark') {
//                 imagem.src = darkImagePath;
//             } else {
//                 imagem.src = baseImagePath;
//             }
//         }
//       }
//     }
//   }

//   // Seleciona o elemento que você deseja observar
//   var elementoObservado = document.getElementById('verticalLight');

//   // Cria uma instância de MutationObserver com a função de callback
//   var observer = new MutationObserver(callback);

//   // Configura as opções para observar mudanças nos atributos
//   var config = { attributes: true };

//   // Inicia a observação no elemento com as opções configuradas
//   observer.observe(elementoObservado, config);

//   // Exemplo de alteração de classe para testar
//   setTimeout(function () {
//     elementoObservado.classList.remove('minha-classe');
//   }, 500);


var baseImagePath = '/logo3.png';
var collapsedImagePath = '/logo3.png';
var imagem = document.getElementById('menuImage');

// var baseImagePath = '/painel/assets/images/logo.png';
// var collapsedImagePath = '/painel/assets/images/logo.png';
// var imagem = document.getElementById('menuImage');

// ...

// Evento de observação de mudanças nas classes
function callback(mutationsList, observer) {
  for (let mutation of mutationsList) {
    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
      var elemento = document.getElementById('verticalLight');
      var classes = elemento.classList;
      var valorDaClasse = classes;
      console.log('A classe foi alterada para: ' + valorDaClasse[2]);

      if (valorDaClasse[2] === "collapsed" && valorDaClasse[3] != "hover") {
        imagem.src = collapsedImagePath;
        imagem.style.height = "45px"; // Altera o tamanho da imagem para 45px
      } else {
        imagem.src = baseImagePath;
        imagem.style.height = "100px"; // Altera o tamanho da imagem para 45px
      }
    }
  }
}

// ...

// Configuração da observação das mudanças nas classes
var elementoObservado = document.getElementById('verticalLight');
var observer = new MutationObserver(callback);
var config = { attributes: true };
observer.observe(elementoObservado, config);

// Exemplo de alteração de classe para testar
setTimeout(function () {
  elementoObservado.classList.remove('minha-classe');
}, 500);


