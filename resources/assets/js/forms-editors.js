/**
 * Form Editors
 */

'use strict';

(function () {
    /*
  // Snow Theme
  // --------------------------------------------------------------------
  const snowEditor = new Quill('#snow-editor', {
    bounds: '#snow-editor',
    modules: {
      formula: true,
      toolbar: '#snow-toolbar'
    },
    theme: 'snow'
  });

  // Bubble Theme
  // --------------------------------------------------------------------
  const bubbleEditor = new Quill('#bubble-editor', {
    modules: {
      toolbar: '#bubble-toolbar'
    },
    theme: 'bubble'
  });
quill.js

     */
    // Full Toolbar
    // --------------------------------------------------------------------
    if(document.getElementById('full-editor')){

        const fullToolbar = [
            [
                {
                    font: []
                },
                {
                    size: []
                }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [
                {
                    color: []
                },
                {
                    background: []
                }
            ],
            [
                {
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [
                {
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [
                {
                    list: 'ordered'
                },
                {
                    list: 'bullet'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [{direction: 'rtl'}],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];
        var fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'Type Something...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });

        var fullEditor_uk = new Quill('#full-editor_uk', {
            bounds: '#full-editor_uk',
            placeholder: 'Type Something...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });

        document.getElementById('add_faq').addEventListener('submit', function (e) {
            var htmlContent = fullEditor.root.innerHTML;
            document.getElementById('hidden-content').value = htmlContent;
            var htmlContent_uk = fullEditor_uk.root.innerHTML;
            document.getElementById('hidden-content_uk').value = htmlContent_uk;

        });

    }
})();
