let TabLiens = document.querySelectorAll(".tab a");
//je cible tous les liens
let TabCt= document.querySelectorAll (".content");
//j'attribue la classe active au premier lien
TabLiens[0].className= "active";
TabCt[0].style.display= "block";

function reset(){
  for(var i=0; i<TabLiens.length; i++){
    TabLiens[i].className=""; 
    //je supprime les classes actives pour tous les liens
    TabCt[i].style.display= "none";
  }
}

function tabo(){
    reset();
  this.className= "active";
  TabCt[this.rang].style.display="block";
}

for(var j=0; j<TabLiens.length; j++){
  TabLiens[j].rang = j;
  TabLiens[j].addEventListener('click',tabo);
}