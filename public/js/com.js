// Ces deux fonctions permettent d'ouvrir et fermer la box commentaire commentaires
/*let comm = loop.index ;
let div = document.getElementById('container_com');*/
const div = document.querySelector('#container_com');

//let attribut = document.getAttribute('#container_com').dataset.id;
//const numbers = [1, 2, 3, 4, 5];


/*div.forEach((divs, index) => {


    console.log('Index: ' + index + ' Value: ' + divs);


});*/

function openMenu(){
    div.classList.add("divcontainer_com");
    document.querySelector('#container_com').style.display = "flex";
}

function closeMenu(){
    div.classList.remove("divcontainer_com");
    document.querySelector('#container_com').style.display = "none";

}

console.log (container_com);






