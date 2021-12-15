let boutonReserv = document.querySelector("#reservB");

boutonReserv.addEventListener("click", () => {
    let msg = document.querySelector("#msg").value;
    let nomItem = document.querySelector("#nomItem").value;
    alert("Vous avez reserve l item : " + nomItem);
    document.cookie = 'item'+nomItem+'=true';
});