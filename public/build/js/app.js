let paso = 1; //Le ponemos let=1 porque este va a cambiar y escogemos el primero por el que empieza 
const pasoInicial = 1;
const pasoFinal = 3;


/** OBJETO DE CITA **/ 
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}
 
document.addEventListener('DOMContentLoaded',function(){ //DOMContentLoaded = Cuando la carga del contenido del DOM haya completado

    iniciarApp();

}); 


/*********** FUNCION PRINCIPAL **********/ 
function iniciarApp(){

    mostrarSeccion();   //Muestra y oculta las secciones
    tabs();             //Cambia la seccion cuando se presionen los tabs 
    botonesPaginador(); //Agrega o quita los botones del paginador 
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); //Consulta la API en el backed de PHP

    idCliente();
    nombreCliente(); //Consulta el Nombre del Cliente y lo añade a la Cita
    seleccionarFecha(); //Añade una Fecha al Objeto Cita 
    seleccionarHora(); //Añade la Hora al Objeto de Cita

    mostrarResumen(); //Muestra el Resumen de la Cita

}

/**** MUESTRA LA SECCION QUE REQUIRAMOS *****/
function mostrarSeccion(){

    //Quitar el Mostrar que hayan anteriormente
    const seccionAnterior = document.querySelector('.mostrar');

    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    
    //Seleccionar la seccion 
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);

    //Mostrar la seccion que se dio click
    seccion.classList.add('mostrar');

    const tabActual = document.querySelector('.actual');

    if(tabActual){
        tabActual.classList.remove('actual');
    }

    //Resalta el Tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
    

}

/**** CAMBIA LA SECCION CUANDO SE PRESIONEN LOS TABS *****/
function tabs(){
    const botones = document.querySelectorAll('.tabs button'); //Botones es un NodeList algo parecido a un Arreglo

    botones.forEach( (boton) => {

        boton.addEventListener('click',function(e){

            //Boton al que le doy click //Paso de los Tabs definido por dataset
            paso = parseInt(e.target.dataset.paso)//Traemos todos los Eventos Disponibles para cada Boton
            mostrarSeccion();
            botonesPaginador();

        }); 

    });
}

/**** DEFINIMOS EL PAGINADOR (SIGUIENTE-ANTERIOR) *****/
function botonesPaginador(){
    
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1 ){ //Se posiciona en el primer Paso es decir(Servicios)
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');

    }else if(paso === 3){ //Se posiciona en el ultimo Paso es decir(Resumen)
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
        // console.log(cita);
    }else{
        paginaSiguiente.classList.remove('ocultar');
        paginaAnterior.classList.remove('ocultar');
    }

}


/**** BOTON QUE NOS MUEVE HACE LA PAGINA SIGUIENTE *****/
function paginaSiguiente(){

    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click',function(e){
        if(paso >= pasoFinal) return;
        paso = paso + 1;
        botonesPaginador();
        mostrarSeccion();

    });
}

/**** BOTON QUE NOS MUEVE HACE LA PAGINA ANTERIOR *****/
function paginaAnterior(){

    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click',function(e){
        if(paso <= pasoInicial) return;
        paso = paso - 1;
        botonesPaginador();
        mostrarSeccion();
    });
}

