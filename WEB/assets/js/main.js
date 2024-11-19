document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggle-sidebar");
    const toggleIcon = document.getElementById("toggle-icon");
    const mainContent = document.getElementById("main-content");

    // Manejador de evento para cambiar el tamaño de la ventana
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 992) {
            // Si la pantalla es grande, asegúrate de que el sidebar esté visible
            sidebar.classList.remove("active");
            toggleIcon.classList.replace("lni-chevron-right", "lni-chevron-left");
        } else {
            // Si la pantalla es pequeña, ocultar el sidebar
            sidebar.classList.add("active");
            toggleIcon.classList.replace("lni-chevron-left", "lni-chevron-right");
        }
    });

    toggleButton.addEventListener("click", () => {
        sidebar.classList.toggle("active");

        // Cambiar la dirección de la flecha
        if (sidebar.classList.contains("active")) {
            toggleIcon.classList.replace("lni-chevron-left", "lni-chevron-right");
        } else {
            toggleIcon.classList.replace("lni-chevron-right", "lni-chevron-left");
        }
    });
});
