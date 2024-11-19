const form = document.getElementById('ipForm');
const progressBar = document.getElementById('progressBar');
const progressContainer = document.getElementById('progressContainer');
const resultContainer = document.getElementById('result');

form.addEventListener('submit', async (e) => {
    e.preventDefault(); // Evita el envío normal del formulario

    // Recolecta los datos del formulario
    const ipData = {
        ip1: document.getElementById('ip1').value,
        ip2: document.getElementById('ip2').value,
        ip3: document.getElementById('ip3').value,
        ip4: document.getElementById('ip4').value,
    };

    // Construye la dirección IP completa
    const fullIP = `${ipData.ip1}.${ipData.ip2}.${ipData.ip3}.${ipData.ip4}`;

    // Validación básica
    if (!/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/.test(fullIP)) {
        resultContainer.innerHTML = '<div class="text-danger">Por favor, introduce una dirección IP válida.</div>';
        return;
    }

    // Muestra la barra de progreso
    progressContainer.style.display = 'block';
    resultContainer.innerHTML = ''; // Limpia el resultado anterior
    animateProgressBar();

    // Realiza la solicitud AJAX
    try {
        const response = await fetch('./funciones/api_analisis2.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ip: fullIP }),
        });
    
        const result = await response.json(); // Asume que el servidor devuelve JSON
    
        // Oculta la barra de progreso y muestra el resultado
        progressContainer.style.display = 'none';
    
        // Verifica si hay un mensaje de éxito y los datos completos
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
    
            // Si hay puertos, los mostramos
            if (result.data.Puertos && result.data.Puertos.length > 0) {
                result.data.Puertos.forEach(port => {
                    resultHTML += `
                        <div>
                            <strong>Puerto ${port.Puerto}</strong>: ${port.Nombre || 'Desconocido'} 
                            - Estado: ${port.Estado || 'Desconocido'} - Razón: ${port.Razón || 'Desconocido'}
                        </div>
                    `;
                });
            } else {
                resultHTML += '<div>No se encontraron puertos.</div>';
            }
    
            resultContainer.innerHTML = resultHTML;
        } else {
            // Si no hay datos o el análisis falló
            resultContainer.innerHTML = `<div class="text-danger">No se encontraron datos para la IP proporcionada.</div>`;
        }
    } catch (error) {
        // Manejo de errores
        progressContainer.style.display = 'none';
        resultContainer.innerHTML = `<div class="text-danger">Error al realizar el análisis: ${error.message}</div>`;
    }
});

// Función para animar la barra de progreso
function animateProgressBar() {
    let width = 0;
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');

    const interval = setInterval(() => {
        if (width >= 100) {
            clearInterval(interval);
        } else {
            width += 4; // Incremento proporcional para 25s
            progressBar.style.width = `${width}%`;
            progressBar.setAttribute('aria-valuenow', `${width}`);
        }
    }, 1000); // Intervalo ajustado para que termine en 25s
}

// Función para limpiar los campos del formulario
function resetInputs() {
    document.getElementById('ip1').value = '';
    document.getElementById('ip2').value = '';
    document.getElementById('ip3').value = '';
    document.getElementById('ip4').value = '';
    resultContainer.innerHTML = '';
    document.getElementById('ip1').focus();
}

