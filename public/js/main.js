// Ici on récupère l'url courant
var urlcourante = document.location.href; 

// Supprimons l'éventuel dernier slash de l'URL
var urlcourante = urlcourante.replace(/\/$/, "");

// Gardons dans la variable queue_url uniquement la portion derrière le dernier slash de urlcourante
queue_url = urlcourante.substring (urlcourante.lastIndexOf( "/" )+1 );


// Ces deux fonctions permettent d'ouvrir et fermer le menu burger
var headdd = document.getElementById('head');

function openMenu(){
    headdd.classList.add("headerBurger");
    document.querySelector('section').style.marginTop = "unset";
}

function closeMenu(){
    headdd.classList.remove("headerBurger");


    // On conditionne le retour du margin top à la fermeture du menu burger
    if (queue_url == 'acc') {
        document.querySelector('section').style.marginTop = "-25px";
    } 

}

