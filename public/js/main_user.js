/*var sidenav = document.getElementById("mySidenav");
//var openBtn = document.getElementById("openBtn");
//var closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav;
closeBtn.onclick = closeNav;

/* Set the width of the side navigation to 250px */
/*function openNav() {
  sidenav.classList.add("active");
}*/

/* Set the width of the side navigation to 0 */
/*function closeNav() {
  sidenav.classList.remove("active");
}*/

//const header = document.SelectorById('#head');



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


  

/*function openMenu(){
  div.classList.add("divcontainer_com");
  document.SelectorById('#container_com').style.display = "flex";
}

function closeMenu(){
  div.classList.remove("divcontainer_com");
  document.SelectorById('#container_com').style.display = "none";


}*/

