/* Page Market */
const urlParams = new URLSearchParams(window.location.search);
const action = urlParams.get('action');

if (action === 'market') {
    const searchBar = document.querySelector('.search_bar');
    if (searchBar) {
        const allBooks = document.querySelectorAll('figure');
        searchBar.addEventListener('input', (e) => {
            let value = e.target.value.trim()
            if (value.length > 2) {
                Array.from(allBooks).map((book) => {
                    let title = book.querySelector('figcaption h3').textContent.toLowerCase();
                    if (!title.includes(value.toLowerCase())) {
                        book.classList.add('hidden')
                    }
                })
            }
            else {
                Array.from(allBooks).map((book) => {
                    book.classList.remove('hidden')
                })
            }
        })

    }
}

/* Page detail book */

if (action === 'detailBook') {
    const dialog = document.querySelector('dialog')
    const btn = document.querySelector('button')
    const closeBtn = document.querySelector('.close_button')
    const form = dialog.querySelector('form')
    const sendConfirmation = dialog.querySelector("#send_confirmation")


    /* Gestion de la modale :*/
    btn.addEventListener('click', () => {
        dialog.showModal()
    })
    closeBtn.addEventListener('click', () => {

        dialog.close()
    })

    /* Envoi requête AJAX*/
    const submitBtn = document.querySelector('button[type="dialog"]')

    submitBtn.addEventListener('click', (e) => {
        e.preventDefault()
        const message = document.querySelector('#message').value
        const idReceiver = submitBtn.getAttribute('data-idReceiver')
        const ajaxRequest = new XMLHttpRequest()
        ajaxRequest.open('POST', `index.php?action=sendMessage&ajax&idReceiver=${idReceiver}`, true)
        ajaxRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

        ajaxRequest.onload = () => {
            if (ajaxRequest.status === 200 && ajaxRequest.readyState === 4 && ajaxRequest.responseText === 'success') {
                form.classList.add('success')
            }
            else {
                form.classList.add('error')
            }
        }
        ajaxRequest.send(`message=${message}`)
    })
}