const statementFieldOpen = document.querySelector(".statement_field_open");
const closeButton = document.querySelector(".statement_block_btn_close");


function closeModal() {
    statementFieldOpen.classList.remove("opened");
}

function openModal() {

    statementFieldOpen.classList.add("opened");
}

closeButton.addEventListener("click", closeModal);

statementFieldOpen.addEventListener("click", function(event) {
    if (event.target === statementFieldOpen) {
        closeModal();
    }
});

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape" && statementFieldOpen.classList.contains("opened")) {
        closeModal();
    }
});

function confirmSendComplaint() {
    openModal();
}