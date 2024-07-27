const urlParams = new URLSearchParams(window.location.search);
const action = urlParams.get('action');

if (action === 'market') {
    searchBar = document.querySelector('.search_bar');
    console.log(searchBar)
    if (searchBar) {
        allBooks = document.querySelectorAll('figure');
        console.log(allBooks)
        searchBar.addEventListener('input', (e) => {
            value = e.target.value.trim()
            console.log(value)
            if (value.length > 2) {
                Array.from(allBooks).map((book) => {
                    title = book.querySelector('figcaption h3').textContent.toLowerCase();
                    if(!title.includes(value.toLowerCase())){
                        book.classList.add('hidden')
                    }
                })
            }
            else{
                Array.from(allBooks).map((book) => {
                    book.classList.remove('hidden')
                })
            }
        })

    }
}