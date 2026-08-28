(function () {
	document.querySelectorAll('.merch-card').forEach(function (card) {
		card.addEventListener('mousemove', function (e) {
			var rect = card.getBoundingClientRect();
			var x = e.clientX - rect.left;
			var y = e.clientY - rect.top;
			var centerX = rect.width / 2;
			var centerY = rect.height / 2;
			var rotateX = ((y - centerY) / centerY) * -8;
			var rotateY = ((x - centerX) / centerX) * 8;
			card.style.transform = 'perspective(800px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale(1.03)';
		});
		card.addEventListener('mouseleave', function () {
			card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)';
		});
	});
})();