/**** REQUERIMOS UNA API PARA CONSULTAR LOS SERVICIOS  *****/
async function consultarAPI() {
    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

/**** MOSTRAR LOS SERVICIOS UNA VEZ SE DE CLICK A ESE APARTADO  *****/
function mostrarServicios(servicios){
    //Servicios nos Trae un Arreglo por lo cual iteramos con ForEach

    servicios.forEach((servicio) =>{
        //Para obtener el valor de un arreglo en JavaScript utilizamos Destructuring - Separar
        const {id,nombre,precio} = servicio;

        //Parrafo con el Nombre
        const nombreServicio = document.createElement('P'); //Creamos un parrafo dentro de nuestro Documento
        nombreServicio.classList.add('nombre-servicio'); //A ese parrafo que ya creamos le agregamos una clase para darle estilos
        nombreServicio.textContent = nombre;

        //Parrafo con el Precio
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        //Div que contiene Nombre y Precio
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');

        servicioDiv.dataset.idServicio = id; //Creamos la el Identificador de cada servicio data-id-servicio = "";

        servicioDiv.onclick = function(){ //Callback - Cada vez que le demos click a ese div se debe ejecutar una funcion de SeleccionarServicio

            seleccionarServicio(servicio);
        }; 

        servicioDiv.appendChild(nombreServicio); //Dentro del div le colocamos el Nombre servicio
        servicioDiv.appendChild(precioServicio); //Dentro del div le colocamos el Precio servicio

        /** Mostramos en el Aparrado de Lista de Servicios ***/
        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}



/**** OBTENER LA INFORMACION DEL SERVICIO AL QUE LE DAMOS CLICK  *****/
function seleccionarServicio(servicio){

    const{id} = servicio; //Destructuring a los elementos del servicio
    const{servicios} = cita; //Obtenemos el Arreglo vacio Servicios de Cita 

    //Identificar el Elemento al que se le da click
    const divServicio_seleccionado = document.querySelector(`[data-id-servicio = "${servicio.id}"]`); //Nos ubicamos en el Div del Servicio Seleccionado
    

    //Comprobar si un servicio ya fue agregado /Es decir si tiene la clase 'seleccionado' si es asi quitarle esa clase
    //.some nos permite buscar en un arreglo si un elemento existe 
    if(servicios.some(servicio_agregado => servicio_agregado.id === servicio.id)){ //Por un lado tenemos los servicios que nos trae todos los que hemos dado click Y por otro lado servicio que es al que actualmente estamos dando click
        //Ya esta arregado y le estas dando click
        //Eliminamos del Arreglo de Cita
        cita.servicios = servicios.filter(servicio_agregado => servicio_agregado.id != servicio.id); //.filter excluye un elemento del arreglo como lo hace crea un arreglo identico con todos los elementos que cumplan con una condicion
        divServicio_seleccionado.classList.remove('seleccionado');
    }else{
        //Aun no se agrega este servicio //De esta forma evitamos el error de duplicar servicios ya agregados
        //Agregarlo al Arreglo de Cita
        cita.servicios = [...servicios, servicio]; //Hacemos una copia con el ... de servicios de la cita que esta vacio al servicio que tiene los Datos 
        divServicio_seleccionado.classList.add('seleccionado'); //Agregamos una clase para Aplicar Estilos al Servicio que el Usuario Selecciono
    }


}


/**** OBTENEMOS EL NOMBRE DEL CLIENTE Y LO AGREGAMOS AL OBJETO DE CITA  *****/
function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;
}


/**** OBTENEMOS EL ID DEL CLIENTE Y LO AGREGAMOS AL OBJETO DE CITA  *****/
function idCliente(){
    const id = document.querySelector('#id').value;
    cita.id = id;
}

/**** FUNCION QUE SE ENCARGA DE AGREGAR LA FECHA QUE ESCOGIO EL USUARIO AL OBJETO *****/
function seleccionarFecha(){

    const input_fecha = document.querySelector('#fecha'); //Seleccionamos la Fecha del HTML

    input_fecha.addEventListener('input', function(e){ //A esa input fecha le agregamos que este a espera del ingreso de la fecha 

        //Saber cuando es Sabado - Domingo dias en los que no se labora 
        //e.target.value = La fecha que el Usuario selecciono

        const dia = new Date(e.target.value).getUTCDay();  //Instanciamos el dia del Tipo Date() //getUTCDay nos trae las fechas en numeros es decir del 1 al 6 donde 1 es Lunes y 0 Domingo
        
        //Bloqueamos los dias sabado y domingo es decir 0 y 6
        if( [6,0].includes(dia) ){ //includes nos permite saber si en el dia que escoja el usuario se encuentra o el 6 o el 0

            e.target.value = ''; //Dejamos en vacio para indicar que dicha fecha no es valida 
            mostrarAlerta('Fines de Semana NO Permitido','error','#paso-2 p');

        }else{
            //Selecciono un dia Correcto
            cita.fecha = e.target.value; //Agregamos dentro de nuestro objeto de Cita La fecha que escogio el Usuario
        }
        
    }); 
}

/**** OBTENEMOS LA HORA INGRESADA POR EL USUARIO *****/
function seleccionarHora(){

    const input_hora = document.querySelector('#hora');
    input_hora.addEventListener('input', function(e){
        
        const hora_cita = e.target.value; //Hora ingresada por el Usuario
        const hora_cita_split = hora_cita.split(':');
        seleccion_only_hora_cita = parseInt(hora_cita_split[0]); //Selecciona solo la hora ya no los minutos

        if((seleccion_only_hora_cita < 8 || seleccion_only_hora_cita > 18 )){
   
                e.target.value = '';
                mostrarAlerta('Seleccionaste una Hora Incorrecta','error','#paso-2 p');
        }else{
            cita.hora = e.target.value;
            // console.log(cita);
        }
     
    });
}


/**** MOSTRAR ALERTAS *****/
function mostrarAlerta(mensaje, tipo, ubicacion_elemento, desaparece = true){

    const alerta_previa = document.querySelector('.alerta'); //Si ya existe una alerta
    //Si alerta previa existe entonces retorna la funcion para no repetir la alerta
    if(alerta_previa){
       alerta_previa.remove();
    }

    const alerta = document.createElement('DIV'); //Vamos a crear un Nuevo Elemento Un DIV
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    //Seleccionamos Donde va a Ir nuestra Alerta que acabamos de Crear
    const referencia = document.querySelector(ubicacion_elemento);
    referencia.appendChild(alerta);

    //Va hacer una Alerta Trnasitoria es decir va a Desaparecer
    if(desaparece == true){
        setTimeout(() => {
            alerta.remove(); //Quitamos la Alerta ya que es solo informativa
        }, 4000); //Dentro de 3s va a realizarse una accion
    }
 
}

/**** MUESTRA EL RESUMEN FINAL DE LA CITA *****/
function mostrarResumen(){

    const resumen = document.querySelector('.contenido-resumen'); //Seleccionamos el Resumen de la Cita

    const contenedorServicios = document.createElement('DIV');
    contenedorServicios.classList.add('contenedor-servicios');

    //Limpiar el Contenido del Resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild); //Si ya existe un contenido al principio lo remueves
    }


    //Verificacion cuando existen errores
    if(Object.values(cita).includes('') || cita.servicios.length === 0){

        mostrarAlerta('Existe un Error te Faltan Datos por Llenar','error','.contenido-resumen',false);
        return; //Para detener la ejecucion para no tener un else y continuar abajo
    }

    //Verificacion cuando todo esta correcto
    const {nombre, fecha, hora, servicios} = cita; //Aplicamos destructuring para obtener datos de la cita que deberia estar llena

    //Heading para el Resumen de Servicios
    const heading_cita = document.createElement('H3');
    heading_cita.textContent = "Resumen de Cita";

    const informacionCita = document.createElement('DIV');
    informacionCita.classList.add('informacion-cita');

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Formatear la Fecha en Español para el Usuario
    const fechaObj = new Date(fecha); //Tenemos que transformar la fecha en formato string a objeto para acceder a los metodos de Date()

    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2; //Es +2 porque existe un desface por usar getDate es decir si es por ejm: 20 de mayo getDay() = 19 de mayo como se ocupa 2 veces en +2
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia)); //Le damos formato UTC para que funcione en cualquier lugar

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}; //Para poder agregar la fecha en un Formato mas amigable de dia de la semana es decir si hoy es 20/5/2023 weekday:long nos trae el dia 'jueves'
    const fechaFormateada = fechaUTC.toLocaleDateString('es-Mx',opciones); //Confierte de hora a string segun un formato local en este caso es-Mx es decir ejm: 20/5/2023


    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;


    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} Horas`;



    //Heading para el Resumen de Servicios
    const heading_servicios = document.createElement('H3');
    heading_servicios.textContent = "Resumen de Servicios";




    //Iterando y Mostrando los Servicios
    servicios.forEach(servicio => {

        const {id ,precio, nombre} = servicio;

        const contenedor_servicio = document.createElement('DIV');
        contenedor_servicio.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;

        contenedor_servicio.appendChild(nombreServicio);
        contenedor_servicio.appendChild(precioServicio);

        contenedorServicios.appendChild(contenedor_servicio);
    });

  
    //Boton para Crear una Cita 
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.classList.add('btn-restablecer');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita; //No le ponemos como metodo reservarCita() si queremos mandar datos debes ser por callback es decir function {reservarCita('datos')}

    //Mostramos en la Vista
    resumen.appendChild(heading_cita);
    informacionCita.appendChild(nombreCliente);
    informacionCita.appendChild(fechaCliente);
    informacionCita.appendChild(horaCliente);
    resumen.appendChild(informacionCita);
    resumen.appendChild(heading_servicios);
    resumen.appendChild(contenedorServicios);

    resumen.appendChild(botonReservar);

}

//Conectamos con el Servidor por API y Fecth
async function reservarCita() {
    
    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id );
    // console.log(idServicios);

    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora );
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    try {
        // Petición hacia la api
        const url = `${location.origin}/api/citas`;

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        
        console.log(resultado);
        return;
        if(resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente',
                button: 'OK'
            }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        })
    }

    
    // console.log([...datos]);

}

