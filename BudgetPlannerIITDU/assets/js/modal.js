var modal=document.getElementById("myModal");
var span=document.getElementsByClassName("close")[0];
var modalbtn=document.getElementById("modalBtn");
modalbtn.onclick=function(){
	modal.style.display="block";
}
function modalShow(){
	modal.style.display="block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}