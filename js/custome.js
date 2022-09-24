function myFunction() {
    var x = document.getElementById('ul');

    if (x.className === 'nav') {
        x.className += ' slide';
    } else {
        x.className = 'nav';
    }
}

