document.getElementById('event_image').addEventListener('change', function (event) {
    const imagePreview = document.getElementById('image_preview');
    const resolutionText = document.getElementById('image_resolution');
    const resolutionWarning = document.getElementById('resolution_warning');
    const file = event.target.files[0];

    if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
        
        const img = new Image();
        img.src = URL.createObjectURL(file);
        img.onload = function () {
            const width = img.width;
            const height = img.height;
            resolutionText.textContent = `Resolution: ${width}x${height}`;
            resolutionText.style.display = 'block';
            
            if (width !== 1080 || height !== 720) {
                resolutionWarning.style.display = 'block';
            } else {
                resolutionWarning.style.display = 'none';
            }
        };
    } else {
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
        resolutionText.style.display = 'none';
        resolutionWarning.style.display = 'none';
    }
});

document.getElementById('createEventForm').addEventListener('submit', function (event) {
    const eventDate = new Date(document.getElementById('event_date').value);
    const startDate = new Date(document.getElementById('registration_start_date').value);
    const endDate = new Date(document.getElementById('registration_end_date').value);
    const fee = parseFloat(document.getElementById('registration_fee').value);
    const image = document.getElementById('event_image').files[0];

    if (startDate > endDate) {
        event.preventDefault();
        alert('Registration start date cannot be after end date.');
    }
    if (endDate > eventDate) {
        event.preventDefault();
        alert('Registration end date cannot be after event date.');
    }
    if (fee < 0) {
        event.preventDefault();
        alert('Registration fee cannot be negative.');
    }
    if (image) {
        const img = new Image();
        img.src = URL.createObjectURL(image);
        img.onload = function () {
            if (img.width !== 1080 || img.height !== 720) {
                event.preventDefault();
                alert('Image resolution must be 1080x720.');
            }
        };
    }
});