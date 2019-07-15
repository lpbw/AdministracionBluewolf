$(document).ready(function(){
    // collapsible
    $('.collapsible').collapsible();
});

//Mostrar viaje.
function VerViaje(id){
    console.log(id);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            document.getElementById("proyecto").innerHTML = myObj.name;
        }
    };
    xmlhttp.open("GET", "Informacion.php?idv="+id+"&val=1", true);
    xmlhttp.send();
    $('.Mymodal').show();
}
function ActualizarBadge(id,count){
    $('#badge'+id).text(count);
}
function Ocultar() { 
    $('.Mymodal').hide(); 
}