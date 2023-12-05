function validacionFormulario(e) {
    var modelo = document.getElementById("modelo").value;
    var precio = document.getElementById("precio").value;
    var stock = document.getElementById("stock").value;
    var imagen = document.getElementById("imagen").value;
    
    if (/^\s+$/.test(modelo) || modelo == ""){
        alert("No has introducido el modelo");
        return false;
    } 
    if (/^\s+$/.test(precio) || precio == ""){
        alert("No has introducido el precio");
        return false;
    } 

    if (/^[A-Z]+$/i.test(precio)) {
        alert("El precio introducido debe ser un número");
        return false;
    }

    if (/^\s+$/.test(stock) || stock == ""){
        alert("No has introducido el stock");
        return false;
    } 
    if (!(/^([0-9])+$/).test(stock)) {
        alert("El stock introducido debe ser un número");
        return false;
    }
    if (/^\s+$/.test(imagen) || imagen == ""){
        alert("No has introducido la imagen");
        return false;
    } 
    return true;
}


//PREVISUALIZAR IMAGEN AL SELECCIONARLA
document.getElementById("imagen").onchange = function() {
    //instanciamos el objeto FileReader
    var reader = new FileReader();
    reader.onload = function(e) {
        //en eñ evento onload del FileReader asignamos la ruta al src del elemento imagen del html
        document.getElementById("foto").src = e.target.result;
    };
    //carga el contenido del fichero imagen
    reader.readAsDataURL(this.files[0]);
};