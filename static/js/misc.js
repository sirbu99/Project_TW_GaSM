function hide(id){
    
    var element = document.getElementById(id);
    if(element.style.display === 'none'){
        element.style.display = 'block';
    }else{
        element.style.display = 'none';
    }

}

window.addEventListener('resize', function(event){
    document.getElementById("drop1").style.display = "none";
  });