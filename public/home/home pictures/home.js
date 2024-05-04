/* activação do header */
const group = document.querySelector(".group");
const menu = document.querySelector(".menu");
group.addEventListener("click", ()=> menu.classList.toggle("active"))
/*end header*/

/* Conteúdo principal */
/* slide show */
let slider =1;
document.getElementById ("radio1").checked =true;

/*tempo entre as transições*/setInterval(function() {
nextImage();
},4000)

/*transições das imagens*/function nextImage(){
    slider++;
    if(slider>4){
        slider=1;
    }
    document.getElementById ("radio"+slider).checked =true; 
}