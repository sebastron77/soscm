document.addEventListener('DOMContentLoaded', function () {
    const headerMes = document.getElementById('nombreMes');
    const diasMes = document.getElementById('diasMes');

    function mostrarCalendario(mes, anio) {
    const primerDiaMes = new Date(anio, mes, 1);
    const ultimoDiaMes = new Date(anio, mes + 1, 0);

      // Configurar el texto del encabezado con el mes y año actual
    headerMes.textContent = obtenerNombreMes(mes);

      // Limpiar días anteriores
    diasMes.innerHTML = '';

      // Generar días del mes
    for (let dia = 1; dia <= ultimoDiaMes.getDate(); dia++) {
            const fecha = new Date(anio, mes, dia);
            const nombreDia = obtenerNombreDia(fecha.getDay());
            const diaElemento = document.createElement('span');
            diaElemento.textContent = dia;
            diaElemento.title = `${nombreDia}, ${dia} ${obtenerNombreMes(mes)} ${anio}`;
            diasMes.appendChild(diaElemento);
        }
    }

    function cambiarMes(cambio) {
        const fechaActual = new Date();
        let mesActual = fechaActual.getMonth() + cambio;
        let anioActual = fechaActual.getFullYear();

        if (mesActual < 0) {
            mesActual = 11;
            anioActual--;
        } else if (mesActual > 11) {
            mesActual = 0;
            anioActual++;
        }

        mostrarCalendario(mesActual, anioActual);
    }

    function obtenerNombreMes(mes) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return meses[mes];
    }

    function obtenerNombreDia(dia) {
        const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return dias[dia];
    }

    // Obtener mes y año actual
    const fechaActual = new Date();
    const mesActual = fechaActual.getMonth();
    const anioActual = fechaActual.getFullYear();

    mostrarCalendario(mesActual, anioActual);
});
