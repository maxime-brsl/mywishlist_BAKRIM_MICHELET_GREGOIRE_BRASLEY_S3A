let boutonListe = document.querySelector("#blist");
let boutonItem = document.querySelector("#bitem");

let formulaireItem = document.querySelector("#fitem");
let formulaireListe = document.querySelector("#flist");

formulaireItem.style.display = "none";
formulaireListe.style.display = "none";

boutonListe.addEventListener("click", () => {
    formulaireListe.style.display = "block";
});

boutonItem.addEventListener("click", () => {

    formulaireItem.style.display = "block";

});