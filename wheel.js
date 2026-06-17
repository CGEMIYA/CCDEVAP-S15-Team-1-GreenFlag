(function() {
    'use strict';

    const KILIG_LINES = [
        { text: "You're the WiFi to my heart — strong signal always!", emoji: "💕" },
        { text: "Are you a magician? Because whenever I look at you, everyone else disappears.", emoji: "✨" },
        { text: "Is your name Google? Because you have everything I'm searching for.", emoji: "😍" },
        { text: "You must be a parking ticket, 'cause you've got FINE written all over you.", emoji: "🔥" },
        { text: "If you were a vegetable, you'd be a cutecumber!", emoji: "😄" },
        { text: "Do you have a Band-Aid? Because I just scraped my knee falling for you.", emoji: "🥺" },
        { text: "You're the cheese to my macaroni.", emoji: "💛" },
        { text: "Is your dad a baker? 'Cause you're a cutie pie!", emoji: "🥰" },
        { text: "I must be a snowflake, because I've fallen for you.", emoji: "💙" },
        { text: "You're the 'she' in 'shelf' — I can't shelf my feelings for you!", emoji: "📖" },
        { text: "Are you a time traveler? Because I see you in my future.", emoji: "🌟" },
        { text: "You're so sweet, you're giving me a toothache!", emoji: "🦷" },
        { text: "Is your name Ariel? 'Cause I'd swim across the ocean for you.", emoji: "🌊" },
        { text: "You're the key to my heart, and I've lost the duplicate.", emoji: "🔐" },
        { text: "Are you a campfire? 'Cause you're hot and I want s'more.", emoji: "🏕️" },
        { text: "You're the 'B' in 'subtle' — because you're not subtle at all, you're amazing!", emoji: "💫" },
        { text: "Is it hot in here, or is it just you?", emoji: "🥵" },
        { text: "Do you have a map? I keep getting lost in your eyes.", emoji: "👀" },
        { text: "If you were a fruit, you'd be a fine-apple!", emoji: "😉" },
        { text: "You're the 'g' in 'gnat' — silent but irresistible.", emoji: "😆" },
        { text: "Are you a star? Because my night is brighter when you're around.", emoji: "🌙" },
        { text: "Is your name Dunkin'? 'Cause I donut think I can live without you.", emoji: "💕" },
        { text: "You must be a compass, because you always point me north — to you!", emoji: "🧲" },
        { text: "You're the 'C' in 'Cute' — and also the 'U' and the 'T' and the 'E'!", emoji: "💋" }
    ];

    const COLORS = [
        '#f43f5e', '#f59e0b', '#22c55e', '#3b82f6',
        '#a855f7', '#ec4899', '#14b8a6', '#f97316',
        '#8b5cf6', '#06b6d4', '#ef4444', '#84cc16'
    ];

    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');
    const resultText = document.getElementById('resultText');
    const resultMessage = document.getElementById('resultMessage');
    const historyList = document.getElementById('historyList');

    const spinBtn = document.getElementById('spinBtn');
    const spinBtnAlt = document.getElementById('spinBtnAlt');
    const resetBtn = document.getElementById('resetBtn');

    let currentRotation = 0;
    let isSpinning = false;
    let selectedIndex = 0;
    let history = [];

    const segments = KILIG_LINES.map((item, i) => ({
        ...item,
        color: COLORS[i % COLORS.length]
    }));

    const segmentCount = segments.length;
    const arcSize = (2 * Math.PI) / segmentCount;

    function drawWheel(rotation) {
        const w = canvas.width;
        const h = canvas.height;
        const radius = Math.min(w, h) / 2;
        const centerX = w / 2;
        const centerY = h / 2;

        ctx.clearRect(0, 0, w, h);

        for (let i = 0; i < segmentCount; i++) {
            const startAngle = i * arcSize + rotation;
            const endAngle = startAngle + arcSize;

            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startAngle, endAngle);
            ctx.closePath();

            ctx.fillStyle = segments[i].color;
            ctx.fill();

            ctx.lineWidth = 2;
            ctx.strokeStyle = 'rgba(255,255,255,0.3)';
            ctx.stroke();

            const midAngle = startAngle + arcSize / 2;
            const textRadius = radius * 0.65;
            const x = centerX + Math.cos(midAngle) * textRadius;
            const y = centerY + Math.sin(midAngle) * textRadius;

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(midAngle + Math.PI / 2);

            let label = segments[i].text;
            if (label.length > 12) label = label.substring(0, 10) + '…';

            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 18px -apple-system, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.shadowColor = 'rgba(0,0,0,0.4)';
            ctx.shadowBlur = 8;
            ctx.fillText(label, 0, 0);

            ctx.restore();
        }

        ctx.beginPath();
        ctx.arc(centerX, centerY, 32, 0, 2 * Math.PI);
        ctx.fillStyle = 'rgba(255,255,255,0.92)';
        ctx.fill();
        ctx.lineWidth = 3;
        ctx.strokeStyle = '#f43f5e';
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(centerX - 14, 10);
        ctx.lineTo(centerX + 14, 10);
        ctx.lineTo(centerX, 34);
        ctx.closePath();
        ctx.fillStyle = '#f43f5e';
        ctx.fill();
        ctx.shadowBlur = 0;
    }

    function getWinningIndex(rotation) {
        const pointerAngle = -Math.PI / 2;
        let rawAngle = (pointerAngle - rotation) % (2 * Math.PI);
        if (rawAngle < 0) rawAngle += 2 * Math.PI;
        const index = Math.floor(rawAngle / arcSize) % segmentCount;
        return index;
    }

    function spinWheel() {
        if (isSpinning) return;
        isSpinning = true;

        spinBtn.disabled = true;
        spinBtnAlt.disabled = true;

        resultText.classList.remove('pop');

        const extraSpins = 5 + Math.random() * 5;
        const randomOffset = Math.random() * 2 * Math.PI;
        const targetRotation = currentRotation + extraSpins * 2 * Math.PI + randomOffset;

        const startRotation = currentRotation;
        const duration = 4000 + Math.random() * 1500;
        const startTime = performance.now();

        function animateSpin(time) {
            const elapsed = time - startTime;
            const progress = Math.min(elapsed / duration, 1);

            const eased = 1 - Math.pow(1 - progress, 3);
            const current = startRotation + (targetRotation - startRotation) * eased;

            currentRotation = current;
            drawWheel(current);

            if (progress < 1) {
                requestAnimationFrame(animateSpin);
            } else {
                currentRotation = targetRotation;
                drawWheel(currentRotation);

                const winIndex = getWinningIndex(currentRotation);
                selectedIndex = winIndex;
                const win = segments[winIndex];

                resultMessage.textContent = win.text;
                resultText.classList.remove('pop');
                void resultText.offsetWidth;
                resultText.classList.add('pop');

                addHistory(win);

                isSpinning = false;
                spinBtn.disabled = false;
                spinBtnAlt.disabled = false;
            }
        }

        requestAnimationFrame(animateSpin);
    }

    function addHistory(item) {
        history.unshift(item);
        if (history.length > 10) history.pop();
        renderHistory();
    }

    function renderHistory() {
        if (history.length === 0) {
            historyList.innerHTML =
                '<span style="color: var(--text-muted); font-size: 0.9rem;">Spin to see some kilig lines!</span>';
            return;
        }
        historyList.innerHTML = history.map(item =>
            `<span class="history-tag"><span class="heart">❤️</span> ${item.text.substring(0, 35)}${item.text.length > 35 ? '…' : ''}</span>`
        ).join('');
    }

    function resetHistory() {
        history = [];
        renderHistory();
        resultMessage.textContent = 'Ready to spin!';
        resultText.classList.remove('pop');
    }

    function resetWheel() {
        if (isSpinning) return;
        currentRotation = 0;
        drawWheel(0);
        resultMessage.textContent = 'Ready to spin!';
        resultText.classList.remove('pop');
    }

    function init() {
        drawWheel(0);
        renderHistory();

        spinBtn.addEventListener('click', spinWheel);
        spinBtnAlt.addEventListener('click', spinWheel);
        resetBtn.addEventListener('click', () => {
            resetWheel();
            resetHistory();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === ' ' && !e.repeat) {
                e.preventDefault();
                spinWheel();
            }
        });

        canvas.addEventListener('click', spinWheel);
    }

    function resizeCanvas() {
        const container = canvas.parentElement;
        const rect = container.getBoundingClientRect();
    }

    window.addEventListener('resize', resizeCanvas);

    init();

})();