window.onload = () => {
    let menus = document.querySelectorAll(".dropdown-submenu a.dropdown-toggle")
    for(let menu of menus){
        menu.addEventListener("click", function(e){
            e.stopPropagation()
            e.preventDefault()
            let sousmenus = document.querySelectorAll(".multi .dropdown-menu")
            for(let sousmenu of sousmenus){
                sousmenu.style.display = "none"
            }
            this.nextElementSibling.style.display = "initial"
        })
    }
}