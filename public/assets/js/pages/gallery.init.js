(()=>{document.addEventListener("DOMContentLoaded",(function(e){var t=new Isotope(".gallery-wrapper",{itemSelector:".element-item",layoutMode:"fitRows"});document.querySelector(".categories-filter").addEventListener("click",(function(e){if(matchesSelector(e.target,"li a")){var r=e.target.getAttribute("data-filter");t.arrange({filter:r})}}));for(var r=document.querySelectorAll(".categories-filter"),a=0,i=r.length;a<i;a++){c(r[a])}function c(e){e.addEventListener("click",(function(t){matchesSelector(t.target,"li a")&&(e.querySelector(".active").classList.remove("active"),t.target.classList.add("active"))}))}}));GLightbox({selector:".image-popup",title:!1})})();