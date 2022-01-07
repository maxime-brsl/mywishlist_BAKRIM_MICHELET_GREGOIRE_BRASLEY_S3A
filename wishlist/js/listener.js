let boutonListe = document.querySelector("#blist");
let boutonItem = document.querySelector("#bitem");
let boutonAjoutItem = document.querySelector("#bajoutitem");
let boutonAddList = document.querySelector("#baddlist");

let formulaireItem = document.querySelector("#fitem");
let formulaireListe = document.querySelector("#flist");
let formulaireAjoutItem = document.querySelector("#fajoutitem");
let formulaireAddListe = document.querySelector("#faddliste");

formulaireItem.style.display = "none";
formulaireListe.style.display = "none";
formulaireAjoutItem.style.display = "none";
formulaireAddListe.style.display = "none";

boutonListe.addEventListener("click", () => {
    formulaireListe.style.display = "block";
    formulaireItem.style.display = "none";
    formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "block";
});

boutonItem.addEventListener("click", () => {
    formulaireItem.style.display = "block";
    formulaireListe.style.display = "none";
    formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "block";
});

boutonAjoutItem.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    formulaireAjoutItem.style.display = "block";
    formulaireAddListe.style.display = "block";
});

boutonAddList.addEventListener("click", () => {
    formulaireAddListe.style.display = "block";
});