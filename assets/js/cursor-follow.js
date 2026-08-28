(function () {
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

	const cursor = document.createElement('div');
	cursor.className = 'joint-cursor';
	cursor.innerHTML = '<img src="../assets/icons/joint-icon.svg" alt="joint-icon">';
	document.body.appendChild(cursor);

	const smokeLayer = document.createElement('div');
	smokeLayer.className = 'smoke-layer';
	document.body.appendChild(smokeLayer);

	let mouseX = window.innerWidth / 2;
	let mouseY = window.innerHeight / 2;
	let cursorX = mouseX;
	let cursorY = mouseY;
	let lastSpawn = 0;
	const spawnInterval = 90;

	document.addEventListener('mousemove', (e) => {
		mouseX = e.clientX;
		mouseY = e.clientY;
	});

	function spawnSmoke(x, y) {
		const puff = document.createElement('span');
		puff.className = 'smoke-puff';
		const drift = (Math.random() - 0.5) * 44;
		const spin = (Math.random() - 0.5) * 60;
		const size = 6 + Math.random() * 11;
		const duration = 850 + Math.random() * 550;
		puff.style.left = x + 'px';
		puff.style.top = y + 'px';
		puff.style.width = size + 'px';
		puff.style.height = size + 'px';
		puff.style.setProperty('--drift', drift + 'px');
		puff.style.setProperty('--spin', spin + 'deg');
		puff.style.animationDuration = duration + 'ms';
		smokeLayer.appendChild(puff);
		setTimeout(() => puff.remove(), duration);
	}

	function tick (timestamp) {
		cursorX += (mouseX - cursorX) * 0.18;
		cursorY += (mouseY - cursorY) * 0.18;
		cursor.style.transform = `translate(${cursorX}px, ${cursorY}px) rotate(-35deg)`;

		if (timestamp - lastSpawn > spawnInterval) {
			spawnSmoke(cursorX + 15, cursorY -5);
			lastSpawn = timestamp;
		}
		requestAnimationFrame(tick);
	}
	requestAnimationFrame(tick);
})();
