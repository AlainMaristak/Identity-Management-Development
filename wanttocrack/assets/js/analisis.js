const form = document.getElementById('ipForm');
const progressBar = document.getElementById('progressBar');
const progressContainer = document.getElementById('progressContainer');
const resultContainer = document.getElementById('result');
let activeInterval = null; // Almacena el identificador del intervalo activo

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const ipData = {
        ip1: document.getElementById('ip1').value,
        ip2: document.getElementById('ip2').value,
        ip3: document.getElementById('ip3').value,
        ip4: document.getElementById('ip4').value,
    };

    const fullIP = `${ipData.ip1}.${ipData.ip2}.${ipData.ip3}.${ipData.ip4}`;

    if (!/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/.test(fullIP)) {
        resultContainer.innerHTML = '<div class="text-danger">Por favor, introduce una dirección IP válida.</div>';
        return;
    }

    progressContainer.style.display = 'block';
    resultContainer.innerHTML = '';
    // Obtener el valor del modo de escaneo seleccionado
    const modoEscaneo = document.querySelector('input[name="modo_escaneo"]:checked').id;

    // Switch dependiendo del valor seleccionado
    switch (modoEscaneo) {
        //////////////    ANALISIS SIMPLE
        case 'modo_escaneo_simple':
            animateProgressBar(tiempo = 25);
            try {
                const response = await fetch('./funciones/api_analisis_simple.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ip: fullIP }),
                });

                const result = await response.json(); // Asume que el servidor devuelve JSON

                // Oculta la barra de progreso
                progressContainer.style.display = 'none';

                // Verifica si hay un mensaje de éxito y datos completos
                if (result.status === 'success' && result.data) {
                    const ipData = result.data[fullIP]; // Accede a los datos específicos de la IP

                    if (ipData) {
                        let resultHTML = `
                    <div class="text-success">Análisis completado para IP: ${fullIP}</div>
                    <div><strong>Estado:</strong> ${ipData.status.state || 'Desconocido'}</div>
                    <div><strong>Razón:</strong> ${ipData.status.reason || 'Desconocido'}</div>
                    <div><strong>Dirección IPv4:</strong> ${ipData.addresses.ipv4 || 'Desconocido'}</div>
                    <div><strong>MAC Address:</strong> ${ipData.addresses.mac || 'Desconocido'}</div>
                    <div><strong>Nombres de Host:</strong> 
                        ${ipData.hostnames.length > 0 ? ipData.hostnames.map(h => h.name).join(', ') : 'No disponible'}
                    </div>
                    <div><strong>Puertos:</strong></div>
                `;

                        // Si hay puertos, los mostramos
                        if (ipData.tcp && Object.keys(ipData.tcp).length > 0) {
                            Object.entries(ipData.tcp).forEach(([port, details]) => {
                                resultHTML += `
                            <div>
                                <strong>Puerto ${port}</strong>: ${details.name || 'Desconocido'} 
                                - Estado: ${details.state || 'Desconocido'} 
                                - Razón: ${details.reason || 'Desconocido'} 
                                - Producto: ${details.product || 'Desconocido'} 
                                ${details.version ? `- Versión: ${details.version}` : ''}
                            </div>
                        `;
                            });
                        } else {
                            resultHTML += '<div>No se encontraron puertos.</div>';
                        }

                        resultContainer.innerHTML = resultHTML;
                    } else {
                        resultContainer.innerHTML = `<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>`;
                    }
                } else {
                    // Si no hay datos o el análisis falló
                    resultContainer.innerHTML = `<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>`;
                }
            } catch (error) {
                // Manejo de errores
                progressContainer.style.display = 'none';
                resultContainer.innerHTML = `<div class="text-danger">Error al realizar el análisis: ${error.message}</div>`;
            }
            break;

        //////////////    ANALISIS COMPLETO
        case 'modo_escaneo_completo':
            animateProgressBar(tiempo = 25);
            try {
                const response = await fetch('./funciones/api_analisis_completo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ip: fullIP }),
                });

                const result = await response.json(); // Asume que el servidor devuelve JSON

                // Oculta la barra de progreso
                progressContainer.style.display = 'none';

                // Verifica si hay un mensaje de éxito y datos completos
                if (result.status === 'success' && result.data) {
                    const ipData = result.data[fullIP]; // Accede a los datos específicos de la IP

                    if (ipData) {
                        let resultHTML = `
                    <div class="text-success">Análisis completado para IP: ${fullIP}</div>
                    <div><strong>Estado:</strong> ${ipData.status.state || 'Desconocido'}</div>
                    <div><strong>Razón:</strong> ${ipData.status.reason || 'Desconocido'}</div>
                    <div><strong>Dirección IPv4:</strong> ${ipData.addresses.ipv4 || 'Desconocido'}</div>
                    <div><strong>MAC Address:</strong> ${ipData.addresses.mac || 'Desconocido'}</div>
                    <div><strong>Uptime:</strong> ${ipData.uptime.lastboot || 'Desconocido'} (Segundos: ${ipData.uptime.seconds || 'Desconocido'})</div>
                    <div><strong>SO:</strong> ${ipData.osmatch.length > 0 ? ipData.osmatch.map(os => os.name).join(', ') : 'Desconocido'}</div>
                    <div><strong>Puertos:</strong></div>
                `;

                        // Si hay puertos, los mostramos
                        if (ipData.tcp && Object.keys(ipData.tcp).length > 0) {
                            Object.entries(ipData.tcp).forEach(([port, details]) => {
                                resultHTML += `
                            <div>
                                <strong>Puerto ${port}</strong>: ${details.name || 'Desconocido'} 
                                - Estado: ${details.state || 'Desconocido'} 
                                - Razón: ${details.reason || 'Desconocido'} 
                                - Producto: ${details.product || 'Desconocido'} 
                                ${details.version ? `- Versión: ${details.version}` : ''}
                            </div>
                        `;
                            });
                        } else {
                            resultHTML += '<div>No se encontraron puertos.</div>';
                        }

                        // Mostrar puertos usados (TCP/UDP)
                        resultHTML += `<div><strong>Puertos usados:</strong></div>`;
                        ipData.portused.forEach(port => {
                            resultHTML += `
                        <div><strong>Puerto ${port.portid} (${port.proto})</strong>: ${port.state}</div>
                    `;
                        });

                        resultContainer.innerHTML = resultHTML;
                    } else {
                        resultContainer.innerHTML = `<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>`;
                    }
                } else {
                    // Si no hay datos o el análisis falló
                    resultContainer.innerHTML = `<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>`;
                }
            } catch (error) {
                // Manejo de errores
                progressContainer.style.display = 'none';
                resultContainer.innerHTML = `<div class="text-danger">Error al realizar el análisis: ${error.message}</div>`;
            }
            break;

        //////////////    ANALISIS DE VULNERABILIDADES 
        case 'modo_escaneo_vulnerabilidades':
            animateProgressBar(tiempo = 600);
            try {
                const response = await fetch('./funciones/api_analisis_vulnerabilidades.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ip: fullIP }),
                });

                const result = await response.json();

                progressContainer.style.display = 'none';
                stopProgressBar();

                if (result.message === 'Análisis completado' && result.data) {
                    let resultHTML = `
                <div class="text-success">Análisis completado para IP: ${result.data.IP}</div>
                <div><strong>Estado:</strong> ${result.data.Estado}</div>
                <div><strong>Razón:</strong> ${result.data.Razón}</div>
                <div><strong>Dirección IPv4:</strong> ${result.data['Dirección IPv4']}</div>
                <div><strong>MAC Address:</strong> ${result.data['MAC Address']}</div>
                <div><strong>Nombres de Host:</strong> ${result.data['Nombres de Host'] || 'No disponible'}</div>
                <div><strong>Puertos:</strong></div>
            `;

                    if (result.data.Puertos && result.data.Puertos.length > 0) {
                        result.data.Puertos.forEach(port => {
                            resultHTML += `
                        <div>
                            <strong>Puerto ${port.Puerto}</strong>: ${port.Nombre || 'Desconocido'} 
                            - Estado: ${port.Estado || 'Desconocido'} 
                            - Razón: ${port.Razón || 'Desconocido'}
                        </div>
                    `;

                            if (port.Script && Object.keys(port.Script).length > 0) {
                                resultHTML += '<div><strong>Detalles del Script:</strong></div><ul>';
                                for (const [key, value] of Object.entries(port.Script)) {
                                    resultHTML += `<li><strong>${key}:</strong> ${value}</li>`;
                                }
                                resultHTML += '</ul>';
                            }
                        });
                    } else {
                        resultHTML += '<div>No se encontraron puertos.</div>';
                    }

                    resultContainer.innerHTML = resultHTML;
                } else {
                    resultContainer.innerHTML = '<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>';
                }
            } catch (error) {
                progressContainer.style.display = 'none';
                resultContainer.innerHTML = `<div class="text-danger">Error al realizar el análisis: ${error.message}</div>`;
            }
            break;
        default:

            console.log('Modo de escaneo no seleccionado');
            break;
    }
    // try {
    //     const response = await fetch('./funciones/api_analisis4.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //         },
    //         body: JSON.stringify({ ip: fullIP }),
    //     });

    //     const result = await response.json();

    //     progressContainer.style.display = 'none';

    //     if (result.message === 'Análisis completado' && result.data) {
    //         let resultHTML = `
    //             <div class="text-success">Análisis completado para IP: ${result.data.IP}</div>
    //             <div><strong>Estado:</strong> ${result.data.Estado}</div>
    //             <div><strong>Razón:</strong> ${result.data.Razón}</div>
    //             <div><strong>Dirección IPv4:</strong> ${result.data['Dirección IPv4']}</div>
    //             <div><strong>MAC Address:</strong> ${result.data['MAC Address']}</div>
    //             <div><strong>Nombres de Host:</strong> ${result.data['Nombres de Host'] || 'No disponible'}</div>
    //             <div><strong>Puertos:</strong></div>
    //         `;

    //         if (result.data.Puertos && result.data.Puertos.length > 0) {
    //             result.data.Puertos.forEach(port => {
    //                 resultHTML += `
    //                     <div>
    //                         <strong>Puerto ${port.Puerto}</strong>: ${port.Nombre || 'Desconocido'} 
    //                         - Estado: ${port.Estado || 'Desconocido'} 
    //                         - Razón: ${port.Razón || 'Desconocido'}
    //                     </div>
    //                 `;

    //                 if (port.Script && Object.keys(port.Script).length > 0) {
    //                     resultHTML += '<div><strong>Detalles del Script:</strong></div><ul>';
    //                     for (const [key, value] of Object.entries(port.Script)) {
    //                         resultHTML += `<li><strong>${key}:</strong> ${value}</li>`;
    //                     }
    //                     resultHTML += '</ul>';
    //                 }
    //             });
    //         } else {
    //             resultHTML += '<div>No se encontraron puertos.</div>';
    //         }

    //         resultContainer.innerHTML = resultHTML;
    //     } else {
    //         resultContainer.innerHTML = '<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>';
    //     }
    // } catch (error) {
    //     progressContainer.style.display = 'none';
    //     resultContainer.innerHTML = `<div class="text-danger">Error al realizar el análisis: ${error.message}</div>`;
    // }
});

// Función para animar la barra de progreso

function animateProgressBar(tiempo) {
    // Si ya hay un intervalo activo, lo detiene antes de iniciar uno nuevo
    if (activeInterval !== null) {
        clearInterval(activeInterval);
        activeInterval = null; // Libera el identificador del intervalo
    }
    let progreso = 100 / tiempo;
    let width = 0;
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');

    activeInterval = setInterval(() => {
        if (width >= 100) {
            clearInterval(activeInterval); // Detiene el intervalo cuando la barra está completa
            activeInterval = null; // Libera el identificador del intervalo
        } else {
            width += progreso; // La barra incrementa un 4% cada segundo. Tarda un total de 25s en completarse
            progressBar.style.width = `${width}%`;
            progressBar.setAttribute('aria-valuenow', `${width}`);
        }
    }, 1000);
}

// Cuando quieras detener la animación por completo
function stopProgressBar() {
    if (activeInterval !== null) {
        clearInterval(activeInterval); // Detiene el intervalo
        activeInterval = null; // Libera el identificador
    }
    progressBar.style.width = '0%'; // Resetea la barra si es necesario
    progressBar.setAttribute('aria-valuenow', '0');
}
