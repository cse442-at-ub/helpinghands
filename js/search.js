function search() {
    var searchText = document.getElementById('searchInput').value.toLowerCase();
    var cards = document.getElementsByClassName('post-body');

    for (var i = 0; i < cards.length; i++) {
        var cardContent = cards[i].textContent.toLowerCase();
        var card = cards[i];

        if (cardContent.includes(searchText)) {
            card.style.display = 'block'; // Display matching cards
        } else {
            card.style.display = 'none'; // Hide non-matching cards
        }
    }
}
