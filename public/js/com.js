// Ces deux fonctions permettent d'ouvrir et fermer le menu burger
var div = document.getElementById('comm');

function openMenu(){
    div.classList.add("headerBurger");
    document.querySelector('article').style.marginTop = "unset";
    document.getElementById('commentaire').style.display = "block";
}

function closeMenu(){
    div.classList.remove("headerBurger");
    document.getElementById('hamb').style.display = "none";

}