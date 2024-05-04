const loginbtn = document.querySelector("#loginbtn");
const cadbtn = document.querySelector("#cadbtn");
const base = document.querySelector(".base");

cadbtn.addEventListener('click', () => {
    base.classList.add("Modo-Cadastro");
});

loginbtn.addEventListener('click', () => {
    base.classList.remove("Modo-Cadastro");
});
