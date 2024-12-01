document.addEventListener("DOMContentLoaded", function () {
    const modalButton = document.getElementById("createProductModalButton");
    const modal = document.getElementById("createProductModal");
    
    modalButton.addEventListener("click", () => {
        console.log("Modal button clicked");
        modal.classList.toggle("hidden");
    });

    const closeButton = modal.querySelector("[data-modal-toggle='createProductModal']");
    closeButton.addEventListener("click", () => {
        modal.classList.add("hidden");
    });
});