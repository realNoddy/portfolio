function switchForm(f){
    let off = document.querySelector(".selected-form");
    off.classList.remove('selected-form');
    off.classList.add('hide');
    let on = document.querySelector("#"+f);
    on.classList.remove('hide');
    on.classList.add('selected-form');
}

function closeInfobox(){
    let close = document.querySelectorAll('.info-box');
    close.forEach((el) => {
        el.classList.add('hide');
    });
}

function Logout(){
    fetch("api/logout.php")
    .then(r => location.href="http://"+location.hostname);
}

function MenuNav(nav){
    let cur = document.querySelector('#menu .list .selected');
    document.getElementById(cur.innerText).classList.add('hide');
    cur.classList.remove('selected');
    document.getElementById(nav.innerText).classList.remove('hide');
    nav.classList.add('selected');
}