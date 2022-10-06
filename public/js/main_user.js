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

/*const nums = [34, 2, 48, 91, 12, 32];
let i = nums.every(n => n < 100);
console.log(i);*/

  

/*function openMenu(){
  div.classList.add("divcontainer_com");
  document.SelectorById('#container_com').style.display = "flex";
}

function closeMenu(){
  div.classList.remove("divcontainer_com");
  document.SelectorById('#container_com').style.display = "none";


}*/

