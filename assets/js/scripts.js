document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('editor')) {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
            })
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
    }
});

ClassicEditor
    .create(document.querySelector('#editor'), {
        // ... другие настройки ...
        image: {
            toolbar: [
                'imageTextAlternative',
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                'toggleImageCaption',
                'imageResize'
            ],
            styles: [
                'full',
                'side',
                'alignLeft',
                'alignRight'
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });