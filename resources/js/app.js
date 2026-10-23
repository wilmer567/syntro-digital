// Sytro Digital - Main Javascript
import './firebase';

const imageLightbox = document.querySelector('[data-image-lightbox]');

if (imageLightbox) {
	const lightboxImage = imageLightbox.querySelector('[data-lightbox-image]');
	const lightboxCaption = imageLightbox.querySelector('[data-lightbox-caption]');
	const lightboxCounter = imageLightbox.querySelector('[data-lightbox-counter]');
	const previousButton = imageLightbox.querySelector('[data-lightbox-prev]');
	const nextButton = imageLightbox.querySelector('[data-lightbox-next]');
	let galleryImages = [];
	let activeImageIndex = 0;

	const showImage = (index) => {
		activeImageIndex = (index + galleryImages.length) % galleryImages.length;
		const image = galleryImages[activeImageIndex];
		lightboxImage.src = image.currentSrc || image.src;
		lightboxImage.alt = image.alt || 'Imagen del proyecto';
		lightboxCaption.textContent = image.dataset.imageCaption || image.alt || '';
		lightboxCounter.textContent = `${activeImageIndex + 1} / ${galleryImages.length}`;
		previousButton.hidden = galleryImages.length < 2;
		nextButton.hidden = galleryImages.length < 2;
	};

	const openImage = (image) => {
		const gallery = image.closest('[data-image-gallery]');
		galleryImages = Array.from(gallery?.querySelectorAll('[data-fullscreen-image]') || []);

		if (!galleryImages.length) {
			galleryImages = [image];
		}

		showImage(galleryImages.indexOf(image));
		imageLightbox.showModal();
	};

	document.addEventListener('click', (event) => {
		const image = event.target.closest?.('[data-fullscreen-image]');
		if (image) {
			openImage(image);
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.target.matches?.('[data-fullscreen-image]') && (event.key === 'Enter' || event.key === ' ')) {
			event.preventDefault();
			openImage(event.target);
			return;
		}

		if (!imageLightbox.open) {
			return;
		}

		if (event.key === 'Escape') {
			event.preventDefault();
			imageLightbox.close();
		} else if (event.key === 'ArrowLeft' && galleryImages.length > 1) {
			showImage(activeImageIndex - 1);
		} else if (event.key === 'ArrowRight' && galleryImages.length > 1) {
			showImage(activeImageIndex + 1);
		}
	});

	previousButton.addEventListener('click', () => showImage(activeImageIndex - 1));
	nextButton.addEventListener('click', () => showImage(activeImageIndex + 1));
	imageLightbox.querySelector('[data-lightbox-close]').addEventListener('click', () => imageLightbox.close());
	imageLightbox.addEventListener('click', (event) => {
		if (!event.target.closest('button')) {
			imageLightbox.close();
		}
	});
	imageLightbox.addEventListener('close', () => {
		lightboxImage.removeAttribute('src');
	});
}
