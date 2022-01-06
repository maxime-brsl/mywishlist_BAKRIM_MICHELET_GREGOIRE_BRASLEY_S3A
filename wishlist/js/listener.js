let boutonListe = document.querySelector("#blist");
let boutonItem = document.querySelector("#bitem");
let boutonAjoutItem = document.querySelector("#bajoutitem");

let formulaireItem = document.querySelector("#fitem");
let formulaireListe = document.querySelector("#flist");
let formulaireAjoutItem = document.querySelector("#fajoutitem");

formulaireItem.style.display = "none";
formulaireListe.style.display = "none";
formulaireAjoutItem.style.display = "none";

boutonListe.addEventListener("click", () => {
    formulaireListe.style.display = "block";
    formulaireItem.style.display = "none";
    formulaireAjoutItem.style.display = "none";
});

boutonItem.addEventListener("click", () => {
    formulaireItem.style.display = "block";
    formulaireListe.style.display = "none";
    formulaireAjoutItem.style.display = "none";
});

boutonAjoutItem.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    formulaireAjoutItem.style.display = "block";
});