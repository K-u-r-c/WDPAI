function toggleLeftBarBig() {
    var leftBarBig = document.querySelector('.left-bar-big');
    var rightPane = document.querySelector('.right-pane');
    var isMobile = window.innerWidth <= 1000;

    if (leftBarBig.offsetWidth > 0 || leftBarBig.offsetHeight > 0) {
        leftBarBig.style.display = 'none';

        if (isMobile) {
            rightPane.style.display = 'block';
            leftBarBig.style.width = '0';
        } else {
            rightPane.style.width = 'calc(100% - 3vw)';
        }
    } else {
        leftBarBig.style.display = 'block';
        
        if (isMobile) {
            rightPane.style.display = 'none';
            leftBarBig.style.width = '90vw';
        } else {
            rightPane.style.width = 'calc(100% - 18vw)';
        }
    }
}