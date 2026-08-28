(function () {
	const overlay = document.createElement('div');
	overlay.className = 'loading-overlay';
	overlay.innerHTML = '<img src="../assets/icons/joint-icon.svg" alt="joint icon" aria-hidden="true"><p>Lighting up another joint, hold on Diner Pothink!</p>';
	document.body.appendChild(overlay);

	document.querySelectorAll('a[href^="papi.php"]').forEach(function (link) {
		link.addEventListener('click', function () {
			overlay.classList.add('active');
		});
	});
})();
