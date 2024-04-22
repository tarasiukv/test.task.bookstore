const addBookButton = document.getElementById('addBookButton');
const addBookForm = document.querySelector('.checkout');
const modal = document.getElementById('myModal');
const closeButton = document.getElementById('closeButton');

addBookButton.addEventListener('click', () => {
    addBookForm.style.display = 'block';
    modal.style.display = "block";
});

closeButton.addEventListener('click', () => {
    addBookForm.style.display = 'none';
    modal.style.display = "none";
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        addBookForm.style.display = 'none';
        modal.style.display = "none";
    }
});