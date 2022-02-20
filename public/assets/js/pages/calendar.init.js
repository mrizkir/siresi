var start_date=document.getElementById("event-start-date"),timepicker1=document.getElementById("timepicker1"),timepicker2=document.getElementById("timepicker2"),date_range=null,T_check=null;function flatPickrInit(){var e={enableTime:!0,noCalendar:!0,defaultDate:"09:00",dateFormat:"H:i"};flatpickr(start_date,{enableTime:!1,mode:"range",minDate:"today",dateFormat:"Y-m-d",onChange:function(e,t,n){t.split("to").length>1?document.getElementById("event-time").setAttribute("hidden",!0):(document.getElementById("timepicker1").parentNode.classList.remove("d-none"),document.getElementById("timepicker1").classList.replace("d-none","d-block"),document.getElementById("timepicker2").parentNode.classList.remove("d-none"),document.getElementById("timepicker2").classList.replace("d-none","d-block"),document.getElementById("event-time").removeAttribute("hidden"))}});flatpickr(timepicker1,e),flatpickr(timepicker2,e)}function flatpicekrValueClear(){start_date.flatpickr().clear(),timepicker1.flatpickr().clear(),timepicker2.flatpickr().clear()}function eventClicked(){document.getElementById("form-event").classList.add("view-event"),document.getElementById("event-title").classList.replace("d-block","d-none"),document.getElementById("event-category").classList.replace("d-block","d-none"),document.getElementById("event-start-date").parentNode.classList.add("d-none"),document.getElementById("event-start-date").classList.replace("d-block","d-none"),document.getElementById("event-time").setAttribute("hidden",!0),document.getElementById("timepicker1").parentNode.classList.add("d-none"),document.getElementById("timepicker1").classList.replace("d-block","d-none"),document.getElementById("timepicker2").parentNode.classList.add("d-none"),document.getElementById("timepicker2").classList.replace("d-block","d-none"),document.getElementById("event-location").classList.replace("d-block","d-none"),document.getElementById("event-description").classList.replace("d-block","d-none"),document.getElementById("event-start-date-tag").classList.replace("d-none","d-block"),document.getElementById("event-timepicker1-tag").classList.replace("d-none","d-block"),document.getElementById("event-timepicker2-tag").classList.replace("d-none","d-block"),document.getElementById("event-location-tag").classList.replace("d-none","d-block"),document.getElementById("event-description-tag").classList.replace("d-none","d-block"),document.getElementById("btn-save-event").setAttribute("hidden",!0)}function editEvent(e){var t=e.getAttribute("data-id");"new-event"==t?(document.getElementById("modal-title").innerHTML="",document.getElementById("modal-title").innerHTML="Add Event",document.getElementById("btn-save-event").innerHTML="Add Event",eventTyped()):"edit-event"==t?(e.innerHTML="Cancel",e.setAttribute("data-id","cancel-event"),document.getElementById("btn-save-event").innerHTML="Update Event",e.removeAttribute("hidden"),eventTyped()):(e.innerHTML="Edit",e.setAttribute("data-id","edit-event"),eventClicked())}function eventTyped(){document.getElementById("form-event").classList.remove("view-event"),document.getElementById("event-title").classList.replace("d-none","d-block"),document.getElementById("event-category").classList.replace("d-none","d-block"),document.getElementById("event-start-date").parentNode.classList.remove("d-none"),document.getElementById("event-start-date").classList.replace("d-none","d-block"),document.getElementById("timepicker1").parentNode.classList.remove("d-none"),document.getElementById("timepicker1").classList.replace("d-none","d-block"),document.getElementById("timepicker2").parentNode.classList.remove("d-none"),document.getElementById("timepicker2").classList.replace("d-none","d-block"),document.getElementById("event-location").classList.replace("d-none","d-block"),document.getElementById("event-description").classList.replace("d-none","d-block"),document.getElementById("event-start-date-tag").classList.replace("d-block","d-none"),document.getElementById("event-timepicker1-tag").classList.replace("d-block","d-none"),document.getElementById("event-timepicker2-tag").classList.replace("d-block","d-none"),document.getElementById("event-location-tag").classList.replace("d-block","d-none"),document.getElementById("event-description-tag").classList.replace("d-block","d-none"),document.getElementById("btn-save-event").removeAttribute("hidden")}function upcomingEvent(e){e.sort((function(e,t){return new Date(e.start)-new Date(t.start)})),document.getElementById("upcoming-event-list").innerHTML=null,e.forEach((function(e){var t=e.title,n=e.end;if("Invalid Date"==n||null==n)n=null;else{var a=new Date(n).toLocaleDateString();n=new Date(a).toLocaleDateString("en-GB",{day:"numeric",month:"short",year:"numeric"}).split(" ").join(" ")}str_dt(e.start)===str_dt(e.end)&&(n=null);var d=e.start;if("Invalid Date"==d||null==d)d=null;else{a=new Date(d).toLocaleDateString();d=new Date(a).toLocaleDateString("en-GB",{day:"numeric",month:"short",year:"numeric"}).split(" ").join(" ")}var i=n?" to "+n:"",l=e.className.split("-"),o=e.description?e.description:"";if((r=tConvert(getTime(e.start)))==(c=tConvert(getTime(e.end))))var r="Full day event",c=null;c=c?" to "+c:"";u_event="<div class='card mb-3'>                        <div class='card-body'>                            <div class='d-flex mb-3'>                                <div class='flex-grow-1'><i class='mdi mdi-checkbox-blank-circle me-2 text-"+l[2]+"'></i><span class='fw-medium'>"+d+i+"</span></div>                                <div class='flex-shrink-0'><small class='badge badge-soft-primary ms-auto'>"+r+c+"</small></div>                            </div>                            <h6 class='card-title fs-16'> "+t+"</h6>                            <p class='text-muted text-truncate-two-lines mb-0'> "+o+"</p>                        </div>                    </div>",document.getElementById("upcoming-event-list").innerHTML+=u_event}))}function getTime(e){if(null!=(e=new Date(e)).getHours())return e.getHours()+":"+(e.getMinutes()?e.getMinutes():0)}function tConvert(e){var t=e.split(":"),n=t[0],a=t[1],d=n>=12?"PM":"AM";return(n=(n%=12)||12)+":"+(a=a<10?"0"+a:a)+" "+d}document.addEventListener("DOMContentLoaded",(function(){flatPickrInit();var e=new bootstrap.Modal(document.getElementById("event-modal"),{keyboard:!1});document.getElementById("event-modal");var t=document.getElementById("modal-title"),n=document.getElementById("form-event"),a=null,d=document.getElementsByClassName("needs-validation"),i=new Date,l=i.getDate(),o=i.getMonth(),r=i.getFullYear(),c=FullCalendar.Draggable,s=document.getElementById("external-events"),m=[{id:153,title:"All Day Event",start:new Date(r,o,1),className:"bg-soft-primary",location:"San Francisco, US",allDay:!1,extendedProps:{department:"All Day Event"},description:"An all-day event is an event that lasts an entire day or longer"},{id:136,title:"Visit Online Course",start:new Date(r,o,l-5),end:new Date(r,o,l-2),allDay:!1,className:"bg-soft-warning",extendedProps:{department:"Long Event"},description:"Long Term Event means an incident that last longer than 12 hours."},{id:999,title:"Client Meeting with Alexis",start:new Date(r,o,l+22,20,0),end:new Date(r,o,l+24,16,0),allDay:!1,className:"bg-soft-danger",location:"California, US",extendedProps:{department:"Meeting with Alexis"},description:"A meeting is a gathering of two or more people that has been convened for the purpose of achieving a common goal through verbal interaction, such as sharing information or reaching agreement."},{id:991,title:"Repeating Event",start:new Date(r,o,l+4,16,0),end:new Date(r,o,l+9,16,0),allDay:!1,className:"bg-soft-primary",location:"Las Vegas, US",extendedProps:{department:"Repeating Event"},description:"A recurring or repeating event is simply any event that you will occur more than once on your calendar. "},{id:112,title:"Meeting With Designer",start:new Date(r,o,l,12,30),allDay:!1,className:"bg-soft-success",location:"Head Office, US",extendedProps:{department:"Meeting"},description:"Tell how to boost website traffic"},{id:113,title:"Weekly Strategy Planning",start:new Date(r,o,l+9),end:new Date(r,o,l+11),allDay:!1,className:"bg-soft-danger",location:"Head Office, US",extendedProps:{department:"Lunch"},description:"Strategies for Creating Your Weekly Schedule"},{id:875,title:"Birthday Party",start:new Date(r,o,l+1,19,0),allDay:!1,className:"bg-soft-success",location:"Los Angeles, US",extendedProps:{department:"Birthday Party"},description:"Family slumber party – Bring out the blankets and pillows and have a family slumber party! Play silly party games, share special snacks and wind down the fun with a special movie."},{id:783,title:"Click for Google",start:new Date(r,o,28),end:new Date(r,o,29),url:"http://google.com/",className:"bg-soft-dark"},{id:456,title:"Velzon Project Discussion with Team",start:new Date(r,o,l+23,20,0),end:new Date(r,o,l+24,16,0),allDay:!1,className:"bg-soft-info",location:"Head Office, US",extendedProps:{department:"Discussion"},description:"Tell how to boost website traffic"}];new c(s,{itemSelector:".external-event",eventData:function(e){return{title:e.innerText,start:new Date,className:e.getAttribute("data-class")}}});document.getElementById("external-events");var u=document.getElementById("calendar");function v(d){document.getElementById("form-event").reset(),document.getElementById("btn-delete-event").setAttribute("hidden",!0),e.show(),n.classList.remove("was-validated"),n.reset(),a=null,t.innerText="Add Event",d,document.getElementById("edit-event-btn").setAttribute("data-id","new-event"),document.getElementById("edit-event-btn").click(),document.getElementById("edit-event-btn").setAttribute("hidden",!0)}function g(){return window.innerWidth>=768&&window.innerWidth<1200?"timeGridWeek":window.innerWidth<=768?"listMonth":"dayGridMonth"}var p=!0,y=new Choices("#event-category",{searchEnabled:!1}),E=new FullCalendar.Calendar(u,{timeZone:"local",editable:!0,droppable:!0,selectable:!0,navLinks:!0,initialView:g(),themeSystem:"bootstrap",headerToolbar:{left:"prev,next today",center:"title",right:"dayGridMonth,timeGridWeek,timeGridDay,listMonth"},windowResize:function(e){var t=g();E.changeView(t)},eventClick:function(d){document.getElementById("edit-event-btn").removeAttribute("hidden"),document.getElementById("btn-save-event").setAttribute("hidden",!0),document.getElementById("edit-event-btn").setAttribute("data-id","edit-event"),document.getElementById("edit-event-btn").innerHTML="Edit",eventClicked(),flatPickrInit(),flatpicekrValueClear(),e.show(),n.reset(),a=d.event,document.getElementById("modal-title").innerHTML="",document.getElementById("event-location-tag").innerHTML=void 0===a.extendedProps.location?"No Location":a.extendedProps.location,document.getElementById("event-description-tag").innerHTML=void 0===a.extendedProps.description?"No Description":a.extendedProps.description,document.getElementById("event-title").value=a.title,document.getElementById("event-location").value=void 0===a.extendedProps.location?"No Location":a.extendedProps.location,document.getElementById("event-description").value=void 0===a.extendedProps.description?"No Description":a.extendedProps.description,document.getElementById("eventid").value=a.id,a.classNames[0]&&(y.destroy(),(y=new Choices("#event-category",{searchEnabled:!1})).setChoiceByValue(a.classNames[0]));var i=a.start,l=a.end,o=function(e){var t=new Date(e),n=""+(t.getMonth()+1),a=""+t.getDate(),d=t.getFullYear();return n.length<2&&(n="0"+n),a.length<2&&(a="0"+a),[d,n,a].join("-")},r=null==l?str_dt(i):str_dt(i)+" to "+str_dt(l),c=null==l?o(i):o(i)+" to "+o(l);flatpickr(start_date,{defaultDate:c,altInput:!0,altFormat:"j F Y",dateFormat:"Y-m-d",mode:"range",onChange:function(e,t,n){t.split("to").length>1?document.getElementById("event-time").setAttribute("hidden",!0):(document.getElementById("timepicker1").parentNode.classList.remove("d-none"),document.getElementById("timepicker1").classList.replace("d-none","d-block"),document.getElementById("timepicker2").parentNode.classList.remove("d-none"),document.getElementById("timepicker2").classList.replace("d-none","d-block"),document.getElementById("event-time").removeAttribute("hidden"))}}),document.getElementById("event-start-date-tag").innerHTML=r;var s=getTime(a.start),m=getTime(a.end);s==m?(document.getElementById("event-time").setAttribute("hidden",!0),flatpickr(document.getElementById("timepicker1"),{enableTime:!0,noCalendar:!0,dateFormat:"H:i"}),flatpickr(document.getElementById("timepicker2"),{enableTime:!0,noCalendar:!0,dateFormat:"H:i"})):(document.getElementById("event-time").removeAttribute("hidden"),flatpickr(document.getElementById("timepicker1"),{enableTime:!0,noCalendar:!0,dateFormat:"H:i",defaultDate:s}),flatpickr(document.getElementById("timepicker2"),{enableTime:!0,noCalendar:!0,dateFormat:"H:i",defaultDate:m}),document.getElementById("event-timepicker1-tag").innerHTML=tConvert(s),document.getElementById("event-timepicker2-tag").innerHTML=tConvert(m)),null,t.innerText=a.title,document.getElementById("btn-delete-event").removeAttribute("hidden")},dateClick:function(e){v(e)},eventSources:[{url:"/assets/js/pages/event.init.json",method:"GET",extraParams:{custom_param1:"something",custom_param2:"somethingelse"},success:function(e){p&&(e.forEach((function(e){var t={id:e.id,title:e.title,start:new Date(e.start),end:new Date(e.end),className:e.className,description:e.description};m.push(t)})),upcomingEvent(m),p=!1)}}],events:m,eventReceive:function(e){var t={id:Math.floor(11e3*Math.random()),title:e.event.title,start:e.event.start,allDay:e.event.allDay,className:e.event.classNames[0]};m.push(t),upcomingEvent(m)},eventDrop:function(e){var t=m.findIndex((function(t){return t.id==e.event.id}));m[t]&&(m[t].title=e.event.title,m[t].start=e.event.start,m[t].end=e.event.end?e.event.end:null,m[t].allDay=e.event.allDay,m[t].className=e.event.classNames[0],m[t].description=e.event._def.extendedProps.description?e.event._def.extendedProps.description:"",m[t].location=e.event._def.extendedProps.location?e.event._def.extendedProps.location:"");Math.floor(11e3*Math.random()),e.event.title,e.event.start,e.event.allDay,e.event.classNames[0];upcomingEvent(m)}});E.render(),n.addEventListener("submit",(function(t){t.preventDefault();var n=document.getElementById("event-title").value,i=document.getElementById("event-category").value,l=document.getElementById("event-start-date").value.split("to"),o=new Date(l[0].trim()),r=l[1]?new Date(l[1].trim()):"",c=null,s=document.getElementById("event-location").value,u=document.getElementById("event-description").value,v=document.getElementById("eventid").value,g=!1;if(l.length>1){var p=new Date(l[1]);p=p.setTime(p.getTime()+828e5),l=new Date(l[0])}else{var y=l,b=document.getElementById("timepicker1").value.trim(),f=document.getElementById("timepicker2").value.trim();l=new Date(l+"T"+b),c=new Date(y+"T"+f),g=!0}var I=m.length+1;if(!1===d[0].checkValidity())d[0].classList.add("was-validated");else{if(a){a.setProp("id",v),a.setProp("title",n),a.setProp("classNames",[i]),a.setStart(o),a.setEnd(r),a.setAllDay(g),a.setExtendedProp("description",u),a.setExtendedProp("location",s);var B=m.findIndex((function(e){return e.id==a.id}));m[B]&&(m[B].title=n,m[B].start=o,m[B].end=r,m[B].allDay=g,m[B].className=i,m[B].description=u,m[B].location=s),E.render()}else{var k={id:I,title:n,start:l,end:c,allDay:g,className:i,description:u,location:s};E.addEvent(k),m.push(k)}e.hide(),upcomingEvent(m)}})),document.getElementById("btn-delete-event").addEventListener("click",(function(t){if(a){for(var n=0;n<m.length;n++)m[n].id==a.id&&(m.splice(n,1),n--);upcomingEvent(m),a.remove(),a=null,e.hide()}})),document.getElementById("btn-new-event").addEventListener("click",(function(e){flatpicekrValueClear(),flatPickrInit(),v(),document.getElementById("edit-event-btn").setAttribute("data-id","new-event"),document.getElementById("edit-event-btn").click(),document.getElementById("edit-event-btn").setAttribute("hidden",!0)}))}));var str_dt=function(e){var t=new Date(e),n=""+["January","February","March","April","May","June","July","August","September","October","November","December"][t.getMonth()],a=""+t.getDate(),d=t.getFullYear();return n.length<2&&(n="0"+n),a.length<2&&(a="0"+a),[a+" "+n,d].join(",")};
