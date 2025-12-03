// =============== FECHA Y HORA ===============
function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    document.getElementById("datetime").textContent = now.toLocaleString('es-ES', options);
}
setInterval(updateDateTime, 1000);
updateDateTime();


// =============== STICKY HEADER (solo desktop) ===============
const mainHeader = document.getElementById("mainHeader");
const topHeader = document.querySelector(".top-header");
const triggerPoint = topHeader.offsetHeight;

// Placeholder para evitar salto
const placeholder = document.createElement("div");
placeholder.style.display = "none";
placeholder.style.height = mainHeader.offsetHeight + "px";
mainHeader.after(placeholder);

window.addEventListener("scroll", () => {
    if (window.innerWidth > 768) {   // Solo en desktop
        if (window.scrollY > triggerPoint) {
            mainHeader.classList.add("sticky");
            placeholder.style.display = "block";
        } else {
            mainHeader.classList.remove("sticky");
            placeholder.style.display = "none";
        }
    }
});


// =============== MENÚ HAMBURGUESA ===============
const hamburgerBtn = document.getElementById("hamburgerBtn");
const mobileMenu = document.getElementById("mobileMenu");

hamburgerBtn.addEventListener("click", () => {
    mobileMenu.style.display =
        mobileMenu.style.display === "block" ? "none" : "block";
});


// =============== BOTÓN VOLVER ARRIBA ===============
const btnTop = document.getElementById("btnTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
        btnTop.style.display = "flex";
    } else {
        btnTop.style.display = "none";
    }
});

btnTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
});
