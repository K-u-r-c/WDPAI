var statuses = [
    { color: '#FF833E', image: 'status1.svg', order: 1 },
    { color: '#6EBE45', image: 'status2.svg', order: 2 },
    { color: '#C0C0C0', image: 'status3.svg', order: 3 }
];

var forumElements = document.querySelector('.forum-elements');
var listItem = forumElements.querySelector('li');

var clonedElements = [];

function generateRandomText() {
    var words = ["Lorem", "ipsum", "dolor", "sit", "amet", "consectetur", "adipiscing", "elit", "Donec", "a", "diam", "lectus", "Sed", "sit", "amet", "ipsum", "mauris"];
    var text = "";
    for (var i = 0; i < 50; i++) {
        text += words[Math.floor(Math.random() * words.length)] + " ";
    }
    return text;
}

for (var i = 0; i < 100; i++) {
    var clone = listItem.cloneNode(true);

    var randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
    clone.dataset.statusOrder = randomStatus.order; // Add order to dataset for sorting

    var statusElement = clone.querySelector('.status-element');
    statusElement.style.backgroundColor = randomStatus.color;
    statusElement.style.backgroundImage = 'url("./../public/images/' + randomStatus.image + '")';

    var forumText = clone.querySelector('.forum-text');
    forumText.textContent = generateRandomText();

    var replies = clone.querySelectorAll('span')[0];
    replies.textContent = Math.floor(Math.random() * 100);

    var views = clone.querySelectorAll('span')[1];
    views.textContent = Math.floor(Math.random() * 1000);

    var date = clone.querySelectorAll('span')[2];
    date.textContent = new Date(2020 + Math.floor(Math.random() * 5), Math.floor(Math.random() * 12), Math.floor(Math.random() * 28)).toLocaleDateString();

    clonedElements.push(clone);
}

clonedElements.sort(function(a, b) {
    return a.dataset.statusOrder - b.dataset.statusOrder;
});

clonedElements.forEach(function(element) {
    forumElements.appendChild(element);
});

listItem.remove();