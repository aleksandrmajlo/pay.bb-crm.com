$(document).ready(function () {
    const $delete_rates=$('#delete_rates')
   $('#billiard_rate').change(function (e) { 
    let ch=$(this).prop('checked');
    if(ch){
        $('#billiard_rate_cont').show();
        if($delete_rates.length){
            $delete_rates.hide()
        }
    }else{
        $('#billiard_rate_cont').hide();
        if($delete_rates.length){
            $delete_rates.show()
        }
    }
   });
});

if(document.getElementById('add_faq')){

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

    let arr=[];
    for (let i = 0; i < editors.length; i++) {
        let fullEditor = new Quill('#'+editors[i], {
            bounds: '#'+editors[i],
            placeholder: 'Type Something...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });
        arr.push(fullEditor);
    }

    for (let i = 0; i < tags.length; i++) {
        let lang_slug=$('#'+tags[i]).data('lang');
        let whitelist=lang_tags[lang_slug];
        let TagifyCustomInlineSuggestion = new Tagify(document.getElementById(tags[i]), {
            whitelist: whitelist,
            maxTags: 200,
            dropdown: {
              maxItems: 200,
              classname: 'tags-inline',
              enabled: 0,
              closeOnSelect: false
            }
          });
    }
    
    console.clear();
    console.log(lang_tags)
    console.log(arr)

    document.getElementById('add_faq').addEventListener('submit', function (e) {
        // e.preventDefault();
        for (let i = 0; i < arr.length; i++) {
            let htmlContent = arr[i].root.innerHTML;
            document.getElementById(editors[i]+'_name').value = htmlContent;
        }
        // return false;
        // var htmlContent = fullEditor.root.innerHTML;
        // document.getElementById('hidden-content').value = htmlContent;
        // var htmlContent_uk = fullEditor_uk.root.innerHTML;
        // document.getElementById('hidden-content_uk').value = htmlContent_uk;

    });



}