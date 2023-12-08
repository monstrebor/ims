
var sideBarIsOpen = true;


//this is for the arrow left and down in the sidebar 
toggleBtn.addEventListener("click", (event) =>{
event.preventDefault();

if(sideBarIsOpen){
dashboard_sidebar.style.width = "15%";
dashboard_sidebar.style.transition = '0.3s all';
dashboard_content_container.style.width = "90%";
dashboard_logo.style.fontSize = "60px";
userImage.style.fontSize = "20px";   

menuTexts = document.getElementsByClassName('menuTexts');

for (i = 0; i < menuTexts.length; i++){
    menuTexts[i].style.display = 'none'
}

document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center'; 
sideBarIsOpen = false;
}else{
dashboard_sidebar.style.width = "20%";
dashboard_content_container.style.width = "80%";
dashboard_logo.style.fontSize = "80px";
userImage.style.fontSize = "60px";  

menuTexts = document.getElementsByClassName('menuTexts');

for (i = 0; i < menuTexts.length; i++){
    menuTexts[i].style.display = 'inline-block'
}

document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left'; 
sideBarIsOpen = true;
}
});

document.addEventListener('click', function(e){
    let clickedEl = e.target;

    if(clickedEl.classList.contains("showHideSubMenu")){
        let subMenu = clickedEl.closest('li').querySelector('.subMenus');
        let mainMenuIcon = clickedEl.closest('li').querySelector('.mainMenuIconArrow');

        //close the open submenus
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if(subMenu !== sub) sub.style.display = 'none';
        });

        showHideSubMenu(subMenu, mainMenuIcon);
    }
});
    function showHideSubMenu(subMenu, mainMenuIcon){
        if(subMenu != null){
        if(subMenu.style.display === 'block'){
            subMenu.style.display = 'none';
                mainMenuIcon.classList.remove('fa-angle-down');
                mainMenuIcon.classList.add('fa-angle-left');

            }else{
                subMenu.style.display = 'block';  //else nameOfClass.cssStyle.displayFeature = 'displaying'
                mainMenuIcon.classList.remove('fa-angle-left');
                mainMenuIcon.classList.add('fa-angle-down');
            }
        }
    }

let pathArray = window.location.pathname.split( '/' );
let curFile = pathArray[pathArray.length - 1];

let curNav = document.querySelector('a[href="./'+ curFile +'"]');
curNav.classList.add('subMenuActive');

let mainNav = curNav.closest('li.menuActive');
mainNav.style.background = '#ffad41';

let subMenu = curNav.closest('.subMenus');
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow');

showHideSubMenu(subMenu, mainMenuIcon);