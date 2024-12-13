<?php
echo ('
    <!-- Botón flotante -->
    <button id="chat-toggle-btn">💬</button>

    <!-- Contenedor del chat -->
    <div id="chat-container">
        <div id="chat-header">Chat con ChatGPT</div>
        <div id="chat-messages"></div>
        <form id="chat-form">
            <input type="text" id="user-message" class="form-control" placeholder="Escribe tu mensaje..." required>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
');