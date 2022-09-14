var headdd = document.getElementById('head');

function openMenu(){
    headdd.classList.add("headerBurger");
    document.querySelector('section').style.marginTop = "unset"
}

function closeMenu(){
    headdd.classList.remove("headerBurger");
    document.querySelector('section').style.marginTop = "-25px"
}

