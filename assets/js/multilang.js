(function(MIB, undefined){

    function extractLocaleFromElement(el)
    {
        return el && el.getAttribute && el.getAttribute('data-locale');
    }

    function isActiveLocale(el) {
        return el && el.classList && el.classList.contains('active');
    }

    function getFlagContainer(el)
    {
        return el && el.parentNode;
    }


    MIB.MultiLang = {
        init: function(inputId, locale)
        {
            var elementId = inputId + '_' + locale,
                element   = document.getElementById(elementId);

            if (!element) return;

            window.addEvent('domready', function(){
                setTimeout(function(){
                    var editor = tinyMCE.get(inputId);
                    editor.setContent(element.value);
                    editor.on('blur', function(e){
                        var input = document.getElementById(inputId),
                            parent = getClosest(input, '.mib-multi-lang'),
                            flags  = parent.getElementsByClassName('locales')[0],
                            flag   = flags.getElementsByClassName('active')[0],
                            locale = flag.getAttribute('data-locale'),
                            updateId = inputId + '_' + locale,
                            update = document.getElementById(updateId);

                        update.innerHTML = editor.getContent();
                    });

                }, 200);
            });
        },
        switchLocale: function(el) {

            if (isActiveLocale(el)) return;

            var locale = extractLocaleFromElement(el),
                flagContainer = getFlagContainer(el),
                multiLang = getClosest(el, '.mib-multi-lang');

            if (!multiLang) {
                console.log('multilang container not found');
                return;
            }

            var translationContainer = multiLang.getElementsByClassName('translations')[0];
            var controlContainer     = multiLang.getElementsByClassName('control')[0];

            if (!translationContainer||!controlContainer) {
                console.log('missing containers');
                return;
            }

            var lastLocale;

            for (var i = 0, l = flagContainer.childNodes.length; i < l; ++i) {
                var child = flagContainer.childNodes[i];
                if (child.tagName == 'SPAN' && child.classList.contains('active')) {
                    lastLocale = child.getAttribute('data-locale');
                    child.classList.remove('active');
                }
            }

            el.classList.add('active');

            var fieldId = controlContainer.id + '_' + locale;
            var field   = document.getElementById(fieldId);

            var input = controlContainer.getElementsByTagName('INPUT');
            if (!input.length) input = controlContainer.getElementsByTagName('TEXTAREA');

            if (input.length) {

                input = input[0];
                controlContainer.replaceChild(field, input);
                translationContainer.appendChild(input);
                return;
            }

            var oldFieldId = controlContainer.id + '_' + lastLocale;
            var oldField = document.getElementById(oldFieldId);

            oldField.innerHTML = tinyMCE.get(controlContainer.id).getContent();
            tinyMCE.get(controlContainer.id).setContent(field.value);


        }
    };

     function getClosest (elem, selector) {

        var firstChar = selector.charAt(0);

        // Get closest match
        for ( ; elem && elem !== document; elem = elem.parentNode ) {

            // If selector is a class
            if ( firstChar === '.' ) {
                if ( elem.classList.contains( selector.substr(1) ) ) {
                    return elem;
                }
            }

            // If selector is an ID
            if ( firstChar === '#' ) {
                if ( elem.id === selector.substr(1) ) {
                    return elem;
                }
            }

            // If selector is a data attribute
            if ( firstChar === '[' ) {
                if ( elem.hasAttribute( selector.substr(1, selector.length - 2) ) ) {
                    return elem;
                }
            }

            // If selector is a tag
            if ( elem.tagName.toLowerCase() === selector ) {
                return elem;
            }

        }

        return false;

    };

    function addLoadEvent(func)
    {
        var callback = window.onload;

        if (typeof callback !== 'function') {
            window.onload = func;
            return;
        }

        window.onload = function() {
            if (callback) {
                callback();
            }
            func();
        }
    }

})(MIB = window.MIB || {});