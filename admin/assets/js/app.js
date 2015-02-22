// ONLOAD
window.addEventListener("load", function() {
    image_preview();
    lightboxCustom();
    $(document).foundation();
}, false);



// SHORT QUERY SELECTOR
function _(el) {
    return document.querySelector(el);
}

//  MAKE FOLDER
function makeFolder(txt){
    var ask = prompt(txt);
    if(ask !== null){
        window.location.href='?nfd='+ask;
    }
}

// CONFIRM DELETE
function confirmDelete(msg) {
    var data = confirm(msg + " ?");
    return data;
}

function lightboxCustom() {
    var links = document.querySelectorAll('.lightCustom');
    if (links) {
        var arrayOfLinks = Array.prototype.slice.call(links);
        Array.prototype.forEach.call(arrayOfLinks, function(obj, index) {
            obj.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.lightModal').classList.add('show');
                document.querySelector('.lightModal-image').src = obj.href;
                document.querySelector('.lightModal-code').innerText = '<img src="' + obj.querySelector('img').src + '">';
            });
            document.querySelector('.lightModal-close').addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.lightModal').classList.remove('show');
                var t = setTimeout(function() {
                    document.querySelector('.lightModal-image').src = '';
                    document.querySelector('.lightModal-code').innerText = '';
                    clearTimeout(t);
                }, 300);

            });

        });
    }

}


/*!
 * -------------------------------------------------------
 *  http://stackoverflow.com/questions/19017401/how-to-store-and-retrieve-image-to-localstorage
 * -------------------------------------------------------
 */
function image_preview() {
    var imagePreview = (function() {
        'use strict';
        return {
            run: function() {
                console.log('init');
                var demo = _('#image-display').getAttribute('src'),
                    database = window.localStorage;
                if (!database.getItem("image-base64")) {
                    var t = setTimeout(function() {
                        database.setItem("image-base64", demo);
                        clearTimeout(t);
                    }, 100);
                }
                var imgInput = _("#image-input"),
                    imgContainer = _("#image-display"),
                    updateUi = function() {
                        var t2 = setTimeout(function() {
                            imgContainer.src = database.getItem("image-base64");
                            console.log(imgContainer.src);
                            database.clear();
                            clearTimeout(t2);
                        }, 200);
                    },
                    bindUi = function() {
                        imgInput.addEventListener("change", function() {
                            if (this.files.length) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    database.setItem("image-base64", e.target.result);
                                    updateUi();
                                };
                                reader.readAsDataURL(this.files[0]);
                            }
                        }, false);
                    };
                updateUi();
                bindUi();
            }
        }
    }());
    // IF IMAGE
    if (_('#image-display')) {
        // RUN FN
        imagePreview.run();
    }
}
