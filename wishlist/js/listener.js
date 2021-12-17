let boutonReserv = document.querySelector("#reservB");

boutonReserv.addEventListener("click", () => {
    let msg = document.querySelector("#msg").value;
    let nomItem = document.querySelector("#nomItem").textContent;
    alert("Vous avez reserve l item : " + nomItem);
    document.cookie = nomItem + "=" + msg;
    window.location.reload();
});