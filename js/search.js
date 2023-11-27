// Searchbar searching function
function search() {
    var searchText = document.getElementById('searchInput').value.toLowerCase();
    var cards = document.getElementsByClassName('post-body');

    for (var i = 0; i < cards.length; i++) {
        var cardContent = cards[i].textContent.toLowerCase();
        var card = cards[i];

        if (cardContent.includes(searchText)) {
            card.style.display = 'block'; // display matching cards
        } else {
            card.style.display = 'none'; // hide non-matching cards
        }
    }
}
