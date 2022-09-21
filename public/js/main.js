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
    if (queue_url == 'admin') {
        document.querySelector('section').style.marginTop = "-25px";
    }

}

function openMenu2(){
    headdd.classList.add("headerBurger2");
    document.getElementById('crossDiv').style.display = "block"
    document.getElementById('cross').style.display = "block"
    document.querySelector('section').style.display = "none"
}

function closeMenu2(){
    headdd.classList.remove("headerBurger2");
    document.getElementById('crossDiv').style.display = "none"
    document.getElementById('cross').style.display = "none"
    document.querySelector('section').style.display = "block"
}

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

// On modifie le header de place selon si l'on est sur l'accueil ou sur les crud

if(queue_url == 'admin'){
    document.querySelector('body').removeAttribute('id');
} else {
    document.querySelector('header').classList.add("headerBurger");
}

// Détermine la largeur de la fenetre 

var largeur = window.innerWidth;

// Modification des boutons pour responsive

if(largeur <= 800){

    var editBtn = document.querySelectorAll('.editBtn');

    editBtn.forEach(element => {
        element.innerHTML = "<i class='fa-solid fa-pen-to-square'></i>"
        element.style.width = "unset"
    });
    
    var deleteBtn = document.querySelectorAll('.btn');
    
    deleteBtn.forEach(element => {
        element.innerHTML = "<i class='fa-solid fa-trash'></i>"
        element.style.width = "unset"
    });

}