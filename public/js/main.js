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


// Need une solution pour choper ce qu'il y a apres admin
queue_url = urlcourante.substring (urlcourante.lastIndexOf( "/" )+1 );

// On récupère le titre des CRUD pour le modifier en fonction de la page
var titleCrud = document.getElementById('titleCrud');

// On modifie le titre des crud en fonction de la page
if (queue_url == 'user') {
    titleCrud.innerHTML = "Modification des utilisateurs";
} else if (queue_url == 'choc') {
    titleCrud.innerHTML = "Modification des chocolateries";
} else if (queue_url == 'act') {
    titleCrud.innerHTML = "Modification des actualités";
} else if (queue_url == 'post') {
    titleCrud.innerHTML = "Modification des posts";
} else if (queue_url == 'cat') {
    titleCrud.innerHTML = "Modification des catégories";
}
