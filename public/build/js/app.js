let paso=1;const pasoInicial=1,pasoFinal=3,cita={nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI()}function mostrarSeccion(){const o=document.querySelector(".mostrar");o&&o.classList.remove("mostrar");const e="#paso-"+paso;document.querySelector(e).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(o=>{o.addEventListener("click",(function(o){paso=parseInt(o.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const o=document.querySelector("#anterior"),e=document.querySelector("#siguiente");1===paso?(o.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(o.classList.remove("ocultar"),e.classList.add("ocultar")):(o.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(console.log(paso),paso++,botonesPaginador())}))}async function consultarAPI(){try{const o="http://localhost:3000/api/servicios",e=await fetch(o);mostrarServicios(await e.json())}catch(o){console.log(o)}}function mostrarServicios(o){o.forEach(o=>{const{id:e,nombre:t,precio:c}=o,a=document.createElement("P");a.classList.add("nombre-servicio"),a.textContent=t;const s=document.createElement("P");s.classList.add("precio-servicio"),s.textContent="$"+c;const n=document.createElement("DIV");n.classList.add("servicio"),n.dataset.idServicio=e,n.onclick=function(){seleccionarServicio(o)},n.appendChild(a),n.appendChild(s),document.querySelector("#servicios").appendChild(n)})}function seleccionarServicio(o){const{id:e}=o,{servicios:t}=cita;cita.servicios=[...t,o];document.querySelector(`[data-id-servicio="${e}"]`).classList.add("seleccionado"),console.log(o)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));