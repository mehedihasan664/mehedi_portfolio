function closeMobileMenu() {
    const menu = document.querySelector('[data-mobile-menu]');
    const toggle = document.querySelector('[data-mobile-menu-toggle]');

    menu?.classList.add('hidden');
    toggle?.setAttribute('aria-expanded', 'false');
    toggle?.setAttribute('aria-label', 'Open navigation menu');
    document.querySelector('[data-menu-icon="open"]')?.classList.remove('hidden');
    document.querySelector('[data-menu-icon="close"]')?.classList.add('hidden');
}

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-mobile-menu-toggle]');

    if (toggle) {
        const menu = document.querySelector('[data-mobile-menu]');
        const opening = menu?.classList.contains('hidden');

        menu?.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', String(opening));
        toggle.setAttribute('aria-label', opening ? 'Close navigation menu' : 'Open navigation menu');
        document.querySelector('[data-menu-icon="open"]')?.classList.toggle('hidden', opening);
        document.querySelector('[data-menu-icon="close"]')?.classList.toggle('hidden', !opening);
        return;
    }

    if (event.target.closest('[data-mobile-menu] a') || !event.target.closest('[data-mobile-menu]')) {
        closeMobileMenu();
    }
});

document.addEventListener('change', (event) => {
    const input = event.target;

    if (!(input instanceof HTMLInputElement) || !input.matches('[data-profile-photo-input]')) {
        return;
    }

    const file = input.files?.[0];
    const preview = document.querySelector('[data-profile-photo-preview]');
    const emptyState = document.querySelector('[data-profile-photo-empty]');
    const fileName = document.querySelector('[data-profile-photo-name]');

    if (!(preview instanceof HTMLImageElement) || !file) {
        return;
    }

    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
    emptyState?.classList.add('hidden');

    if (fileName) {
        fileName.textContent = `Ready to upload: ${file.name}`;
        fileName.classList.remove('hidden');
    }
});

document.addEventListener('submit', async (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || !form.matches('[data-profile-photo-form]')) {
        return;
    }

    const input = form.querySelector('[data-profile-photo-input]');
    const button = form.querySelector('[data-profile-photo-button]');
    const status = document.querySelector('[data-profile-photo-status]');

    if (!(input instanceof HTMLInputElement) || !input.files?.[0]) {
        return;
    }

    const file = input.files[0];

    if (!file.type.startsWith('image/')) {
        return;
    }

    event.preventDefault();

    try {
        setUploadStatus(status, button, 'Compressing photo...');

        const compressed = await compressImage(file);
        const files = new DataTransfer();
        files.items.add(compressed);
        input.files = files.files;

        setUploadStatus(status, button, 'Uploading photo...');
        form.submit();
    } catch {
        if (file.size <= 1_800_000) {
            setUploadStatus(status, button, 'Uploading photo...');
            form.submit();
            return;
        }

        setUploadStatus(status, button, 'Could not process this photo. Please choose a JPG, PNG, or WebP image under 2MB.', false);
    }
});

async function compressImage(file) {
    const image = await loadImage(file);
    const canvas = document.createElement('canvas');
    const maxSize = 1600;
    let scale = Math.min(1, maxSize / Math.max(image.width, image.height));

    let blob;

    do {
        canvas.width = Math.max(1, Math.round(image.width * scale));
        canvas.height = Math.max(1, Math.round(image.height * scale));

        const context = canvas.getContext('2d');
        context.drawImage(image, 0, 0, canvas.width, canvas.height);

        let quality = 0.86;
        blob = await canvasToBlob(canvas, quality);

        while (blob.size > 1_800_000 && quality > 0.46) {
            quality -= 0.08;
            blob = await canvasToBlob(canvas, quality);
        }

        scale *= 0.8;
    } while (blob.size > 1_800_000 && canvas.width > 480 && canvas.height > 480);

    if (blob.size > 1_800_000) {
        throw new Error('Could not compress photo below the upload limit.');
    }

    const name = file.name.replace(/\.[^.]+$/, '') || 'profile-photo';

    return new File([blob], `${name}.jpg`, {
        type: 'image/jpeg',
        lastModified: Date.now(),
    });
}

function loadImage(file) {
    return new Promise((resolve, reject) => {
        const image = new Image();
        image.onload = () => resolve(image);
        image.onerror = reject;
        image.src = URL.createObjectURL(file);
    });
}

function canvasToBlob(canvas, quality) {
    return new Promise((resolve, reject) => {
        canvas.toBlob((blob) => {
            blob ? resolve(blob) : reject(new Error('Could not compress image.'));
        }, 'image/jpeg', quality);
    });
}

function setUploadStatus(status, button, message, disabled = true) {
    if (status) {
        status.textContent = message;
        status.classList.remove('hidden');
    }

    if (button instanceof HTMLButtonElement) {
        button.disabled = disabled;
    }
}
