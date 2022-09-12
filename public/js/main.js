var headdd = document.getElementById('head');

function openMenu(){
    headdd.classList.add("headerBurger");
    document.getElementById("actualites").style.marginTop = "unset";
}

function closeMenu(){
    headdd.classList.remove("headerBurger");
    document.getElementById("actualites").style.marginTop = "-25px"
}

