document.addEventListener("DOMContentLoaded",(function(){var t=new Date("Jan 1, 2023").getTime(),n=setInterval((function(){var e=(new Date).getTime(),d=t-e,i='<div class="countdownlist-item"><div class="count-title">Days</div><div class="count-num">'+Math.floor(d/864e5)+'</div></div><div class="countdownlist-item"><div class="count-title">Hours</div><div class="count-num">'+Math.floor(d%864e5/36e5)+'</div></div><div class="countdownlist-item"><div class="count-title">Minutes</div><div class="count-num">'+Math.floor(d%36e5/6e4)+'</div></div><div class="countdownlist-item"><div class="count-title">Seconds</div><div class="count-num">'+Math.floor(d%6e4/1e3)+"</div></div>";document.getElementById("countdown").innerHTML=i,d<0&&(clearInterval(n),document.getElementById("countdown").innerHTML='<div class="countdown-endtxt">The countdown has ended!</div>')}),1e3)}));