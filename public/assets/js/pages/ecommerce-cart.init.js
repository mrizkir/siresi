(()=>{var e="$";function t(){var t=0;document.getElementsByClassName("product").forEach((function(e){e.getElementsByClassName("product-line-price").forEach((function(e){t+=parseFloat(e.innerHTML)}))}));var n=.125*t,o=.15*t,d=t>0?65:0,c=t+n+d-o;document.getElementById("cart-subtotal").innerHTML=e+t.toFixed(2),document.getElementById("cart-tax").innerHTML=e+n.toFixed(2),document.getElementById("cart-shipping").innerHTML=e+d.toFixed(2),document.getElementById("cart-total").innerHTML=e+c.toFixed(2),document.getElementById("cart-discount").innerHTML="-$"+o.toFixed(2)}document.getElementById("removeItemModal").addEventListener("show.bs.modal",(function(e){document.getElementById("remove-product").addEventListener("click",(function(n){e.relatedTarget.closest(".product").remove(),document.getElementById("close-modal").click(),t()}))}))})();