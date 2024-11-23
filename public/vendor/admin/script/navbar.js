window.onload = function(){
    const body = document.querySelector('body');
    const logo = document.querySelector('#logoText')


      setInterval(function(){
        if(body.classList.contains('sidebar-collapse')){
            logo.textContent = `KK`;

        }
        else{
            logo.textContent = `Dashboard Kemnaker`
        }

      }, 100)

}
