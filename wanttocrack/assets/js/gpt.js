const chatToggleBtn = document.getElementById('chat-toggle-btn');
        const chatContainer = document.getElementById('chat-container');
        const chatForm = document.getElementById('chat-form');
        const chatMessages = document.getElementById('chat-messages');
        const userMessageInput = document.getElementById('user-message');

        // Alternar visibilidad del chat
        chatToggleBtn.addEventListener('click', () => {
            chatContainer.style.display = chatContainer.style.display === 'none' ? 'flex' : 'none';
        });

        // Manejar envío de mensajes
        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            // Obtener mensaje del usuario
            const userMessage = userMessageInput.value.trim();
            if (!userMessage) return;

            // Agregar mensaje del usuario al chat
            addMessageToChat('user', userMessage);

            // Limpiar campo de entrada
            userMessageInput.value = '';

            try {
                // Enviar mensaje al servidor
                const response = await fetch('./funciones/gpt-process.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: userMessage }),
                });

                const data = await response.json();

                // Mostrar respuesta de ChatGPT
                if (data.response) {
                    addMessageToChat('bot', data.response);
                } else {
                    addMessageToChat('bot', 'Error: No se pudo obtener una respuesta.');
                }
            } catch (error) {
                addMessageToChat('bot', 'Error: Problema al conectar con el servidor.');
            }
        });

        // Agregar mensaje al chat
        function addMessageToChat(sender, message) {
            const messageElement = document.createElement('div');
            messageElement.className = `message ${sender}`;
            messageElement.innerHTML = `<span>${message}</span>`;
            chatMessages.appendChild(messageElement);

            // Desplazarse hacia abajo
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }