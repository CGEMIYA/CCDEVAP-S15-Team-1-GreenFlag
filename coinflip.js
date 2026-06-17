(function() {
    'use strict';

    const coin = document.getElementById('coin');
    const flipBtn = document.getElementById('flipBtn');
    const resultMessage = document.getElementById('resultMessage');
    const resultText = document.getElementById('resultText');

    let isFlipping = false;

    function flipCoin() {
        if (isFlipping) return;
        isFlipping = true;

        flipBtn.disabled = true;
        resultText.classList.remove('pop');

        const isHeads = Math.random() < 0.5;
        const rotations = 5 + Math.floor(Math.random() * 5);
        const degrees = isHeads ? 0 : 180;

        coin.style.transform = `rotateY(${(rotations * 360) + degrees}deg)`;
        coin.classList.add('flipping');

        setTimeout(() => {
            coin.classList.remove('flipping');
            isFlipping = false;
            flipBtn.disabled = false;

            if (isHeads) {
                resultMessage.innerHTML = '<span class="result-icon">🪙</span> Heads!';
            } else {
                resultMessage.innerHTML = '<span class="result-icon">🪙</span> Tails!';
            }

            resultText.classList.remove('pop');
            void resultText.offsetWidth;
            resultText.classList.add('pop');

        }, 1500);
    }

    function init() {
        flipBtn.addEventListener('click', flipCoin);
        coin.addEventListener('click', flipCoin);

        document.addEventListener('keydown', (e) => {
            if (e.key === ' ' && !e.repeat) {
                e.preventDefault();
                flipCoin();
            }
        });
    }

    init();

})();