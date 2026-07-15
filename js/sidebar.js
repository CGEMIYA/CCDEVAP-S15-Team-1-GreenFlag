/* ============================================
   GREEN FLAG
   SIDEBAR
============================================ */

const menuBtn =
document.getElementById("menuBtn");

const sidebar =
document.getElementById("sidebar");

const overlay =
document.getElementById("sidebarOverlay");

if(menuBtn){

    menuBtn.addEventListener("click",()=>{

        sidebar.classList.add("active");

        overlay.classList.add("active");

    });

}

overlay.addEventListener("click",closeSidebar);

document.addEventListener("keydown",(event)=>{

    if(event.key==="Escape"){

        closeSidebar();

    }

});

function closeSidebar(){

    sidebar.classList.remove("active");

    overlay.classList.remove("active");

}
