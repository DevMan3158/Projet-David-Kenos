// Ces deux fonctions permettent d'ouvrir et fermer la box commentaire commentaires
/*var div = document.getElementById('container_com');

function openMenu(){
    div.classList.add("divcontainer_com");
    document.getElementById('container_com').style.display = "flex";
}

function closeMenu(){
    div.classList.remove("container_com");
    document.getElementById('container_com').style.display = "none";

}*/



var div = document.querySelectorAll('container_com');



divcontainer_com.forEach(function openMenu() => {

    div.classList.add("divcontainer_com");
    document.getElementById('container_com').style.display = "flex";
    
});



