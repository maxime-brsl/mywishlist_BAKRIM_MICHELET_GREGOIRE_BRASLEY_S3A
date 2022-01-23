let boutonListe = document.querySelector("#blist");
let boutonItem = document.querySelector("#bitem");
//let boutonAjoutItem = document.querySelector("#bajoutitem");
let boutonAddList = document.querySelector("#baddlist");
let boutonCreerCagnotte = document.querySelector("#bcreercagnotte");
let boutonJoindreListe = document.querySelector("#bjoindrelist")
let boutonModifListe = document.querySelector("#bmodifliste");

let formulaireItem = document.querySelector("#fitem");
let formulaireListe = document.querySelector("#flist");
//let formulaireAjoutItem = document.querySelector("#fajoutitem");
let formulaireAddListe = document.querySelector("#faddlist");
let formulaireJoindreListe = document.querySelector("#flistjoin");
let formulaireCreerCagnotte = document.querySelector("#fcreercagnotte");
let formulaireModifListe = document.querySelector("#fmodifliste");

formulaireItem.style.display = "none";
formulaireListe.style.display = "none";
//formulaireAjoutItem.style.display = "none";
formulaireAddListe.style.display = "none";
formulaireCreerCagnotte.style.display = "none";
formulaireJoindreListe.style.display = "none";
formulaireModifListe.style.display= "none";

boutonListe.addEventListener("click", () => {
    formulaireListe.style.display = "block";
    formulaireItem.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "none";
    formulaireJoindreListe.style.display = "none";
    formulaireModifListe.style.display= "none";
});

boutonItem.addEventListener("click", () => {
    formulaireItem.style.display = "block";
    formulaireListe.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "none";
    formulaireJoindreListe.style.display = "none";
    formulaireModifListe.style.display= "none";
});
/*
boutonAjoutItem.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    formulaireAjoutItem.style.display = "block";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "none";
    formulaireJoindreListe.style.display = "none";
});
*/

boutonAddList.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "block";
    formulaireCreerCagnotte.style.display = "none";
    formulaireJoindreListe.style.display = "none";
    formulaireModifListe.style.display= "none";
});

boutonCreerCagnotte.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "block";
    formulaireJoindreListe.style.display = "none";
    formulaireModifListe.style.display= "none";
});

boutonJoindreListe.addEventListener("click",() =>{
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "none";
    formulaireJoindreListe.style.display = "block";
    formulaireModifListe.style.display= "none";
})

boutonModifListe.addEventListener("click", () => {
    formulaireItem.style.display = "none";
    formulaireListe.style.display = "none";
    //formulaireAjoutItem.style.display = "none";
    formulaireAddListe.style.display = "none";
    formulaireCreerCagnotte.style.display = "none";
    formulaireModifListe.style.display= "block";
    formulaireJoindreListe.style.display = "none";
});