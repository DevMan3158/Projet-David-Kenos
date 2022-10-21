// Fonction permettant de filtrer les utilisateurs du trombinoscope

function search() {
  let input = document.getElementById('searchBar').value
  input=input.toLowerCase();
  let x = document.getElementsByClassName('card');
    
  for (i = 0; i < x.length; i++) { 
      if (!x[i].innerHTML.toLowerCase().includes(input)) {
          x[i].style.display="none";
      }
      else {
          x[i].style.display="list-item";                 
      }
  }
}

// Fonction qui permets de filtrer les actualités par catégories ( ville )

function getId(obj){

  let input = document.getElementById('searchBar').value
  let city = document.getElementById(obj.id).innerText;

  input = city.toLowerCase();

  let x = document.getElementsByClassName('card');
    
  for (i = 0; i < x.length; i++) { 
      if (!x[i].innerHTML.toLowerCase().includes(input)) {
          x[i].style.display="none";
      }
      else {
          x[i].style.display="list-item";                 
      }
  }
}

// Fonction qui ouvre le formulaire de création d'un post dans la page mon profil

function newPost(){

  let newPost = document.getElementById('newPost');

  if(newPost.classList.contains('active') == false){
    newPost.classList.add('active');
  } else {
    newPost.classList.remove('active');
  }
  
  
}

// Fonction qui permet de cocher tous les filtres si "Tous les post" est activé.

function gBox(nbCheck){

allInput = document.querySelectorAll('.active');

  if(document.getElementById(nbCheck).checked == true){

    allInput.forEach(element => {
      element.checked = true;
    });

  }
  else if(document.getElementById(nbCheck).checked == false){

    allInput.forEach(element => {
      element.checked = false;
    });

  }
}

// Fonction qui coche "tous les posts" si tous les filtres sont activés.

function allBox(active){


  let allInput = document.querySelectorAll(active);

 if(Array.from(allInput).every(n => n.checked == true)){

  document.querySelector('#firstLi').checked = true;
  
  } else {

    document.querySelector('#firstLi').checked = false;

  }
  
}

window.onload = () => {
  const FilterForm = document.querySelector('#filters');

  // On boucle les input et on écoute le clique
  document.querySelectorAll('#filters input').forEach(input => {
    input.addEventListener("change", () =>{
      console.log("click");
      // On récupere les données du formulaire
      const Form = new FormData(FilterForm);

      // On fabrique l'url (queryString(Ce qu'il y a apres le ? dans l'url))
      const Params = new URLSearchParams();

      Form.forEach((value, key) => {
        Params.append(key, value);
        console.log(Params.toString());
      })

      // On récupère l'url active
      const Url = new URL(window.location.href);

      // On lance la requete AJAX
      fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
        headers: {
          "x-Requested-with": "XMLHttpRequest"
        }
      }).then(response =>

        response.json()
        
      ).then(data => {

        // On va chercher le conteneur des post
        const content = document.querySelector('#container_posts');

        // On remplace le contenu
        content.innerHTML = data.content;

        // On met à jour l'url
        history.pushState({}, null, Url.pathname + "?" + Params.toString());

    }).catch(e => alert(e));
    })
  })
}

// Fonction qui ouvre ou ferme le menu des commentaires

function openMenu(){

  let buttonId = event.currentTarget.id.replace('commenter', 'container_com_');
  let postId = document.getElementById(buttonId);

  if (postId.classList.contains('activeComment') == false) {

    postId.classList.add("activeComment");

  } else {

    postId.classList.remove("activeComment");

  }

}

// Fonction AJAX pour les likes

function onClickBtnLike(event){
    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');
    const nbLikes = document.querySelector('span.js-nbLikes')
    const jsText = this.querySelector('span.js-text')

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.likes;

        if(icone.classList.contains('fa-solid')){

            icone.classList.replace('fa-solid', 'fa-regular');

        } else {

            icone.classList.replace('fa-regular', 'fa-solid');

        };


        if(spanCount.innerHTML > 1){
          jsText.innerHTML = "J'aimes";
        } else {
          jsText.innerHTML = "J'aime";
        }

        
    })
}

document.querySelectorAll('a.js-like').forEach(function(link){
    link.addEventListener('click', onClickBtnLike)
})



// Fonction qui ouvre ou ferme le header coté user (mobile)


function openHeader(){

  let header = document.querySelector('header');
  let deleteInBurger = document.querySelector('section.deleteInBurger');
  let burger = document.querySelector('i#userBurger');

  if(header.classList.contains("activeHead")){

    header.classList.remove('activeHead');
    burger.classList.replace('fa-xmark', 'fa-bars');
    deleteInBurger.style.display = 'flex';
    sectionTromb.style.display = 'flex';

  } else {

    header.classList.add('activeHead');
    burger.classList.replace('fa-bars', 'fa-xmark');
    deleteInBurger.style.display = 'none';
    sectionTromb.style.display = 'none';

  }
}
