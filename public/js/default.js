const toggleSidebar = document.querySelector(".toggle-sidebar");
const closeSidebar = document.querySelector(".close-sidebar");
const sidebar = document.querySelector(".sidebar");

toggleSidebar.addEventListener("click", () => {
    sidebar.classList.toggle("active");
});

closeSidebar.addEventListener("click", () => {
    sidebar.classList.remove("active");
});